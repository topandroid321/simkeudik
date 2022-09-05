<?php

namespace App\Validation;

use App\Models\ModelUser;
use App\Models\ModelPesertaDidik;


class UserRules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $modeluser = new ModelUser();
        $modelpeserta = new ModelPesertaDidik();
        $user = $modeluser->where('username', $data['username'])
            ->first();
        if (!$user)
            return false;
        return password_verify($data['password'], $user['password']);
    }
}
