<?php

class m260226_070000_seed_test_data extends CDbMigration
{
    /**
     * Применяет миграцию с тестовыми данными.
     *
     * @result void - добавляет авторов, книги и обложки
     */
    public function safeUp()
    {
        $now = date('Y-m-d H:i:s');
        $books = $this->getBooks();

        foreach ($books as $book) {
            $authorId = $this->getOrCreateAuthor($book['author']);
            $coverPath = $this->downloadCover(
                $book['cover_url'],
                $book['isbn']
            );
            $bookId = $this->getOrCreateBook(
                $book,
                $coverPath,
                $now
            );
            $this->linkBookAuthor($bookId, $authorId);
        }
    }

    /**
     * Откатывает миграцию с тестовыми данными.
     *
     * @result void - удаляет книги, связи, авторов и обложки
     */
    public function safeDown()
    {
        $books = $this->getBooks();
        $isbns = array();
        $authors = array();

        foreach ($books as $book) {
            $isbns[] = $book['isbn'];
            $authors[] = $book['author'];
            $this->deleteCover($book['isbn']);
        }

        $this->deleteBooksByIsbn($isbns);
        $this->deleteAuthorsByName(array_unique($authors));
    }

    /**
     * Возвращает список тестовых книг.
     *
     * @result array - список книг с данными и обложками
     */
    protected function getBooks()
    {
        return array(
            array(
                'author' => 'Стивен Кинг',
                'title' => 'Стрелок',
                'year' => 2021,
                'isbn' => '978-5-17-100672-3',
                'cover_url' => 'https://imo10.labirint.ru/books/559469/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Стивен Кинг',
                'title' => 'Извлечение троих',
                'year' => 2015,
                'isbn' => '978-5-17-080527-3',
                'cover_url' => 'https://imo10.labirint.ru/books/363049/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Стивен Кинг',
                'title' => 'Бесплодные земли',
                'year' => 2017,
                'isbn' => '978-5-17-982575-3',
                'cover_url' => 'https://imo10.labirint.ru/books/600483/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Стивен Кинг',
                'title' => 'Колдун и кристалл',
                'year' => 2024,
                'isbn' => '978-5-17-153513-1',
                'cover_url' => 'https://imo10.labirint.ru/books/1007003/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Стивен Кинг',
                'title' => 'Волки Кальи',
                'year' => 2021,
                'isbn' => '978-5-17-092565-0',
                'cover_url' => 'https://imo10.labirint.ru/books/500321/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Айзек Азимов',
                'title' => 'Академия',
                'year' => 2014,
                'isbn' => '978-5-699-64907-5',
                'cover_url' => 'https://imo10.labirint.ru/books/419303/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Айзек Азимов',
                'title' => 'Академия и Империя',
                'year' => 2022,
                'isbn' => '978-5-04-094780-5',
                'cover_url' => 'https://imo10.labirint.ru/books/648138/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Айзек Азимов',
                'title' => 'Вторая Академия',
                'year' => 2020,
                'isbn' => '978-5-04-111863-1',
                'cover_url' => 'https://imo10.labirint.ru/books/768858/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Айзек Азимов',
                'title' => 'Академия на краю гибели',
                'year' => 2008,
                'isbn' => '978-5-699-24969-5',
                'cover_url' => 'https://static10.labirint.ru/books/170710/'
                    . 'cover.jpg',
            ),
            array(
                'author' => 'Айзек Азимов',
                'title' => 'Академия и Земля',
                'year' => 2022,
                'isbn' => '978-5-699-71077-5',
                'cover_url' => 'https://imo10.labirint.ru/books/432980/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Терри Пратчетт',
                'title' => 'Цвет волшебства',
                'year' => 2021,
                'isbn' => '978-5-04-121217-9',
                'cover_url' => 'https://imo10.labirint.ru/books/575363/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Терри Пратчетт',
                'title' => 'Безумная звезда',
                'year' => 2017,
                'isbn' => '978-5-699-95081-2',
                'cover_url' => 'https://imo10.labirint.ru/books/613826/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Терри Пратчетт',
                'title' => 'Творцы заклинаний',
                'year' => 2017,
                'isbn' => '978-5-04-089084-2',
                'cover_url' => 'https://imo10.labirint.ru/books/611851/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Терри Пратчетт',
                'title' => 'Мор, ученик Смерти',
                'year' => 2017,
                'isbn' => '978-5-04-089549-6',
                'cover_url' => 'https://imo10.labirint.ru/books/616694/'
                    . 'cover.jpg/242-0',
            ),
            array(
                'author' => 'Терри Пратчетт',
                'title' => 'Посох и шляпа',
                'year' => 2006,
                'isbn' => '5-699-16423-9',
                'cover_url' => 'https://imo10.labirint.ru/books/129327/'
                    . 'cover.jpg/242-0',
            ),
        );
    }

    /**
     * Возвращает или создаёт автора по имени.
     *
     * @param string $name - имя автора
     *
     * @result int - идентификатор автора
     */
    protected function getOrCreateAuthor($name)
    {
        $row = $this->dbConnection->createCommand()
            ->select('id')
            ->from('authors')
            ->where('name = :name', array(':name' => $name))
            ->queryRow();

        if ($row !== false && isset($row['id'])) {
            return (int)$row['id'];
        }

        $this->insert('authors', array('name' => $name));
        return (int)$this->dbConnection->getLastInsertID();
    }

    /**
     * Возвращает или создаёт книгу.
     *
     * @param array $book - данные книги
     * @param string|null $coverPath - путь к обложке
     * @param string $createdAt - дата добавления
     *
     * @result int - идентификатор книги
     */
    protected function getOrCreateBook(array $book, $coverPath, $createdAt)
    {
        $row = $this->dbConnection->createCommand()
            ->select('id, cover_path')
            ->from('books')
            ->where('isbn = :isbn', array(':isbn' => $book['isbn']))
            ->queryRow();

        if ($row !== false && isset($row['id'])) {
            if ($coverPath !== null && empty($row['cover_path'])) {
                $this->update('books', array(
                    'cover_path' => $coverPath,
                ), 'id = :id', array(':id' => $row['id']));
            }
            return (int)$row['id'];
        }

        $this->insert('books', array(
            'title' => $book['title'],
            'year' => (int)$book['year'],
            'description' => null,
            'isbn' => $book['isbn'],
            'cover_path' => $coverPath,
            'created_at' => $createdAt,
        ));

        return (int)$this->dbConnection->getLastInsertID();
    }

    /**
     * Создаёт связь книги и автора.
     *
     * @param int $bookId - идентификатор книги
     * @param int $authorId - идентификатор автора
     *
     * @result void - создаёт связь, если её нет
     */
    protected function linkBookAuthor($bookId, $authorId)
    {
        $exists = $this->dbConnection->createCommand()
            ->select('book_id')
            ->from('book_author')
            ->where(
                'book_id = :book_id AND author_id = :author_id',
                array(
                    ':book_id' => $bookId,
                    ':author_id' => $authorId,
                )
            )
            ->queryScalar();

        if ($exists !== false) {
            return;
        }

        $this->insert('book_author', array(
            'book_id' => $bookId,
            'author_id' => $authorId,
        ));
    }

    /**
     * Скачивает обложку и возвращает путь.
     *
     * @param string $url - ссылка на обложку
     * @param string $isbn - ISBN книги
     *
     * @result string|null - относительный путь к файлу
     */
    protected function downloadCover($url, $isbn)
    {
        $uploadDir = $this->getUploadDir();
        if ($uploadDir === null) {
            return null;
        }

        $extension = $this->getExtensionFromUrl($url);
        $fileName = 'cover_' . $this->normalizeIsbn($isbn)
            . '.' . $extension;
        $path = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (!is_file($path)) {
            $context = stream_context_create(array(
                'http' => array(
                    'header' => "User-Agent: Mozilla/5.0\r\n",
                    'timeout' => 20,
                ),
                'https' => array(
                    'header' => "User-Agent: Mozilla/5.0\r\n",
                    'timeout' => 20,
                ),
            ));
            $data = @file_get_contents($url, false, $context);
            if ($data !== false) {
                file_put_contents($path, $data);
            }
        }

        if (!is_file($path)) {
            return null;
        }

        return 'uploads/' . $fileName;
    }

    /**
     * Удаляет обложку по ISBN.
     *
     * @param string $isbn - ISBN книги
     *
     * @result void - удаляет файл, если он существует
     */
    protected function deleteCover($isbn)
    {
        $uploadDir = $this->getUploadDir();
        if ($uploadDir === null) {
            return;
        }

        $pattern = $uploadDir . DIRECTORY_SEPARATOR . 'cover_'
            . $this->normalizeIsbn($isbn) . '.*';
        foreach (glob($pattern) as $path) {
            @unlink($path);
        }
    }

    /**
     * Удаляет книги по ISBN.
     *
     * @param array $isbns - список ISBN
     *
     * @result void - удаляет книги и связи
     */
    protected function deleteBooksByIsbn(array $isbns)
    {
        if (empty($isbns)) {
            return;
        }

        $placeholders = array();
        $params = array();
        foreach ($isbns as $index => $isbn) {
            $key = ':isbn' . $index;
            $placeholders[] = $key;
            $params[$key] = $isbn;
        }

        $in = implode(',', $placeholders);
        $rows = $this->dbConnection->createCommand()
            ->select('id')
            ->from('books')
            ->where('isbn IN (' . $in . ')', $params)
            ->queryAll();

        $bookIds = array();
        foreach ($rows as $row) {
            $bookIds[] = (int)$row['id'];
        }

        if (!empty($bookIds)) {
            $this->dbConnection->createCommand()->delete(
                'book_author',
                'book_id IN (' . implode(',', $bookIds) . ')'
            );
        }

        $this->dbConnection->createCommand()->delete(
            'books',
            'isbn IN (' . $in . ')',
            $params
        );
    }

    /**
     * Удаляет авторов по имени.
     *
     * @param array $names - список имён авторов
     *
     * @result void - удаляет авторов
     */
    protected function deleteAuthorsByName(array $names)
    {
        if (empty($names)) {
            return;
        }

        $placeholders = array();
        $params = array();
        foreach ($names as $index => $name) {
            $key = ':name' . $index;
            $placeholders[] = $key;
            $params[$key] = $name;
        }

        $in = implode(',', $placeholders);
        $this->dbConnection->createCommand()->delete(
            'authors',
            'name IN (' . $in . ')',
            $params
        );
    }

    /**
     * Возвращает каталог загрузок.
     *
     * @result string|null - путь к каталогу или null при ошибке
     */
    protected function getUploadDir()
    {
        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web'
            . DIRECTORY_SEPARATOR . 'uploads';

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (!is_dir($path)) {
            return null;
        }

        return $path;
    }

    /**
     * Возвращает расширение файла из URL.
     *
     * @param string $url - ссылка на обложку
     *
     * @result string - расширение файла
     */
    protected function getExtensionFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (!is_string($path) || $path === '') {
            return 'jpg';
        }

        $info = pathinfo($path);
        if (!isset($info['extension']) || $info['extension'] === '') {
            return 'jpg';
        }

        return strtolower($info['extension']);
    }

    /**
     * Нормализует ISBN для имени файла.
     *
     * @param string $isbn - ISBN книги
     *
     * @result string - ISBN без лишних символов
     */
    protected function normalizeIsbn($isbn)
    {
        return preg_replace('/[^0-9Xx]/', '', $isbn);
    }
}
