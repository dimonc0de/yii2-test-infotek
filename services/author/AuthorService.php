<?php

namespace app\services\author;

use app\models\Author;
use app\services\base\BaseService;
use app\services\interfaces\AuthorServiceInterface;
use yii\helpers\ArrayHelper;

class AuthorService extends BaseService implements AuthorServiceInterface
{
    /**
     * Возвращает список авторов для select/dropdown
     * в формате [id => "Фамилия Имя Отчество"]
     *
     * @return array
     */
    public function getListForDropdown(): array
    {
        $authors = Author::find()
            ->orderBy(['surname' => SORT_ASC, 'name' => SORT_ASC])
            ->all();

        return ArrayHelper::map(
            $authors,
            'id',
            fn($author) => trim("{$author->surname} {$author->name} {$author->patronymic}")
        );
    }
}