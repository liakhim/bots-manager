<?php

namespace App\Models\DTO\User;

/**
 * Data Transfer Object для создания пользователя.
 *
 * @property string $name Имя пользователя (обязательно)
 * @property string $tg_username Имя пользователя в ТГ (обязательно)
 * @property bool $is_bot Бот/Не бот в ТГ (обязательно)
 * @property string $language_code Код языка в ТГ (обязательно)
 * @property bool $is_premium Премиум или нет, в ТГ (обязательно)
 * @property string $chat_id Id чата в ТГ (обязательно)
 * @property string|null $topic_id Id топика (канал для логов) (необязательно)
 * @property string|null $email Email (необязательно, но должен быть уникальным)
 * @property bool|null $email_verified_at Подтвержден ли email (необязательно)
 * @property string|null $password Пароль (необязательно)
 */
class UserCreateDto
{
    public function __construct(
        public string $name,
        public string $tg_username,
        public bool $is_bot,
        public string $language_code,
        public bool $is_premium,
        public string $chat_id,
        public ?string $topic_id = null,
        public ?string $email = null,
        public ?bool $email_verified_at = null,
        public ?string $password = '123456',

    ) {}
}
