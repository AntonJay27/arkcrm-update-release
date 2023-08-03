<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IndexController extends BaseController
{
    public function __construct()
    {
        $this->users = model('Portal/Users');
        $this->email_config = model('Portal/EmailConfigurations');
    }

    public function login()
    {
        $this->validation->setRules([
            'txt_userEmail' => [
                'label'  => 'User Email',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'User Email/Username is required'
                ],
            ],
            'txt_userPassword' => [
                'label'  => 'User Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password is Incorrect',
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $logInRequirements = [
              'user_email'      => $fields['txt_userEmail'],
              'user_name'       => $fields['txt_userEmail'],
              'user_password'   => encrypt_code($fields['txt_userPassword']),
              'user_status'     => '1', //meaning active
            ];

            $validateLogInResult = $this->users->validateLogIn($logInRequirements);

            if(!empty($validateLogInResult))
            {
              $userData = [
                'arkonorllc_user_id'        => $validateLogInResult['user_id'],
                'arkonorllc_user_firstName' => $validateLogInResult['first_name'],
                'arkonorllc_user_lastName'  => $validateLogInResult['last_name'],
                'arkonorllc_user_loggedIn'  => true
              ];
              $this->session->set($userData);

              $msgResult[] = "Success";
            }
            else
            {
              $msgResult[] = "Access denied, please try again or contact our administrator";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function forgotPassword()
    {
        $this->validation->setRules([
            'txt_userEmail' => [
                'label'  => 'User Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => 'User Email is required',
                    'valid_email' => 'User Email must be valid'
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'password_auth_code' => encrypt_code(generate_code())
            ];
            $result = $this->users->createPasswordAuthCode($arrData, $fields['txt_userEmail']);
            if($result > 0)
            {
                $config = $this->email_config->selectEmailConfig();
                $emailSender    = $config['from_email'];
                $emailReceiver  = $fields['txt_userEmail'];

                $arrResult = $this->users->loadUser(['user_email'=>$emailReceiver]);

                $data['subjectTitle']       = 'Forgot Password';
                $data['userId']             = $arrResult['user_id'];
                $data['userName']           = $arrResult['first_name'] . " " . $arrResult['last_name'];
                $data['userAuthCode']       = decrypt_code($arrResult['user_auth_code']);
                $data['passwordAuthCode']   = decrypt_code($arrResult['password_auth_code']);

                $emailResult = sendSliceMail('forgot_password',$config,$emailSender,$emailReceiver,$data);
                $msgResult[] = ($emailResult == 1)? "Success" : $emailResult;
            }
            else
            {
                $msgResult[] = "Error! <br>Your email was not recognized!";
            }  
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function changePassword()
    {
        $this->validation->setRules([
            'txt_newPassword' => [
                'label'  => 'New Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'New password is required'
                ],
            ],
            'txt_confirmPassword' => [
                'label'  => 'Confirm Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Confirm password is required'
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            
            $arrData = [
                'user_password' => encrypt_code($fields['txt_newPassword'])
            ];

            $whereParams = [
                'id' => $fields['txt_userId'],
                'password_auth_code' => encrypt_code($fields['txt_passwordAuthCode'])
            ];

            $result = $this->users->changePassword($arrData, $whereParams);
            $msgResult[] = ($result == 1)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function signUp()
    {
      $this->validation->setRules([
            'txt_userName' => [
                'label'  => 'User Name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'User Name is required'
                ],
            ],
            'txt_userPassword' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password is required'
                ],
            ]
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'user_name'     => $fields['txt_userName'], 
                'user_password' => encrypt_code($fields['txt_userPassword']),
                'user_status'   => '1'
            ];

            $whereParams = [
                'id' => $fields['txt_userId'],
                'user_auth_code' => encrypt_code($fields['txt_userAuthCode']),
                'user_status' => '0'
            ];

            $result = $this->users->signUp($arrData, $whereParams);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = strip_tags(validation_errors());
        }

        return $this->response->setJSON($msgResult);
    }

    public function logout()
    {
        $userData = [
            'arkonorllc_user_id',
            'arkonorllc_user_firstName',
            'arkonorllc_user_lastName',
            'arkonorllc_user_loggedIn'
        ];
        $this->session->destroy();
        return redirect()->to(base_url());
    }
}
