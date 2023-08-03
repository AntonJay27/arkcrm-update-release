<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SampleController extends BaseController
{
    public function __construct()
    {
        $this->email_config = model('Portal/EmailConfigurations');
    }

    public function testEmail()
    {
      $config = $this->email_config->selectEmailConfig();

      $emailConfig = [
       'smtp_host'    => $config['smtp_host'],
       'smtp_port'    => $config['smtp_port'],
       'smtp_crypto'  => $config['smtp_crypto'],
       'smtp_user'    => $config['smtp_user'],
       'smtp_pass'    => decrypt_code($config['smtp_pass']),
       'mail_type'    => $config['mail_type'],
       'charset'      => $config['charset'],
       'word_wrap'    => $config['word_wrap']
      ];

      $emailSender    = 'ajhay.dev@gmail.com';
      $emailReceiver  = 'ajhay.work@gmail.com';
      $data['subjectTitle'] = "Sample";
      $data['emailContent'] = "Sample Email Content";

      $emailResult = sendSliceMail('sample_email',$emailConfig,$emailSender,$emailReceiver,$data);

      return $this->response->setJSON($emailResult);
    }

    public function initializeGit()
    {
      chdir('../');


      // $output_array = null;
      // $cmd_status = null;

      // exec('git init', $output_array, $cmd_status);
      // exec('git add .', $output_array, $cmd_status);
      // exec('git commit -m "Initial Commit"', $output_array, $cmd_status);

      // exec('git rm .gitignore');
      // exec('git add .');
      // exec('git commit -m "Remove .gitignore file"');
      // exec('git branch arkcrm-updates');
      // exec('git checkout arkcrm-updates');
      // exec('git remote add github "git@github.com:rportojr/ARK-CRM.git"');
      // exec('git pull github arkcrm-updates --allow-unrelated-histories');

      // echo var_dump($output_array);
      echo getcwd();
    }
}
