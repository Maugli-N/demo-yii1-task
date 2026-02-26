<h1>Регистрация</h1>

<?php echo CHtml::errorSummary($model); ?>

<?php echo CHtml::form('', 'post'); ?>
    <p>
        <?php echo CHtml::activeLabel($model, 'username'); ?><br>
        <?php echo CHtml::activeTextField($model, 'username'); ?>
    </p>
    <p>
        <?php echo CHtml::activeLabel($model, 'password'); ?><br>
        <?php echo CHtml::activePasswordField($model, 'password'); ?>
    </p>
    <p>
        <?php echo CHtml::submitButton('Зарегистрироваться'); ?>
    </p>
<?php echo CHtml::endForm(); ?>
