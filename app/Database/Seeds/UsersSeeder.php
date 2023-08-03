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
            'salutation'            => '',
            'first_name'            => 'Anton Jay',
            'last_name'             => 'Hermo',
            'position'              => '',
            'picture'               => null,
            'user_name'             => 'Admin',
            'user_email'            => 'ajhay.dev@gmail.com',
            'user_password'         => 'YBO60giQPoFef05oW+gMmg==',
            'user_auth_code'        => 'UMVz2ac63LAY0Za+SJsuGQ==',
            'user_status'           => 1,
            'password_auth_code'    => '',
            'role_id'               => 1,
            'created_date'          => date('Y-m-d H:i:s'),
            'updated_date'          => null
        ];

        $user->insert($arrData);
    }
}
