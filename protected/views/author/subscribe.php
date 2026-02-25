<h1>Подписка на автора: <?php echo CHtml::encode($author->name); ?></h1>

<?php echo CHtml::errorSummary($subscription); ?>

<?php echo CHtml::form('', 'post'); ?>
    <p>
        <?php echo CHtml::activeLabel($subscription, 'phone'); ?><br>
        <?php echo CHtml::activeTextField($subscription, 'phone'); ?>
    </p>
    <p>
        <?php echo CHtml::submitButton('Подписаться'); ?>
    </p>
<?php echo CHtml::endForm(); ?>
