<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class NavigationController extends BaseController
{
    public function __construct()
    {
        $this->campaigns        = model('Portal/Campaigns');
        $this->contacts         = model('Portal/Contacts');
        $this->organizations    = model('Portal/Organizations');
        $this->documents        = model('Portal/Documents');
        $this->profiles         = model('Portal/Profiles');
        $this->roles            = model('Portal/Roles');
        $this->users            = model('Portal/Users');
    }

    public function dashboard()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Dashboard";
                $data['customScripts'] = 'dashboard';
                $data['accessModules'] = [];
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));

                if($userData == null)
                {
                  $this->logout();
                }
                else
                {
                  $roleData = $this->roles->selectRole($userData['role_id']);
                  if($roleData != null)
                  {
                      if($roleData['profiles'] == null)
                      {
                          $accessModules = json_decode($roleData['modules_and_fields']);
                          $accessModules = loadAccessModulesFromRole($accessModules);
                          $data['accessModules'] = $accessModules;
                      }
                      else
                      {
                          $profileIds = json_decode($roleData['profiles'],true);
                          $arrProfiles = $this->profiles->loadProfiles($profileIds);
                          $accessModules = loadAccessModulesFromProfile($arrProfiles);
                          $data['accessModules'] = $accessModules;
                      }
                  }
                  return $this->slice->view('portal.dashboard', $data);
                  // return $this->response->setJSON($data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function contacts()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Contacts";
                $data['customScripts'] = 'contacts';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                
                if($userData == null)
                {
                  $this->logout();
                }
                else
                {
                  $roleData = $this->roles->selectRole($userData['role_id']);
                  if($roleData['profiles'] == null)
                  {
                     $accessModules = json_decode($roleData['modules_and_fields']);
                     $accessModules = loadAccessModulesFromRole($accessModules);
                     $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                     $data['accessModules'] = $accessModules;
                     $data['accessActionsAndFields'] = $accessModulesAndFields[1];
                  }
                  else
                  {
                     $profileIds = json_decode($roleData['profiles'],true);
                     $arrProfiles = $this->profiles->loadProfiles($profileIds);
                     $accessModules = loadAccessModulesFromProfile($arrProfiles);
                     $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                     $data['accessModules'] = $accessModules;
                     $data['accessActionsAndFields'] = $accessModulesAndFields[1];
                  }
                  $data['contactId'] = "";
                  return $this->slice->view('portal.rolodex.contact', $data);
                  // return $this->response->setJSON($data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function contactPreview($contactId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->contacts->selectContact($contactId);
                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | Contacts Preview";
                    $data['customScripts'] = 'contacts';
                    $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                    $roleData = $this->roles->selectRole($userData['role_id']);
                    if($roleData['profiles'] == null)
                    {
                        $accessModules = json_decode($roleData['modules_and_fields']);
                        $accessModules = loadAccessModulesFromRole($accessModules);
                        $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[1];
                    }
                    else
                    {
                        $profileIds = json_decode($roleData['profiles'],true);
                        $arrProfiles = $this->profiles->loadProfiles($profileIds);
                        $accessModules = loadAccessModulesFromProfile($arrProfiles);
                        $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[1];
                    }
                    $data['contactId'] = $contactId;
                    return $this->slice->view('portal.rolodex.contact', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function organizations()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Organizations";
                $data['customScripts'] = 'organization';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[2];
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[2];
                }
                $data['organizationId'] = "";
                return $this->slice->view('portal.rolodex.organization', $data);
                // return $this->response->setJSON($data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function organizationPreview($organizationId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->organizations->selectOrganization($organizationId);

                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | Organization Preview";
                    $data['customScripts'] = 'organization';
                    $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                    $roleData = $this->roles->selectRole($userData['role_id']);
                    if($roleData['profiles'] == null)
                    {
                        $accessModules = json_decode($roleData['modules_and_fields']);
                        $accessModules = loadAccessModulesFromRole($accessModules);
                        $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[2];
                    }
                    else
                    {
                        $profileIds = json_decode($roleData['profiles'],true);
                        $arrProfiles = $this->profiles->loadProfiles($profileIds);
                        $accessModules = loadAccessModulesFromProfile($arrProfiles);
                        $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[2];
                    }
                    $data['organizationId'] = $organizationId;
                    return $this->slice->view('portal.rolodex.organization', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function campaigns()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | campaigns";
                $data['customScripts'] = 'campaign';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[3];
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[3];
                }
                $data['campaignId'] = "";
                return $this->slice->view('portal.marketing.campaign', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function campaignPreview($campaignId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->campaigns->selectCampaign($campaignId);
                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | campaigns";
                    $data['customScripts'] = 'campaign';
                    $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                    $roleData = $this->roles->selectRole($userData['role_id']);
                    if($roleData['profiles'] == null)
                    {
                        $accessModules = json_decode($roleData['modules_and_fields']);
                        $accessModules = loadAccessModulesFromRole($accessModules);
                        $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[3];
                    }
                    else
                    {
                        $profileIds = json_decode($roleData['profiles'],true);
                        $arrProfiles = $this->profiles->loadProfiles($profileIds);
                        $accessModules = loadAccessModulesFromProfile($arrProfiles);
                        $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[3];
                    }
                    $data['campaignId'] = $campaignId;
                    return $this->slice->view('portal.marketing.campaign', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function newsLetters()
    {
      if($this->session->has('arkonorllc_user_loggedIn'))
      {
          if($this->session->get('arkonorllc_user_loggedIn'))
          {
              $data['pageTitle'] = "Arkonor LLC | News Letters";
              $data['customScripts'] = 'news_letters';
              $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
              $roleData = $this->roles->selectRole($userData['role_id']);
              if($roleData['profiles'] == null)
              {
                  $accessModules = json_decode($roleData['modules_and_fields']);
                  $accessModules = loadAccessModulesFromRole($accessModules);
                  $data['accessModules'] = $accessModules;
              }
              else
              {
                  $profileIds = json_decode($roleData['profiles'],true);
                  $arrProfiles = $this->profiles->loadProfiles($profileIds);
                  $accessModules = loadAccessModulesFromProfile($arrProfiles);
                  $data['accessModules'] = $accessModules;
              }
              return $this->slice->view('portal.marketing.news_letter', $data);
          }
          else
          {
              return redirect()->to(base_url());
          }
      }
      else
      {
          return redirect()->to(base_url());
      }
    }

    public function socialMediaPost()
    {
      if($this->session->has('arkonorllc_user_loggedIn'))
      {
          if($this->session->get('arkonorllc_user_loggedIn'))
          {
              $data['pageTitle'] = "Arkonor LLC | Social Media Post";
              $data['customScripts'] = 'social_media_post';
              $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
              $roleData = $this->roles->selectRole($userData['role_id']);
              if($roleData['profiles'] == null)
              {
                  $accessModules = json_decode($roleData['modules_and_fields']);
                  $accessModules = loadAccessModulesFromRole($accessModules);
                  $data['accessModules'] = $accessModules;
              }
              else
              {
                  $profileIds = json_decode($roleData['profiles'],true);
                  $arrProfiles = $this->profiles->loadProfiles($profileIds);
                  $accessModules = loadAccessModulesFromProfile($arrProfiles);
                  $data['accessModules'] = $accessModules;
              }
              return $this->slice->view('portal.marketing.social_media_post', $data);
          }
          else
          {
              return redirect()->to(base_url());
          }
      }
      else
      {
          return redirect()->to(base_url());
      }
    }

    public function imageLibrary()
    {
      if($this->session->has('arkonorllc_user_loggedIn'))
      {
          if($this->session->get('arkonorllc_user_loggedIn'))
          {
              $data['pageTitle'] = "Arkonor LLC | Image Library";
              $data['customScripts'] = 'image_library';
              $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
              $roleData = $this->roles->selectRole($userData['role_id']);
              if($roleData['profiles'] == null)
              {
                  $accessModules = json_decode($roleData['modules_and_fields']);
                  $accessModules = loadAccessModulesFromRole($accessModules);
                  $data['accessModules'] = $accessModules;
              }
              else
              {
                  $profileIds = json_decode($roleData['profiles'],true);
                  $arrProfiles = $this->profiles->loadProfiles($profileIds);
                  $accessModules = loadAccessModulesFromProfile($arrProfiles);
                  $data['accessModules'] = $accessModules;
              }
              return $this->slice->view('portal.marketing.image_library', $data);
          }
          else
          {
              return redirect()->to(base_url());
          }
      }
      else
      {
          return redirect()->to(base_url());
      }
    }

    public function emailTemplate()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Email Template";
                $data['customScripts'] = 'email_template';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[7];
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[7];
                }
                return $this->slice->view('portal.marketing.email_template', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function emailSignature()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Email Signature";
                $data['customScripts'] = 'email_signature';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                return $this->slice->view('portal.marketing.email_signature', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function employees()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Employees";
                $data['customScripts'] = 'employees';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                return $this->slice->view('portal.employees', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function agenda()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Agenda";
                $data['customScripts'] = 'agenda';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                return $this->slice->view('portal.agenda', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function calendar()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Calendar";
                $data['customScripts'] = 'calendar';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                return $this->slice->view('portal.calendar', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function documents()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Documents";
                $data['customScripts'] = 'documents';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[12];
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                    $data['accessModules'] = $accessModules;
                    $data['accessActionsAndFields'] = $accessModulesAndFields[12];
                }
                $data['documentId'] = "";
                return $this->slice->view('portal.documents', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function documentPreview($documentId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->documents->selectDocument($documentId);

                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | Document Preview";
                    $data['customScripts'] = 'documents';
                    $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                    $roleData = $this->roles->selectRole($userData['role_id']);
                    if($roleData['profiles'] == null)
                    {
                        $accessModules = json_decode($roleData['modules_and_fields']);
                        $accessModules = loadAccessModulesFromRole($accessModules);
                        $accessModulesAndFields = json_decode($roleData['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[12];
                    }
                    else
                    {
                        $profileIds = json_decode($roleData['profiles'],true);
                        $arrProfiles = $this->profiles->loadProfiles($profileIds);
                        $accessModules = loadAccessModulesFromProfile($arrProfiles);
                        $accessModulesAndFields = json_decode($arrProfiles[0]['modules_and_fields'],true);
                        $data['accessModules'] = $accessModules;
                        $data['accessActionsAndFields'] = $accessModulesAndFields[12];
                    }
                    $data['documentId'] = $documentId;
                    return $this->slice->view('portal.documents', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function users()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Users";
                $data['customScripts'] = 'users';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                if($accessModules[13][0] == 1)
                {
                  return $this->slice->view('portal.user-management.users', $data);
                }
                else
                {
                  return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function roles()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Roles";
                $data['customScripts'] = 'roles';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                $data['roleId'] = "";
                return $this->slice->view('portal.user-management.roles', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function profiles()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Profiles";
                $data['customScripts'] = 'profiles';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                $data['profileId'] = '';
                return $this->slice->view('portal.user-management.profiles', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function myAccount()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | My Account";
                $data['customScripts'] = 'my_account';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                return $this->slice->view('portal.my_account', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function settings()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Settings";
                $data['customScripts'] = 'settings';
                $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
                $roleData = $this->roles->selectRole($userData['role_id']);
                if($roleData['profiles'] == null)
                {
                    $accessModules = json_decode($roleData['modules_and_fields']);
                    $accessModules = loadAccessModulesFromRole($accessModules);
                    $data['accessModules'] = $accessModules;
                }
                else
                {
                    $profileIds = json_decode($roleData['profiles'],true);
                    $arrProfiles = $this->profiles->loadProfiles($profileIds);
                    $accessModules = loadAccessModulesFromProfile($arrProfiles);
                    $data['accessModules'] = $accessModules;
                }
                return $this->slice->view('portal.settings', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function testFE()
    {
        // $data['pageTitle'] = "Arkonor LLC | TEST FE";
        // $data['customScripts'] = 'settings';
        // $userData = $this->users->selectUser($this->session->get('arkonorllc_user_id'));
        // $roleData = $this->roles->selectRole($userData['role_id']);
        // if($roleData['profiles'] == null)
        // {
        //     $accessModules = json_decode($roleData['modules_and_fields']);
        //     $accessModules = loadAccessModulesFromRole($accessModules);
        //     $data['accessModules'] = $accessModules;
        // }
        // else
        // {
        //     $profileIds = json_decode($roleData['profiles'],true);
        //     $arrProfiles = $this->profiles->loadProfiles($profileIds);
        //     $accessModules = loadAccessModulesFromProfile($arrProfiles);
        //     $data['accessModules'] = $accessModules;
        // }
        // return $this->slice->view('portal.test', $data);
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
