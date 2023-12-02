<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class InstallationController extends BaseController
{
	public function installationStepFour()
	{
		$fields = $this->request->getPost();

		$myfile = file_get_contents(FCPATH."env");

		$myfile = preg_replace('/__ENVIRONMENT__/i', 'development', $myfile);
		$myfile = preg_replace('/__BASE_URL__/i', $fields['txt_baseUrl'], $myfile);
		$myfile = preg_replace('/__HOST_NAME__/i', $fields['txt_hostName'], $myfile);
		$myfile = preg_replace('/__DATABSE_NAME__/i', $fields['txt_databaseName'], $myfile);
		$myfile = preg_replace('/__USERNAME__/i', $fields['txt_hostUserName'], $myfile);
		$myfile = preg_replace('/__PASSWORD__/i', $fields['txt_hostUserPassword'], $myfile);
		$myfile = preg_replace('/__PORT__/i', '3306', $myfile);

		$result = file_put_contents(FCPATH.".env",$myfile);

		try 
		{
			$servername = $fields['txt_hostName'];
			$username   = $fields['txt_hostUserName'];
			$password   = $fields['txt_hostUserPassword'];

			$conn = mysqli_connect($servername, $username, $password);

			if (!$conn) 
			{
				return $this->response->setJSON(["Error","<b>Connection failed:</b> " . mysqli_connect_error()]);
				exit();
			}

			if($fields['chk_createDatabase'] == 1)
			{
				try 
				{
					$sql = "CREATE DATABASE " . $fields['txt_databaseName'];
					if (mysqli_query($conn, $sql)) 
					{
						return $this->response->setJSON(["Success","Database created successfully"]);
					} 
					else 
					{
						return $this->response->setJSON(["Error","<b>Error creating database:</b> " . mysqli_error($conn)]);
						exit();
					}
				} 
				catch (\Exception $e) 
				{
					return $this->response->setJSON(["Error","<b>Error creating database:</b> " . mysqli_error($conn)]);
					exit();
				}
			}
			else
			{
				try 
				{
					$dbName = $fields['txt_databaseName'];
					$sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) 
					{
						return $this->response->setJSON(["Success","Connected successfully"]);
					}
					else
					{
						return $this->response->setJSON(["Error","<b>$dbName</b> database not found! Back to System Configuration and check 'Create New Database'."]);
					}
				} 
				catch (\Exception $e) 
				{
					return $this->response->setJSON(["Error","<b>Error connecting to database:</b> " . mysqli_error($conn)]);
					exit();
				}
			}
		} 
		catch (\Exception $e) 
		{
			return $this->response->setJSON(["Error","<b>Connection failed:</b> " . mysqli_connect_error()]);
			exit();
		}
	}

	public function installationStepFive()
	{
		$migrate = \Config\Services::migrations();
		$seeder = \Config\Database::seeder();

		$fields = $this->request->getPost();

		try 
		{
			$migrate->latest();

			$filePath = 'app'.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Seeds'.DIRECTORY_SEPARATOR.'UsersSeeder.example.php';
			$myfile = file_get_contents(FCPATH.$filePath);

			$myfile = preg_replace('/__SALUTATION__/i', '', $myfile);
			$myfile = preg_replace('/__FIRST_NAME__/i', $fields['txt_firstName'], $myfile);
			$myfile = preg_replace('/__LAST_NAME__/i', $fields['txt_lastName'], $myfile);
			$myfile = preg_replace('/__POSITION__/i', '', $myfile);
			$myfile = preg_replace('/__USER_EMAIL__/i', $fields['txt_email'], $myfile);
			$myfile = preg_replace('/__USER_NAME__/i', $fields['txt_username'], $myfile);
			$myfile = preg_replace('/__USER_PASSWORD__/i', encrypt_code($fields['txt_password']), $myfile);
			$myfile = preg_replace('/__USER_AUTH_CODE__/i', encrypt_code('asd123'), $myfile);
			$myfile = preg_replace('/__PASSWORD_AUTH_CODE__/i', null, $myfile);

			$filePath = 'app'.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Seeds'.DIRECTORY_SEPARATOR.'UsersSeeder.php';
			$result = file_put_contents(FCPATH.$filePath,$myfile);

			$result = $seeder->call('UsersSeeder');
			$result = $seeder->call('RolesSeeder');
			$result = $seeder->call('ProfilesSeeder');

			return $this->response->setJSON(["Success","Installation in Progress!"]);
		} 
		catch (\Throwable $e) 
		{
			return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
		}

	}

	// public function installationStepSix()
	// {
	// 	try 
	// 	{
	// 		exec('git init');
	// 		return $this->response->setJSON(["Success","Installation in Progress!"]);
	// 	} 
	// 	catch (\Throwable $e) 
	// 	{
	// 		return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
	// 	}

	// }

	// public function gitAddInit()
	// {
	// 	try 
	// 	{
	// 		exec('git add .');
	// 		return $this->response->setJSON(["Success","Installation in Progress!"]);
	// 	} 
	// 	catch (\Throwable $e) 
	// 	{
	// 		return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
	// 	}
	// }

	// public function gitCommitInit()
	// {
	// 	try 
	// 	{
	// 		exec('git commit -m "Initial Commit"');
	// 		return $this->response->setJSON(["Success","Installation in Progress!"]);
	// 	} 
	// 	catch (\Throwable $e) 
	// 	{
	// 		return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
	// 	}
	// }

	// public function gitAdd()
	// {
	// 	try 
	// 	{
	// 		$filePath = '.gitignore.sample';
	// 		$myfile = file_get_contents(FCPATH.$filePath);

	// 		$filePath = '.gitignore';
	// 		$result = file_put_contents(FCPATH.$filePath,$myfile);

	// 		exec('git add .');
	// 		return $this->response->setJSON(["Success","Installation in Progress!"]);
	// 	} 
	// 	catch (\Throwable $e) 
	// 	{
	// 		return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
	// 	}
	// }

	// public function gitCommit()
	// {
	// 	try 
	// 	{
	// 		exec('git commit -m "Fix conflict on .gitignore file"');
	// 		return $this->response->setJSON(["Success","Installation in Progress!"]);
	// 	} 
	// 	catch (\Throwable $e) 
	// 	{
	// 		return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
	// 	}
	// }

	// public function gitRemote()
	// {
	// 	try 
	// 	{
	// 		exec('git remote add github "git@github.com:rportojr/ARK-CRM.git"');
	// 		return $this->response->setJSON(["Success","Installation in Progress!"]);
	// 	} 
	// 	catch (\Throwable $e) 
	// 	{
	// 		return $this->response->setJSON(["Error","<b>Something went wrong</b>"]);
	// 	}
	// }

}
