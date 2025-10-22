<?php
namespace app\services\book;

use app\models\Author;
use app\services\base\BaseService;
use app\models\Book;
use app\models\BookImage;
use app\services\interfaces\BookServiceInterface;
use app\services\interfaces\ImageUploadInterface;
use yii\web\UploadedFile;

class BookService extends BaseService implements ImageUploadInterface , BookServiceInterface
{
    /**
     * Сохраняет загруженное изображение книги и обновляет запись BookImage
     *
     * @param Book $book
     * @param UploadedFile|null $uploadedFile
     * @return BookImage|null
     */
    public function saveImage($model, ?UploadedFile $file): bool
    {
        if (!$file || !$model instanceof Book) {
            return false;
        }

        $filename = uniqid() . '.' . $file->extension;
        $path = \Yii::getAlias('@webroot/uploads/' . $filename);

        if (!$file->saveAs($path)) {
            return false;
        }

        $bookImage = BookImage::findOne(['book_id' => $model->id, 'is_main' => 1]);
        if (!$bookImage) {
            $bookImage = new BookImage();
            $bookImage->book_id = $model->id;
            $bookImage->is_main = 1;
        }

        $bookImage->image_path = '/uploads/' . $filename;
        return $bookImage->save();
    }

    public function saveAuthors(Book $book, array $authorIds) : void
    {
        $book->unlinkAll('authors', true);
        foreach ($authorIds as $authorId) {
            if ($author = Author::findOne($authorId)) {
                $book->link('authors', $author);
            }
        }
    }
}