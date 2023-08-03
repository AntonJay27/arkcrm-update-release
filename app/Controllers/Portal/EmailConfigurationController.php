<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class EmailConfigurationController extends BaseController
{
    public function __construct()
    {
        $this->email_config = model('Portal/EmailConfigurations');
    }

    public function addEmailConfig()
    {
        $fields = $this->request->getPost();

        $this->validation->setRules([
            'txt_smtpHost' => [
                'label'  => 'SMTP Host',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Host is required',
                ],
            ],
            'txt_smtpPort' => [
                'label'  => 'SMTP Port',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Port is required',
                ],
            ],
            'slc_smtpCrypto' => [
                'label'  => 'SMTP Crypto',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Crypto is required',
                ],
            ],
            'txt_smtpUser' => [
                'label'  => 'SMTP User',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP User is required',
                ],
            ],
            'txt_smtpPassword' => [
                'label'  => 'SMTP Password',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Password is required',
                ],
            ],
            'slc_mailType' => [
                'label'  => 'MAIL Type',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'MAIL Type is required',
                ],
            ],
            'slc_charset' => [
                'label'  => 'Charset',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Charset is required',
                ],
            ],
            'slc_wordWrap' => [
                'label'  => 'Word Wrap',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Word Wrap is required',
                ],
            ],
            'txt_fromEmail' => [
                'label'  => 'From Email',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'From Email is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $arrData = [
                'protocol'      => 'smtp',
                'smtp_host'     => $fields['txt_smtpHost'],
                'smtp_port'     => $fields['txt_smtpPort'],
                'smtp_crypto'   => $fields['slc_smtpCrypto'],
                'smtp_user'     => $fields['txt_smtpUser'],
                'smtp_pass'     => encrypt_code($fields['txt_smtpPassword']),
                'mail_type'     => $fields['slc_mailType'],
                'charset'       => $fields['slc_charset'],
                'word_wrap'     => $fields['slc_wordWrap'],
                'from_email'    => $fields['txt_fromEmail'],
                'created_by'    => $this->session->get('arkonorllc_user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            ];
            $result = $this->email_config->addEmailConfig($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Database error"; 
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectEmailConfig()
    {
        $fields = $this->request->getGet();

        $data = $this->email_config->selectEmailConfig();
        if($data != null)
        {
            $data['smtp_pass'] = decrypt_code($data['smtp_pass']);
        }
        return $this->response->setJSON($data);
    }

    public function editEmailConfig()
    {
        $fields = $this->request->getPost();

        $this->validation->setRules([
            'txt_smtpHost' => [
                'label'  => 'SMTP Host',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Host is required',
                ],
            ],
            'txt_smtpPort' => [
                'label'  => 'SMTP Port',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Port is required',
                ],
            ],
            'slc_smtpCrypto' => [
                'label'  => 'SMTP Crypto',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Crypto is required',
                ],
            ],
            'txt_smtpUser' => [
                'label'  => 'SMTP User',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP User is required',
                ],
            ],
            'txt_smtpPassword' => [
                'label'  => 'SMTP Password',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'SMTP Password is required',
                ],
            ],
            'slc_mailType' => [
                'label'  => 'MAIL Type',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'MAIL Type is required',
                ],
            ],
            'slc_charset' => [
                'label'  => 'Charset',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Charset is required',
                ],
            ],
            'slc_wordWrap' => [
                'label'  => 'Word Wrap',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Word Wrap is required',
                ],
            ],
            'txt_fromEmail' => [
                'label'  => 'From Email',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'From Email is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $arrData = [
                'protocol'      => 'smtp',
                'smtp_host'     => $fields['txt_smtpHost'],
                'smtp_port'     => $fields['txt_smtpPort'],
                'smtp_crypto'   => $fields['slc_smtpCrypto'],
                'smtp_user'     => $fields['txt_smtpUser'],
                'smtp_pass'     => encrypt_code($fields['txt_smtpPassword']),
                'mail_type'     => $fields['slc_mailType'],
                'charset'       => $fields['slc_charset'],
                'word_wrap'     => $fields['slc_wordWrap'],
                'from_email'    => $fields['txt_fromEmail'],
                'updated_by'    => $this->session->get('arkonorllc_user_id'),
                'updated_date'  => date('Y-m-d H:i:s')
            ];
            $result = $this->email_config->editEmailConfig($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Database error"; 
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function testEmailConfig()
    {
      $fields = $this->request->getPost();

      $this->validation->setRules([
          'txt_testEmailAddress' => [
              'label'  => 'Email Address',
              'rules'  => 'required',
              'errors' => [
                  'required'    => 'Email Address is required',
              ],
          ],
      ]);

      if($this->validation->withRequest($this->request)->run())
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

         $emailSender    = $config['from_email'];
         $emailReceiver  = $fields['txt_testEmailAddress'];

         $data['subjectTitle'] = 'Test Email';
         $data['emailContent'] = 'Test Email';

         $emailResult = sendSliceMail('test_email',$emailConfig,$emailSender,$emailReceiver,$data);

         $msgResult = ($emailResult == true)? ["Success",$emailResult] : ["Error","Unable to send email, Please check your configuration!"];
      }
      else
      {
         $msgResult = ["Error",$this->validation->getErrors()];
      }

      return $this->response->setJSON($msgResult);
    }
}
