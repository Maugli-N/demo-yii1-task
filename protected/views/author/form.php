<h1><?php echo $author->isNewRecord ? 'Добавить автора' : 'Редактировать автора'; ?></h1>

<?php echo CHtml::errorSummary($author); ?>

<?php echo CHtml::form('', 'post'); ?>
    <p>
        <?php echo CHtml::activeLabel($author, 'name'); ?><br>
        <?php echo CHtml::activeTextField($author, 'name'); ?>
    </p>
    <p>
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </p>
<?php echo CHtml::endForm(); ?>
