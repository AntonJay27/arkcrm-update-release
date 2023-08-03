<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class NavigationController extends BaseController
{
   public function __construct()
   {
      $this->users = model('Portal/Users');
   }

    public function index()
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $uri = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/' . $uriSegments[1] . '/login';
        return redirect()->to($uri);
    }

    public function login()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/dashboard');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Login";
        $data['userAuthCode'] = "";
        return $this->slice->view('login', $data);
    }

    public function forgotPassword()
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if(!file_exists(FCPATH . '.env'))
        {
            $uri = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/' . $uriSegments[1] . '/install';
            return redirect()->to($uri); 
        }
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/dashboard');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Forgot Password";
        return $this->slice->view('forgot_password', $data);
    }

    public function changePassword($userId, $userAuthCode, $passwordAuthCode)
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if(!file_exists(FCPATH . '.env'))
        {
            $uri = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/' . $uriSegments[1] . '/install';
            return redirect()->to($uri); 
        }
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/dashboard');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Change Password";
        $data['userId'] = $userId;
        $data['userAuthCode'] = $userAuthCode;
        $data['passwordAuthCode'] = $passwordAuthCode;
        return $this->slice->view('change_password', $data);
    }

    public function signUp($userId, $userAuthCode)
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if(!file_exists(FCPATH . '.env'))
        {
            $uri = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/' . $uriSegments[1] . '/install';
            return redirect()->to($uri); 
        }
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/dashboard');
            }
        }

        $arrUser = $this->users->selectUser($userId);

        $data['pageTitle'] = "Arkonor LLC | Sign Up";
        $data['userId'] = $userId;
        $data['userAuthCode'] = $userAuthCode;
        $data['userName'] = $arrUser['user_name'];
        return $this->slice->view('sign_up', $data);
    }
}
