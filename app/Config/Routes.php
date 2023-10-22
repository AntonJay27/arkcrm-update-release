<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('NavigationController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function(){
    return view('404');
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'NavigationController');


/*
 * --------------------------------------------------------------------
 * Installation
 * --------------------------------------------------------------------
 */

$routes->post('install/installation-step-four', 'InstallationController::installationStepFour');
$routes->post('install/installation-step-five', 'InstallationController::installationStepFive');
$routes->post('install/installation-step-six', 'InstallationController::installationStepSix');
$routes->post('install/git-add-init', 'InstallationController::gitAddInit');
$routes->post('install/git-commit-init', 'InstallationController::gitCommitInit');
$routes->post('install/git-add', 'InstallationController::gitAdd');
$routes->post('install/git-commit', 'InstallationController::gitCommit');
$routes->post('install/git-remote', 'InstallationController::gitRemote');


/*
 * --------------------------------------------------------------------
 * OUTSIDE NAVIGATIONS
 * --------------------------------------------------------------------
 */
$routes->get('login', 'NavigationController::login');
$routes->get('login/(:any)', 'NavigationController::loginWithAuth/$1');
$routes->get('forgot-password', 'NavigationController::forgotPassword');
$routes->get('change-password/(:num)/(:any)/(:any)', 'NavigationController::changePassword/$1/$2/$3');
$routes->get('sign-up/(:num)/(:any)', 'NavigationController::signUp/$1/$2');

/*
 * --------------------------------------------------------------------
 * OUTSIDE METHODS
 * --------------------------------------------------------------------
 */
$routes->post('user-login', 'IndexController::login');
$routes->post('user-forgot-password', 'IndexController::forgotPassword');
$routes->post('user-change-password', 'IndexController::changePassword');
$routes->post('user-sign-up', 'IndexController::signUp');
$routes->get('user-logout', 'IndexController::logout');

$routes->get('contact-unsubscribe/(:num)/(:any)/(:any)','UnsubscribeController::contactUnsubscribe/$1/$2/$3');
$routes->get('contact-confirmation/(:num)/(:any)/(:any)','UnsubscribeController::contactConfirmation/$1/$2/$3');

$routes->get('sample','IndexController::sample');

$routes->get('test-email', 'SampleController::testEmail');
$routes->get('initialize-git', 'SampleController::initializeGit');

/*
 * --------------------------------------------------------------------
 * INSIDE NAVIGATION
 * --------------------------------------------------------------------
 */
//////////////////////////// DASHBOARD ////////////////////////////////
$routes->get('dashboard', 'Portal\NavigationController::dashboard');

//////////////////////////// ROLODEX /////////////////////////////////
$routes->get('contacts', 'Portal\NavigationController::contacts');
$routes->get('contact-preview/(:num)', 'Portal\NavigationController::contactPreview/$1');
$routes->get('organizations', 'Portal\NavigationController::organizations');
$routes->get('organization-preview/(:num)', 'Portal\NavigationController::organizationPreview/$1');

//////////////////////////// MARKETING ////////////////////////////////
$routes->get('campaigns', 'Portal\NavigationController::campaigns');
$routes->get('campaign-preview/(:num)', 'Portal\NavigationController::campaignPreview/$1');
$routes->get('news-letters', 'Portal\NavigationController::newsLetters');
$routes->get('social-media-post', 'Portal\NavigationController::socialMediaPost');
$routes->get('image-library', 'Portal\NavigationController::imageLibrary');
$routes->get('email-template', 'Portal\NavigationController::emailTemplate');
$routes->get('email-signature', 'Portal\NavigationController::emailSignature');

//////////////////////////// EMPLOYEES ////////////////////////////////
$routes->get('employees', 'Portal\NavigationController::employees');

//////////////////////////// AGENDA ////////////////////////////////
$routes->get('agenda', 'Portal\NavigationController::agenda');

//////////////////////////// CALENDAR ////////////////////////////////
$routes->get('calendar', 'Portal\NavigationController::calendar');

//////////////////////////// DOCUMENTS ////////////////////////////////
$routes->get('documents', 'Portal\NavigationController::documents');
$routes->get('document-preview/(:num)', 'Portal\NavigationController::documentPreview/$1');

//////////////////////////// USER MANAGEMENT ////////////////////////////////
$routes->get('users', 'Portal\NavigationController::users');

$routes->get('roles', 'Portal\NavigationController::roles');

$routes->get('profiles', 'Portal\NavigationController::profiles');


//////////////////////////// PROFILE ////////////////////////////////
$routes->get('my-account', 'Portal\NavigationController::myAccount');

//////////////////////////// SETTINGS ////////////////////////////////
$routes->get('settings', 'Portal\NavigationController::settings');

//////////////////////////// TEST ////////////////////////////////
$routes->get('test-fe', 'Portal\NavigationController::testFE');

/*
 * --------------------------------------------------------------------
 * INSIDE METHODS
 * --------------------------------------------------------------------
 */

///////////////////////////////////////////////////////////////////////
//////////////////////////// DASHBOARD ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('dashboard/load-all-campaigns','Portal\DashboardController::loadAllCampaigns');
$routes->get('dashboard/load-all-contacts','Portal\DashboardController::loadAllContacts');
$routes->get('dashboard/load-all-organizations','Portal\DashboardController::loadAllOrganizations');
$routes->get('dashboard/load-all-users','Portal\DashboardController::loadAllUsers');

$routes->get('dashboard/load-contact-reports','Portal\DashboardController::loadContactReports');
$routes->get('dashboard/load-organization-reports','Portal\DashboardController::loadOrganizationReports');

$routes->get('dashboard/load-summary-reports','Portal\DashboardController::loadSummaryReports');


///////////////////////////////////////////////////////////////////////
//////////////////////////// CAMPAIGNS ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('marketing/campaigns/load-users','Portal\CampaignController::loadUsers');

$routes->get('marketing/load-campaigns','Portal\CampaignController::loadCampaigns');
$routes->post('marketing/add-campaign','Portal\CampaignController::addCampaign');
$routes->get('marketing/select-campaign','Portal\CampaignController::selectCampaign');
$routes->post('marketing/edit-campaign','Portal\CampaignController::editCampaign');
$routes->post('marketing/remove-campaign','Portal\CampaignController::removeCampaign');

//campaign details
$routes->get('marketing/load-campaign-details','Portal\CampaignController::loadCampaignDetails');

//campaign Updates
$routes->get('marketing/load-campaign-updates','Portal\CampaignController::loadCampaignUpdates');

//campaign contacts
$routes->get('marketing/load-selected-contact-campaigns','Portal\CampaignController::loadSelectedContactCampaigns');
$routes->get('marketing/load-unlink-contacts','Portal\CampaignController::loadUnlinkContacts');

//campaign Activities
$routes->get('marketing/load-campaign-activities','Portal\CampaignController::loadCampaignActivities');

//campaign organizations
$routes->get('marketing/load-selected-organization-campaigns','Portal\CampaignController::loadSelectedOrganizationCampaigns');
$routes->get('marketing/load-unlink-organizations','Portal\CampaignController::loadUnlinkOrganizations');


//////////////////////////////////////////////////////////////////////
//////////////////////////// CONTACTS ////////////////////////////////
//////////////////////////////////////////////////////////////////////

$routes->get('marketing/contacts/load-users','Portal\ContactController::loadUsers');

$routes->get('marketing/load-contacts','Portal\ContactController::loadContacts');
$routes->post('marketing/add-contact','Portal\ContactController::addContact');
$routes->get('marketing/select-contact','Portal\ContactController::selectContact');
$routes->post('marketing/edit-contact','Portal\ContactController::editContact');
$routes->post('marketing/remove-contact','Portal\ContactController::removeContact');
// $routes->post('rolodex/check-contact-file','Portal\ContactController::checkContactFile');
// $routes->post('rolodex/upload-contacts','Portal\ContactController::uploadContacts');
// $routes->get('rolodex/contact-conflicts/(:any)', 'Portal\ContactController::contactConflicts/$1');
$routes->post('rolodex/upload-file-contact','Portal\ContactController::uploadFileContact');
// $routes->post('rolodex/duplicate-handling-contact','Portal\ContactController::duplicateHandlingContact');
$routes->get('rolodex/load-custom-maps-contact', 'Portal\ContactController::loadCustomMapsContact');
$routes->get('rolodex/select-custom-map-contact', 'Portal\ContactController::selectCustomMapContact');
$routes->post('rolodex/review-data-contact','Portal\ContactController::reviewDataContact');
$routes->post('rolodex/import-contacts','Portal\ContactController::importContacts');

//contact summary
$routes->get('marketing/load-contact-summary','Portal\ContactController::loadContactSummary');

//contact details
$routes->get('marketing/load-contact-details','Portal\ContactController::loadContactDetails');

//contact updates
$routes->get('marketing/load-contact-updates','Portal\ContactController::loadContactUpdates');

//contact activities
$routes->get('marketing/load-contact-activities','Portal\ContactController::loadContactActivities');

//contact email histories
$routes->get('marketing/load-contact-emails','Portal\ContactController::loadContactEmails');

//contact documents
$routes->get('marketing/load-contact-documents','Portal\ContactController::loadContactDocuments');
$routes->post('marketing/unlink-contact-document','Portal\ContactController::unlinkContactDocument');
$routes->get('marketing/load-unlink-contact-documents','Portal\ContactController::loadUnlinkContactDocuments');
$routes->post('marketing/add-selected-contact-documents','Portal\ContactController::addSelectedContactDocuments');
$routes->post('marketing/add-contact-document','Portal\ContactController::addContactDocument');

//contact campaigns
$routes->get('marketing/load-contact-campaigns','Portal\ContactController::loadContactCampaigns');
$routes->post('marketing/unlink-contact-campaign','Portal\ContactController::unlinkContactCampaign');
$routes->get('marketing/load-unlink-contact-campaigns','Portal\ContactController::loadUnlinkContactCampaigns');
$routes->post('marketing/add-selected-contact-campaigns','Portal\ContactController::addSelectedContactCampaigns');

//contact comments
$routes->get('marketing/load-contact-comments','Portal\ContactController::loadContactComments');
$routes->post('marketing/add-contact-comment-summary','Portal\ContactController::addContactCommentSummary');
$routes->post('marketing/add-contact-comment','Portal\ContactController::addContactComment');
$routes->post('marketing/reply-contact-comment','Portal\ContactController::replyContactComment');

//contact emails
$routes->get('marketing/select-contact-email-template','Portal\ContactController::selectEmailTemplate');
$routes->post('marketing/send-contact-email','Portal\ContactController::sendContactEmail');


///////////////////////////////////////////////////////////////////////////
//////////////////////////// ORGANIZATIONS ////////////////////////////////
///////////////////////////////////////////////////////////////////////////

$routes->get('marketing/organizations/load-users','Portal\OrganizationController::loadUsers');

$routes->get('marketing/load-organizations','Portal\OrganizationController::loadOrganizations');
$routes->post('marketing/add-organization','Portal\OrganizationController::addOrganization');
$routes->get('marketing/select-organization','Portal\OrganizationController::selectOrganization');
$routes->post('marketing/edit-organization','Portal\OrganizationController::editOrganization');
$routes->post('marketing/remove-organization','Portal\OrganizationController::removeOrganization');
// $routes->post('rolodex/check-organization-file','Portal\OrganizationController::checkOrganizationFile');
$routes->post('rolodex/upload-file-organization','Portal\OrganizationController::uploadFileOrganization');
// $routes->post('rolodex/duplicate-handling-organization','Portal\OrganizationController::duplicateHandlingOrganization');
// $routes->post('rolodex/skip-duplicate-handling-organization','Portal\OrganizationController::skipDuplicateHandlingOrganization');
$routes->get('rolodex/load-custom-maps-organization', 'Portal\OrganizationController::loadCustomMapsOrganization');
$routes->get('rolodex/select-custom-map-organization', 'Portal\OrganizationController::selectCustomMapOrganization');
$routes->post('rolodex/review-data-organization','Portal\OrganizationController::reviewDataOrganization');
$routes->post('rolodex/import-organizations','Portal\OrganizationController::importOrganizations');
// $routes->get('rolodex/organization-conflicts/(:any)', 'Portal\OrganizationController::organizationConflicts/$1');

//organization summary
$routes->get('marketing/load-organization-summary','Portal\OrganizationController::loadOrganizationSummary');

//organization details
$routes->get('marketing/load-organization-details','Portal\OrganizationController::loadOrganizationDetails');

//organization updates
$routes->get('marketing/load-organization-updates','Portal\OrganizationController::loadOrganizationUpdates');

//organization contacts
$routes->get('marketing/load-organization-contacts','Portal\OrganizationController::loadOrganizationContacts');
$routes->post('rolodex/add-contact-to-organization-quick-form','Portal\OrganizationController::addContactToOrganizationQuickForm');
$routes->post('rolodex/add-contact-to-organization-full-form','Portal\OrganizationController::addContactToOrganizationFullForm');
$routes->post('marketing/unlink-organization-contact','Portal\OrganizationController::unlinkOrganizationContact');
$routes->get('marketing/load-unlink-organization-contacts','Portal\OrganizationController::loadUnlinkOrganizationContacts');
$routes->post('marketing/add-selected-organization-contacts','Portal\OrganizationController::addSelectedOrganizationContacts');

//organization activities
$routes->get('marketing/load-organization-activities','Portal\OrganizationController::loadOrganizationActivities');

//organization email histories
$routes->get('marketing/load-organization-emails','Portal\OrganizationController::loadOrganizationEmails');

//organization documents
$routes->get('marketing/load-organization-documents','Portal\OrganizationController::loadOrganizationDocuments');
$routes->post('marketing/unlink-organization-document','Portal\OrganizationController::unlinkOrganizationDocument');
$routes->get('marketing/load-unlink-organization-documents','Portal\OrganizationController::loadUnlinkOrganizationDocuments');
$routes->post('marketing/add-selected-organization-documents','Portal\OrganizationController::addSelectedOrganizationDocuments');
$routes->post('marketing/add-organization-document','Portal\OrganizationController::addOrganizationDocument');

//organization campaigns
$routes->get('marketing/load-organization-campaigns','Portal\OrganizationController::loadOrganizationCampaigns');
$routes->post('marketing/unlink-organization-campaign','Portal\OrganizationController::unlinkOrganizationCampaign');
$routes->get('marketing/load-unlink-organization-campaigns','Portal\OrganizationController::loadUnlinkOrganizationCampaigns');
$routes->post('marketing/add-selected-organization-campaigns','Portal\OrganizationController::addSelectedOrganizationCampaigns');

//comments
$routes->get('marketing/load-organization-comments','Portal\OrganizationController::loadOrganizationComments');
$routes->post('marketing/add-organization-comment-summary','Portal\OrganizationController::addOrganizationCommentSummary');
$routes->post('marketing/add-organization-comment','Portal\OrganizationController::addOrganizationComment');
$routes->post('marketing/reply-organization-comment','Portal\OrganizationController::replyOrganizationComment');

//organization email 
$routes->get('marketing/select-organization-email-template','Portal\OrganizationController::selectEmailTemplate');
$routes->post('marketing/send-organization-email','Portal\OrganizationController::sendOrganizationEmail');


///////////////////////////////////////////////////////////////////////
//////////////////////////// CALENDARS ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('load-calendars','Portal\CalendarController::loadCalendars');
$routes->post('add-calendar','Portal\CalendarController::addCalendar');
$routes->get('select-calendar','Portal\CalendarController::selectCalendar');
$routes->post('edit-calendar','Portal\CalendarController::editCalendar');
$routes->post('remove-calendar','Portal\CalendarController::removeCalendar');

$routes->get('calendar/load-users','Portal\CalendarController::loadUsers');

$routes->post('add-event','Portal\EventController::addEvent');
$routes->get('select-event','Portal\EventController::selectEvent');
$routes->post('edit-event','Portal\EventController::editEvent');

$routes->post('add-task','Portal\TaskController::addTask');
$routes->get('select-task','Portal\TaskController::selectTask');
$routes->post('edit-task','Portal\TaskController::editTask');


///////////////////////////////////////////////////////////////////////
//////////////////////////// DOCUMENTS ////////////////////////////////
///////////////////////////////////////////////////////////////////////

//load users on document
$routes->get('documents/load-users','Portal\DocumentController::loadUsers');

$routes->get('load-documents','Portal\DocumentController::loadDocuments');
$routes->post('add-document','Portal\DocumentController::addDocument');
$routes->get('select-document','Portal\DocumentController::selectDocument');
$routes->post('edit-document','Portal\DocumentController::editDocument');
$routes->post('remove-document','Portal\DocumentController::removeDocument');
$routes->get('download-document','Portal\DocumentController::downloadDocument');

//document updates
$routes->get('load-document-updates','Portal\DocumentController::loadDocumentUpdates');

//document contacts
$routes->get('load-selected-contact-documents','Portal\DocumentController::loadSelectedContactDocuments');
$routes->get('load-unlink-contacts','Portal\DocumentController::loadUnlinkContacts');

//document organizations
$routes->get('load-selected-organization-documents','Portal\DocumentController::loadSelectedOrganizationDocuments');
$routes->get('load-unlink-organizations','Portal\DocumentController::loadUnlinkOrganizations');


////////////////////////////////////////////////////////////////////////////
//////////////////////////// EMAIL TEMPLATE ////////////////////////////////
////////////////////////////////////////////////////////////////////////////

$routes->get('tools/load-templates/(:any)','Portal\EmailTemplateController::loadTemplates/$1');
$routes->post('tools/add-template','Portal\EmailTemplateController::addTemplate');
$routes->get('tools/select-template','Portal\EmailTemplateController::selectTemplate');
$routes->post('tools/edit-template','Portal\EmailTemplateController::editTemplate');
$routes->post('tools/remove-template','Portal\EmailTemplateController::removeTemplate');


///////////////////////////////////////////////////////////////////
//////////////////////////// USER MANAGEMENT //////////////////////
///////////////////////////////////////////////////////////////////

// $routes->get('load-users', 'Portal\UserController::loadUsers');
// $routes->post('add-user', 'Portal\UserController::addUser');
// $routes->get('load-pending-invites', 'Portal\UserController::loadPendingInvites');
// $routes->get('add-role', 'Portal\UserController::addRole');
// $routes->get('select-role/(:num)','Portal\UserController::selectRole/$1');

$routes->get('user-management/load-users','Portal\UserController::loadUsers');
$routes->post('user-management/add-user','Portal\UserController::addUser');
$routes->get('user-management/select-user','Portal\UserController::selectUser');
$routes->post('user-management/edit-user','Portal\UserController::editUser');
$routes->post('user-management/remove-user','Portal\UserController::removeUser');

$routes->get('user-management/load-roles', 'Portal\RoleController::loadRoles');
$routes->post('user-management/add-role', 'Portal\RoleController::addRole');
$routes->get('user-management/select-role', 'Portal\RoleController::selectRole');
$routes->post('user-management/edit-role', 'Portal\RoleController::editRole');
$routes->post('user-management/remove-role', 'Portal\RoleController::removeRole');

$routes->get('user-management/load-organization-name', 'Portal\RoleController::loadOrganizationName');
$routes->post('user-management/edit-organization-name', 'Portal\RoleController::editOrganizationName');

$routes->get('user-management/load-profiles', 'Portal\ProfileController::loadProfiles');
$routes->post('user-management/add-profile', 'Portal\ProfileController::addProfile');
$routes->get('user-management/select-profile', 'Portal\ProfileController::selectProfile');
$routes->post('user-management/edit-profile', 'Portal\ProfileController::editProfile');
$routes->post('user-management/remove-profile', 'Portal\ProfileController::removeProfile');

/////////////////////////////////////////////////////////////////////
//////////////////////////// SETTINGS ////////////////////////////////
/////////////////////////////////////////////////////////////////////

/*--------------------- Email Configuration -------------------------*/
$routes->post('settings/add-email-config', 'Portal\EmailConfigurationController::addEmailConfig');
$routes->get('settings/select-email-config', 'Portal\EmailConfigurationController::selectEmailConfig');
$routes->post('settings/edit-email-config', 'Portal\EmailConfigurationController::editEmailConfig');
$routes->post('settings/test-email-config', 'Portal\EmailConfigurationController::testEmailConfig');
$routes->get('settings/check-system-updates', 'Portal\SystemUpdateController::checkSystemUpdates');
$routes->get('settings/apply-system-updates', 'Portal\SystemUpdateController::applySystemUpdates');

$routes->get('settings/update-database','Portal\SystemUpdateController::updateDatabase');


/////////////////////////////////////////////////////////////////////
//////////////////////////// MY ACCOUNT ////////////////////////////////
/////////////////////////////////////////////////////////////////////

$routes->get('load-my-account', 'Portal\MyAccountController::loadMyAccount');
$routes->post('change-my-account-picture', 'Portal\MyAccountController::changeMyAccountPicture');
$routes->get('load-my-account-details', 'Portal\MyAccountController::loadMyAccountDetails');
$routes->post('edit-my-account-details', 'Portal\MyAccountController::editMyAccountDetails');
$routes->post('edit-my-account-password', 'Portal\MyAccountController::editMyAccountPassword');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
