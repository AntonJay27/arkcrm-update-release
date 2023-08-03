<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class SystemUpdateController extends BaseController
{
    public function loadSystemUpdates()
    {
      $output_array = null;
      $cmd_status = null;

      exec('git pull github arkcrm-updates', $output_array, $cmd_status);

      $arrResult = [$output_array, $cmd_status];

      return $this->response->setJSON($arrResult);
    }
}
