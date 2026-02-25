<?php

class SiteController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('login'), 'users' => array('*')),
            array('allow', 'actions' => array('logout'), 'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(array('book/index'));
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('book/index'));
    }
}
