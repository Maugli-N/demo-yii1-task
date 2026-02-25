<?php

class AuthorController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('index', 'view', 'subscribe'), 'users' => array('*')),
            array('allow', 'actions' => array('create', 'update', 'delete'), 'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.name ASC';
        $authors = Author::model()->findAll($criteria);
        $this->render('index', array('authors' => $authors));
    }

    public function actionView($id)
    {
        $author = $this->loadModel($id);
        $this->render('view', array('author' => $author));
    }

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

    public function actionDelete($id)
    {
        $author = $this->loadModel($id);
        $author->delete();
        $this->redirect(array('index'));
    }

    public function actionSubscribe($id)
    {
        $author = $this->loadModel($id);
        $subscription = new Subscription();
        $subscription->author_id = $author->id;

        if (isset($_POST['Subscription'])) {
            $subscription->attributes = $_POST['Subscription'];
            $subscription->author_id = $author->id;
            if ($subscription->save()) {
                Yii::app()->user->setFlash('success', 'Подписка оформлена.');
                $this->redirect(array('view', 'id' => $author->id));
            }
        }

        $this->render('subscribe', array(
            'author' => $author,
            'subscription' => $subscription,
        ));
    }

    protected function loadModel($id)
    {
        $author = Author::model()->findByPk($id);
        if ($author === null) {
            throw new CHttpException(404, 'Автор не найден.');
        }
        return $author;
    }
}
