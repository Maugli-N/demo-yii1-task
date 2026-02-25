<h1><?php echo CHtml::encode($book->title); ?></h1>

<p><strong>Год:</strong> <?php echo CHtml::encode($book->year); ?></p>
<p><strong>ISBN:</strong> <?php echo CHtml::encode($book->isbn); ?></p>
<p><strong>Описание:</strong> <?php echo CHtml::encode($book->description); ?></p>

<?php if (!empty($book->cover_path)): ?>
    <p><strong>Обложка:</strong></p>
    <img src="/<?php echo CHtml::encode($book->cover_path); ?>" alt="cover" style="max-width:200px;">
<?php endif; ?>

<p><strong>Авторы:</strong>
<?php if (!empty($book->authors)): ?>
    <?php foreach ($book->authors as $author): ?>
        <a href="<?php echo $this->createUrl('author/view', array('id' => $author->id)); ?>">
            <?php echo CHtml::encode($author->name); ?>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <span>не указаны</span>
<?php endif; ?>
</p>

<?php if (!Yii::app()->user->isGuest): ?>
    <p>
        <a href="<?php echo $this->createUrl('book/update', array('id' => $book->id)); ?>">Редактировать</a>
        |
        <a href="<?php echo $this->createUrl('book/delete', array('id' => $book->id)); ?>"
           onclick="return confirm('Удалить книгу?');">Удалить</a>
    </p>
<?php endif; ?>
