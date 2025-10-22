<?php
namespace app\services\interfaces;

interface AuthorServiceInterface
{
    /**
     * Возвращает список авторов для select/dropdown
     * в формате [id => "Фамилия Имя Отчество"]
     *
     * @return array
     */
    public function getListForDropdown(): array;
}