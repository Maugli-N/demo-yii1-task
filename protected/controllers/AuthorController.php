<?php

class AuthorController extends Controller
{
    /**
     * Возвращает список фильтров контроллера.
     *
     * @result array - список фильтров
     */
    public function filters()
    {
        return array('accessControl');
    }

    /**
     * Возвращает правила доступа для действий.
     *
     * @result array - правила доступа
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index', 'view', 'subscribe'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Показывает список авторов.
     *
     * @result void - выводит страницу списка
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.name ASC';
        $authors = Author::model()->findAll($criteria);
        $this->render('index', array('authors' => $authors));
    }

    /**
     * Показывает карточку автора.
     *
     * @param int $id - идентификатор автора
     *
     * @result void - выводит страницу автора
     */
    public function actionView($id)
    {
        $author = $this->loadModel($id);
        $this->render('view', array('author' => $author));
    }

    /**
     * Создаёт нового автора.
     *
     * @result void - обрабатывает форму создания
     */
    public function actionCreate()
    {
        $author = new Author();
        if (isset($_POST['Author'])) {
            $author->attributes = $_POST['Author'];
            if ($author->save()) {
                $this->redirect(array('view', 'id' => $author->id));
            }
        }
        $this->render('form', array('author' => $author));
    }

    /**
     * Обновляет данные автора.
     *
     * @param int $id - идентификатор автора
     *
     * @result void - обрабатывает форму редактирования
     */
    public function actionUpdate($id)
    {
        $author = $this->loadModel($id);
        if (isset($_POST['Author'])) {
            $author->attributes = $_POST['Author'];
            if ($author->save()) {
                $this->redirect(array('view', 'id' => $author->id));
            }
        }
        $this->render('form', array('author' => $author));
    }

    /**
     * Удаляет автора.
     *
     * @param int $id - идентификатор автора
     *
     * @result void - выполняет удаление
     */
    public function actionDelete($id)
    {
        $author = $this->loadModel($id);
        $author->delete();
        $this->redirect(array('index'));
    }

    /**
     * Создаёт подписку гостя на автора.
     *
     * @param int $id - идентификатор автора
     *
     * @result void - обрабатывает форму подписки
     */
    public function actionSubscribe($id)
    {
        $author = $this->loadModel($id);
        $subscription = new Subscription();
        $subscription->author_id = $author->id;

        if (isset($_POST['Subscription'])) {
            $subscription->attributes = $_POST['Subscription'];
            $subscription->author_id = $author->id;
            if ($subscription->save()) {
                Yii::app()->user->setFlash(
                    'success',
                    'Подписка оформлена.'
                );
                $this->redirect(array('view', 'id' => $author->id));
            }
        }

        $this->render('subscribe', array(
            'author' => $author,
            'subscription' => $subscription,
        ));
    }

    /**
     * Загружает модель автора или выбрасывает ошибку.
     *
     * @param int $id - идентификатор автора
     *
     * @result Author - модель автора
     */
    protected function loadModel($id)
    {
        $author = Author::model()->findByPk($id);
        if ($author === null) {
            throw new CHttpException(404, 'Автор не найден.');
        }
        return $author;
    }
}
