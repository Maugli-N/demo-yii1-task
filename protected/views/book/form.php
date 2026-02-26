<h1>
    <?php echo $book->isNewRecord
        ? 'Добавить книгу'
        : 'Редактировать книгу'; ?>
</h1>

<?php echo CHtml::errorSummary($book); ?>

<?php echo CHtml::form(
    '',
    'post',
    array('enctype' => 'multipart/form-data')
); ?>
    <p>
        <?php echo CHtml::activeLabel($book, 'title'); ?><br>
        <?php echo CHtml::activeTextField($book, 'title'); ?>
    </p>
    <p>
        <?php echo CHtml::activeLabel($book, 'year'); ?><br>
        <?php echo CHtml::activeTextField($book, 'year'); ?>
    </p>
    <p>
        <?php echo CHtml::activeLabel($book, 'isbn'); ?><br>
        <?php echo CHtml::activeTextField($book, 'isbn'); ?>
    </p>
    <p>
        <?php echo CHtml::activeLabel($book, 'description'); ?><br>
        <?php echo CHtml::activeTextArea($book, 'description'); ?>
    </p>
    <p>
        <?php echo CHtml::label('Авторы', 'authors'); ?><br>
        <?php echo CHtml::activeDropDownList(
            $book,
            'author_ids',
            CHtml::listData($authors, 'id', 'name'),
            array('multiple' => 'multiple', 'size' => 8)
        ); ?>
    </p>
    <p>
        <?php echo CHtml::activeLabel($book, 'coverFile'); ?><br>
        <?php echo CHtml::activeFileField($book, 'coverFile'); ?>
    </p>
    <p>
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </p>
<?php echo CHtml::endForm(); ?>
