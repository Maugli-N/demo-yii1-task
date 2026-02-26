<?php

class SiteController extends Controller
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
                'actions' => array('login'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'actions' => array('logout'),
                'users' => array('@'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Отображает форму входа и выполняет авторизацию.
     *
     * @result void - обрабатывает форму входа
     */
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

    /**
     * Выполняет выход пользователя.
     *
     * @result void - завершает сессию пользователя
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('book/index'));
    }
}
