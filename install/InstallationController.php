<?php


class InstallationController {

	public function index()
	{
		try 
		{
				define('FCPATH', str_replace(DIRECTORY_SEPARATOR . 'install','',__DIR__ . DIRECTORY_SEPARATOR));

				$arrData = [
			    ['PHP Version','7.4 or Newer',phpversion()],
			    ['Intl Extension','Yes',(extension_loaded('intl'))?'Yes':'No'],
			    ['Mbstring Extension','Yes',(extension_loaded('mbstring'))?'Yes':'No'],
			    ['JSON Extension','Yes',(extension_loaded('json'))?'Yes':'No'],
			    ['Mysqlnd Extension','Yes',(extension_loaded('mysqlnd'))?'Yes':'No'],
			    ['XML Extension','Yes',(extension_loaded('xml'))?'Yes':'No'],
			    ['libcurl Extension','Yes',(extension_loaded('curl'))?'Yes':'No'],
				];

				$myfile = file_get_contents(FCPATH."install".DIRECTORY_SEPARATOR."index.sample.php");
				$result = file_put_contents(FCPATH."index.php",$myfile);

				echo json_encode($arrData);
		}
		catch (Exception $e) 
		{
			echo json_encode($e->getMessage());
		}
	}

	public function stepThreeBack()
	{
		try 
		{
			define('FCPATH', str_replace(DIRECTORY_SEPARATOR . 'install','',__DIR__ . DIRECTORY_SEPARATOR));
			
			$myfile = file_get_contents(FCPATH."install".DIRECTORY_SEPARATOR."index.install.php");
			$result = file_put_contents(FCPATH."index.php",$myfile);

			echo json_encode($result);
		} 
		catch (\Exception $e) 
		{
			echo json_encode($e->getMessage());
		}
	}

}

$install = new InstallationController();


if($_GET['action'] == 'submitStepTwo')
{
	$install->index();
}

if($_GET['action'] == 'stepThreeBack')
{
	$install->stepThreeBack();
}