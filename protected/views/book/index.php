<h1>Книги</h1>

<?php if (!Yii::app()->user->isGuest): ?>
    <p>
        <a href="<?php echo $this->createUrl('book/create'); ?>">
            Добавить книгу
        </a>
    </p>
<?php endif; ?>

<?php if (empty($books)): ?>
    <p>Книги отсутствуют.</p>
<?php else: ?>
    <ul>
        <?php foreach ($books as $book): ?>
            <li>
                <a href="<?php echo $this->createUrl(
                    'book/view',
                    array('id' => $book->id)
                ); ?>">
                    <?php echo CHtml::encode($book->title); ?>
                </a>
                (<?php echo CHtml::encode($book->year); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
