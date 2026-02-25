<?php

class ReportController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('topAuthors'), 'users' => array('*')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionTopAuthors()
    {
        $year = Yii::app()->request->getParam('year');
        $year = $year !== null ? (int)$year : null;

        $rows = array();
        if ($year !== null) {
            $rows = Yii::app()->db->createCommand()
                ->select('a.id, a.name, COUNT(ba.book_id) AS books_count')
                ->from('authors a')
                ->join('book_author ba', 'ba.author_id = a.id')
                ->join('books b', 'b.id = ba.book_id')
                ->where('b.year = :year', array(':year' => $year))
                ->group('a.id, a.name')
                ->order('books_count DESC')
                ->limit(10)
                ->queryAll();
        }

        $this->render('topAuthors', array(
            'year' => $year,
            'rows' => $rows,
        ));
    }
}
