<?php

class m000000_000000_init extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('users', array(
            'id' => 'pk',
            'username' => 'varchar(64) NOT NULL',
            'password_hash' => 'varchar(255) NOT NULL',
            'role' => "varchar(16) NOT NULL DEFAULT 'user'",
            'created_at' => 'datetime NOT NULL',
        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');
        $this->createIndex('ux_users_username', 'users', 'username', true);

        $this->createTable('authors', array(
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');

        $this->createTable('books', array(
            'id' => 'pk',
            'title' => 'varchar(255) NOT NULL',
            'year' => 'int NOT NULL',
            'description' => 'text',
            'isbn' => 'varchar(32) NOT NULL',
            'cover_path' => 'varchar(255)',
            'created_at' => 'datetime NOT NULL',
        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');
        $this->createIndex('ux_books_isbn', 'books', 'isbn', true);
        $this->createIndex('ix_books_year', 'books', 'year');

        $this->createTable('book_author', array(
            'book_id' => 'int NOT NULL',
            'author_id' => 'int NOT NULL',
            'PRIMARY KEY (book_id, author_id)',
        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');
        $this->addForeignKey('fk_book_author_book', 'book_author', 'book_id', 'books', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_book_author_author', 'book_author', 'author_id', 'authors', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('subscriptions', array(
            'id' => 'pk',
            'author_id' => 'int NOT NULL',
            'phone' => 'varchar(32) NOT NULL',
            'created_at' => 'datetime NOT NULL',
        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');
        $this->createIndex('ux_subscriptions_author_phone', 'subscriptions', 'author_id, phone', true);
        $this->addForeignKey('fk_subscriptions_author', 'subscriptions', 'author_id', 'authors', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('subscriptions');
        $this->dropTable('book_author');
        $this->dropTable('books');
        $this->dropTable('authors');
        $this->dropTable('users');
    }
}
