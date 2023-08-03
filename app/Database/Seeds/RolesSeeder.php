<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Portal\Roles;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $role = new Roles();

        $arrData = [
            'reports_to'            => null,
            'role_name'             => 'CEO',
            'sub_role'              => 0,
            'can_assign_records_to' => 'all-users',
            'privileges'            => 'assign-privileges-from-existing-profiles',
            'profiles'              => json_encode([1]),
            'modules_and_fields'    => null,
            'created_date'          => date('Y-m-d H:i:s')
        ];

        $role->insert($arrData);
    }
}
