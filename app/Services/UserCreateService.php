<?php

namespace App\Services;

use App\Models\DTO\User\UserCreateDto;
use App\Models\User;
use App\Models\UserUpdates;
use Illuminate\Support\Facades\DB;

class UserCreateService
{
    protected UserCreateDto $userData;
    public function __construct(UserCreateDto $userData, $userUpdateData)
    {
        $this->userData = $userData;
        $this->userUpdateData = $userUpdateData;
    }

    public function create()
    {
        DB::transaction(function () {

            $user = User::create($this->userData);

            UserUpdates::create($this->userUpdateData);

            return $user;
        });
    }

    public function run(): bool
    {
        return $this->create();
    }
}
