<h1>ТОП‑10 авторов по количеству книг за год</h1>

<?php echo CHtml::form('', 'get'); ?>
    <p>
        <?php echo CHtml::label('Год', 'year'); ?>
        <?php echo CHtml::textField('year', $year); ?>
        <?php echo CHtml::submitButton('Показать'); ?>
    </p>
<?php echo CHtml::endForm(); ?>

<?php if ($year === null): ?>
    <p>Введите год и нажмите «Показать».</p>
<?php else: ?>
    <?php if (empty($rows)): ?>
        <p>Нет данных за <?php echo CHtml::encode($year); ?>.</p>
    <?php else: ?>
        <ol>
            <?php foreach ($rows as $row): ?>
                <li>
                    <?php echo CHtml::encode($row['name']); ?> —
                    <?php echo CHtml::encode($row['books_count']); ?>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
<?php endif; ?>
