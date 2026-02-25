<?php

class BookController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('index', 'view'), 'users' => array('*')),
            array('allow', 'actions' => array('create', 'update', 'delete'), 'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $books = Book::model()->findAll($criteria);
        $this->render('index', array('books' => $books));
    }

    public function actionView($id)
    {
        $book = $this->loadModel($id);
        $this->render('view', array('book' => $book));
    }

    public function actionCreate()
    {
        $book = new Book();
        $authors = Author::model()->findAll();

        if (isset($_POST['Book'])) {
            $book->attributes = $_POST['Book'];
            $book->author_ids = isset($_POST['Book']['author_ids']) ? $_POST['Book']['author_ids'] : array();
            $book->coverFile = CUploadedFile::getInstance($book, 'coverFile');

            if ($book->validate()) {
                $this->handleCoverUpload($book);

                if ($book->save()) {
                    $this->syncAuthors($book, $book->author_ids);
                    $this->notifySubscribers($book);
                    $this->redirect(array('view', 'id' => $book->id));
                }
            }
        }

        $this->render('form', array(
            'book' => $book,
            'authors' => $authors,
        ));
    }

    public function actionUpdate($id)
    {
        $book = $this->loadModel($id);
        $authors = Author::model()->findAll();
        $book->author_ids = CHtml::listData($book->authors, 'id', 'id');

        if (isset($_POST['Book'])) {
            $book->attributes = $_POST['Book'];
            $book->author_ids = isset($_POST['Book']['author_ids']) ? $_POST['Book']['author_ids'] : array();
            $book->coverFile = CUploadedFile::getInstance($book, 'coverFile');

            if ($book->validate()) {
                $this->handleCoverUpload($book);

                if ($book->save()) {
                    $this->syncAuthors($book, $book->author_ids);
                    $this->redirect(array('view', 'id' => $book->id));
                }
            }
        }

        $this->render('form', array(
            'book' => $book,
            'authors' => $authors,
        ));
    }

    public function actionDelete($id)
    {
        $book = $this->loadModel($id);
        $book->delete();
        $this->redirect(array('index'));
    }

    protected function loadModel($id)
    {
        $book = Book::model()->with('authors')->findByPk($id);
        if ($book === null) {
            throw new CHttpException(404, 'Книга не найдена.');
        }
        return $book;
    }

    protected function syncAuthors(Book $book, array $authorIds)
    {
        Yii::app()->db->createCommand()->delete('book_author', 'book_id = :id', array(':id' => $book->id));
        foreach ($authorIds as $authorId) {
            Yii::app()->db->createCommand()->insert('book_author', array(
                'book_id' => $book->id,
                'author_id' => (int)$authorId,
            ));
        }
    }

    protected function handleCoverUpload(Book $book)
    {
        if ($book->coverFile === null) {
            return;
        }

        $uploadDir = Yii::app()->params['uploadDir'];
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid('cover_', true) . '.' . $book->coverFile->getExtensionName();
        $path = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
        if ($book->coverFile->saveAs($path)) {
            $book->cover_path = 'uploads/' . $fileName;
        }
    }

    protected function notifySubscribers(Book $book)
    {
        $authorIds = Yii::app()->db->createCommand()
            ->select('author_id')
            ->from('book_author')
            ->where('book_id = :id', array(':id' => $book->id))
            ->queryColumn();

        if (empty($authorIds)) {
            return;
        }

        $phones = Yii::app()->db->createCommand()
            ->selectDistinct('phone')
            ->from('subscriptions')
            ->where('author_id IN (' . implode(',', array_map('intval', $authorIds)) . ')')
            ->queryColumn();

        if (empty($phones)) {
            return;
        }

        $client = new SmsPilotClient();
        foreach ($phones as $phone) {
            $message = 'Новая книга у автора: ' . $book->title;
            $client->send($phone, $message);
        }
    }
}
