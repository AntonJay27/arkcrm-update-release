<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Portal\Users;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $user = new Users();

        $arrData = [
            'salutation'            => '__SALUTATION__',
            'first_name'            => '__FIRST_NAME__',
            'last_name'             => '__LAST_NAME__',
            'position'              => '__POSITION__',
            'picture'               => null,
            'user_name'             => '__USER_NAME__',
            'user_email'            => '__USER_EMAIL__',
            'user_password'         => '__USER_PASSWORD__',
            'user_auth_code'        => '__USER_AUTH_CODE__',
            'user_status'           => 1,
            'password_auth_code'    => '__PASSWORD_AUTH_CODE__',
            'role_id'               => 1,
            'created_date'          => date('Y-m-d H:i:s'),
            'updated_date'          => null
        ];

        $user->insert($arrData);
    }
}
