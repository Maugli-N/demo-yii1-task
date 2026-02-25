<h1>Авторы</h1>

<?php if (!Yii::app()->user->isGuest): ?>
    <p><a href="<?php echo $this->createUrl('author/create'); ?>">Добавить автора</a></p>
<?php endif; ?>

<?php if (empty($authors)): ?>
    <p>Авторы отсутствуют.</p>
<?php else: ?>
    <ul>
        <?php foreach ($authors as $author): ?>
            <li>
                <a href="<?php echo $this->createUrl('author/view', array('id' => $author->id)); ?>">
                    <?php echo CHtml::encode($author->name); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
