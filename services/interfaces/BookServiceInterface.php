<?php
namespace app\services\interfaces;

use app\models\Book;

interface BookServiceInterface
{

    /**
     * Сохраняет связи книги с авторами
     *
     * @param Book $book
     * @param int[] $authorIds Список ID авторов
     * @return void
     */
    public function saveAuthors(Book $book, array $authorIds): void;

}