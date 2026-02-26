<?php

class m000000_000000_init extends CDbMigration
{
    /**
     * Применяет миграцию.
     *
     * @result void - создаёт таблицы и комментарии
     */
    public function safeUp()
    {
        $tableOptions = 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4';

        $this->createTable('users', array(
            'id' => 'pk',
            'username' => 'varchar(64) NOT NULL',
            'password_hash' => 'varchar(255) NOT NULL',
            'role' => "varchar(16) NOT NULL DEFAULT 'user'",
            'created_at' => 'datetime NOT NULL',
        ), $tableOptions);
        $this->createIndex('ux_users_username', 'users', 'username', true);
        $this->addComment('users', null, 'Пользователи системы');
        $this->addComment('users', 'id', 'Идентификатор пользователя');
        $this->addComment('users', 'username', 'Логин пользователя');
        $this->addComment(
            'users',
            'password_hash',
            'Хэш пароля пользователя'
        );
        $this->addComment('users', 'role', 'Роль пользователя');
        $this->addComment(
            'users',
            'created_at',
            'Дата создания пользователя'
        );

        $this->createTable('authors', array(
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
        ), $tableOptions);
        $this->addComment('authors', null, 'Авторы книг');
        $this->addComment('authors', 'id', 'Идентификатор автора');
        $this->addComment('authors', 'name', 'ФИО автора');

        $this->createTable('books', array(
            'id' => 'pk',
            'title' => 'varchar(255) NOT NULL',
            'year' => 'int NOT NULL',
            'description' => 'text',
            'isbn' => 'varchar(32) NOT NULL',
            'cover_path' => 'varchar(255)',
            'created_at' => 'datetime NOT NULL',
        ), $tableOptions);
        $this->createIndex('ux_books_isbn', 'books', 'isbn', true);
        $this->createIndex('ix_books_year', 'books', 'year');
        $this->addComment('books', null, 'Книги');
        $this->addComment('books', 'id', 'Идентификатор книги');
        $this->addComment('books', 'title', 'Название книги');
        $this->addComment('books', 'year', 'Год выпуска');
        $this->addComment('books', 'description', 'Описание книги');
        $this->addComment('books', 'isbn', 'ISBN книги');
        $this->addComment('books', 'cover_path', 'Путь к обложке');
        $this->addComment(
            'books',
            'created_at',
            'Дата добавления книги'
        );

        $this->createTable('book_author', array(
            'book_id' => 'int NOT NULL',
            'author_id' => 'int NOT NULL',
            'PRIMARY KEY (book_id, author_id)',
        ), $tableOptions);
        $this->addComment(
            'book_author',
            null,
            'Связь книг и авторов'
        );
        $this->addComment(
            'book_author',
            'book_id',
            'Идентификатор книги'
        );
        $this->addComment(
            'book_author',
            'author_id',
            'Идентификатор автора'
        );

        $this->createTable('subscriptions', array(
            'id' => 'pk',
            'author_id' => 'int NOT NULL',
            'phone' => 'varchar(32) NOT NULL',
            'created_at' => 'datetime NOT NULL',
        ), $tableOptions);
        $this->createIndex(
            'ux_subscriptions_author_phone',
            'subscriptions',
            'author_id, phone',
            true
        );
        $this->addComment(
            'subscriptions',
            null,
            'Подписки гостей на авторов'
        );
        $this->addComment(
            'subscriptions',
            'id',
            'Идентификатор подписки'
        );
        $this->addComment(
            'subscriptions',
            'author_id',
            'Идентификатор автора'
        );
        $this->addComment(
            'subscriptions',
            'phone',
            'Телефон подписчика'
        );
        $this->addComment(
            'subscriptions',
            'created_at',
            'Дата подписки'
        );
    }

    /**
     * Откатывает миграцию.
     *
     * @result void - удаляет таблицы
     */
    public function safeDown()
    {
        $this->dropTable('subscriptions');
        $this->dropTable('book_author');
        $this->dropTable('books');
        $this->dropTable('authors');
        $this->dropTable('users');
    }

    /**
     * Добавляет комментарий к таблице или колонке.
     *
     * @param string $table - имя таблицы
     * @param string|null $column - имя колонки или null для таблицы
     * @param string $comment - текст комментария
     *
     * @result void - выполняет SQL-команду изменения комментария
     */
    protected function addComment($table, $column, $comment)
    {
        $commentSql = $this->dbConnection->quoteValue($comment);

        if ($column === null) {
            $sql = 'ALTER TABLE `' . $table . '` COMMENT='
                . $commentSql;
            $this->execute($sql);
            return;
        }

        $schema = $this->dbConnection->getSchema()->getTable($table);
        if ($schema === null || !isset($schema->columns[$column])) {
            return;
        }

        $col = $schema->columns[$column];
        $type = $col->dbType;
        $null = $col->allowNull ? 'NULL' : 'NOT NULL';
        $default = '';
        if ($col->defaultValue !== null) {
            $default = ' DEFAULT '
                . $this->dbConnection->quoteValue($col->defaultValue);
        } elseif ($col->allowNull) {
            $default = ' DEFAULT NULL';
        }
        $autoIncrement = $col->autoIncrement ? ' AUTO_INCREMENT' : '';

        $sql = 'ALTER TABLE `' . $table . '` MODIFY `' . $column . '` '
            . $type . ' ' . $null . $default . $autoIncrement
            . ' COMMENT ' . $commentSql;
        $this->execute($sql);
    }
}
