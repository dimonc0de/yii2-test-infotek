<?php

namespace app\services\interfaces;

use yii\web\UploadedFile;

interface ImageUploadInterface
{
    /**
     * Сохраняет изображение для сущности
     *
     * @param mixed $model Сущность, для которой загружается изображение
     * @param UploadedFile|null $file Загруженный файл
     * @return bool Успешно ли сохранено
     */
    public function saveImage($model, ?UploadedFile $file): bool;
}