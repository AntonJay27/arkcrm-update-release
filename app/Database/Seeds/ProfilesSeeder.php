<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Portal\Profiles;

class ProfilesSeeder extends Seeder
{
    public function run()
    {
        $profile = new Profiles();

        $arrModulesAndFields = [
                                    [[1],[0,0,0,0],[]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],[]],
                                    [[1],[1,1,1,1],[]],
                                    [[1],[1,1,1,1],[]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],[]],
                                    [[1],[1,1,1,1],[]],
                                    [[1],[1,1,1,1],[]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0","0","0","0","0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],["0","0","0","0","0","0","0"]],
                                    [[1],[1,1,1,1],["0","0","0"]],
                                    [[1],[1,1,1,1],[]],
                                ];

        $arrData = [
            'profile_name'          => 'Administrator',
            'description'           => 'All Access',
            'modules_and_fields'    => json_encode($arrModulesAndFields),
            'created_date'          => date('Y-m-d H:i:s')
        ];

        $profile->insert($arrData);
    }
}