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
                'actions' => array('login', 'register'),
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
     * Отображает форму регистрации и создаёт пользователя.
     *
     * @result void - обрабатывает форму регистрации
     */
    public function actionRegister()
    {
        $model = new User('insert');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->password = isset($_POST['User']['password'])
                ? $_POST['User']['password']
                : null;
            $model->role = 'user';

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    'success',
                    'Регистрация завершена. Войдите в систему.'
                );
                $this->redirect(array('site/login'));
            }
        }

        $this->render('register', array('model' => $model));
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
