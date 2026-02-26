<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
    <div>
        <a href="<?php echo $this->createUrl('book/index'); ?>">
            Книги
        </a>
        |
        <a href="<?php echo $this->createUrl('author/index'); ?>">
            Авторы
        </a>
        |
        <a href="<?php echo $this->createUrl('report/topAuthors'); ?>">
            Отчет
        </a>
        <?php if (Yii::app()->user->isGuest): ?>
            |
            <a href="<?php echo $this->createUrl('site/login'); ?>">
                Вход
            </a>
            |
            <a href="<?php echo $this->createUrl('site/register'); ?>">
                Регистрация
            </a>
        <?php else: ?>
            |
            <a href="<?php echo $this->createUrl('site/logout'); ?>">
                Выход
            </a>
        <?php endif; ?>
    </div>

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div>
            <?php echo CHtml::encode(
                Yii::app()->user->getFlash('success')
            ); ?>
        </div>
    <?php endif; ?>

    <hr>
    <?php echo $content; ?>
</body>
</html>
