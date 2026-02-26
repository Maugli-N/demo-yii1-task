<h1><?php echo CHtml::encode($author->name); ?></h1>

<p>
    <a href="<?php echo $this->createUrl(
        'author/subscribe',
        array('id' => $author->id)
    ); ?>">
        Подписаться на новые книги
    </a>
</p>

<?php if (!Yii::app()->user->isGuest): ?>
    <p>
        <a href="<?php echo $this->createUrl(
            'author/update',
            array('id' => $author->id)
        ); ?>">Редактировать</a>
        |
        <a href="<?php echo $this->createUrl(
            'author/delete',
            array('id' => $author->id)
        ); ?>"
           onclick="return confirm('Удалить автора?');">
            Удалить
        </a>
    </p>
<?php endif; ?>

<h3>Книги автора</h3>
<?php if (empty($author->books)): ?>
    <p>Книг пока нет.</p>
<?php else: ?>
    <ul>
        <?php foreach ($author->books as $book): ?>
            <li>
                <a href="<?php echo $this->createUrl(
                    'book/view',
                    array('id' => $book->id)
                ); ?>">
                    <?php echo CHtml::encode($book->title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
