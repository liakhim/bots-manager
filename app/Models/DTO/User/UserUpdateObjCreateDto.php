<?php

namespace App\Models\DTO\User;

/**
 * Data Transfer Object для создания пользователя.
 *
 * @property string $user_id Id пользователя (обязательно)
 * @property string $update_id Id апдейта из тг (обязательно)
 * @property object $data Данные апдейта из тг (обязательно)
 * @property string $data_type Id данных апдейта из тг (обязательно)
 * @property string $date Дата создания данных апдейта из тг (обязательно)
 */
class UserUpdateObjCreateDto
{
    public function __construct(
        public string $user_id,
        public bool $update_id,
        public object $data,
        public string $data_type,
        public string $date,
    ) {}
}
