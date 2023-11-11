<?php

// require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

function readUploadFile($excelFile, $sheets = null)
{
	$reader = IOFactory::createReaderForFile($excelFile);

	($sheets != null)?$reader->setLoadSheetsOnly($sheets):FALSE;
	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load($excelFile);
	$sheetData = $spreadsheet->getActiveSheet()->toArray();
	// (count($sheetData) > 1)?array_shift($sheetData):FALSE;

	return $sheetData;
}

function checkData($data, $date = null, $ext = null)
{
	$arrVal = ["NULL","null","","N/A","n/a","NA","na"];

	if($date == null)
	{
		$result = (in_array($data,$arrVal))? null : $data;
	}
	elseif($date == "d")
	{
		if($ext == "csv")
		{
			$result = (in_array($data,$arrVal))? null : date("Y-m-d", strtotime($data));
		}
		else
		{
			$result = (in_array($data,$arrVal))? null : date("Y-m-d", ($data - 25569)*86400);
		}
		
	}
	else
	{
		$result = null;
	}
	
	return $result;
}

function getSheets($excelFile)
{
	$reader = IOFactory::createReaderForFile($excelFile);

	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load($excelFile);
	$sheetCount = $spreadsheet->getSheetCount();

	$arrSheetNames = [];
	for ($i=0; $i < $sheetCount; $i++) 
	{ 
		array_push($arrSheetNames,$spreadsheet->getSheetNames()[$i]);
	}

	return $arrSheetNames;
}

function getFileType($excelFile)
{
	$fileType = IOFactory::identify($excelFile);

	return $fileType;
}

function saveUploadFile($excelFile, $fileName = null, $filePath = "./assets/")
{
	$spreadsheet = IOFactory::load($excelFile);
	$fileType = getFileType($excelFile);
	$writer = IOFactory::createWriter($spreadsheet, $fileType);
	$fileName = ($fileName != null)? $fileName : round(microtime(true)); 
	$writer->save("{$filePath}{$fileName}.{$fileType}");
}

function formatArray($fileData)
{
	$arrayData = [];
	foreach ($fileData as $key => $value) 
	{
		$arrayData[] = [$key+1 => $fileData[$key]];
	}

	return $arrayData;
}


function checkDuplicate($arrayData)
{
	/*
		if $handling is false 
			: skip/abort upload when the system detects a duplicate entries
			return duplicate entries
		else 

			: select single row from duplicate entries and proceed to uploading.
			return number of rows uploaded
	*/

	$arrayData = formatArray($arrayData);

	$withoutConflicts = [];
	$arrConflicts = [];
	$withConflicts = [];
	$arrRows = [];
	foreach ($arrayData as $key => $value) 
	{
		$arrTempRows = [];
		foreach ($arrayData as $keys => $values) 
		{
			// $arrDiffResult = array_diff($value[$key+1],$values[$keys+1]);
			$val1 = [$value[$key+1]['prcNumber']];
			$val2 = [$values[$keys+1]['prcNumber']];
			$arrDiffResult = array_diff($val1,$val2);
			$searchResult = in_array($keys+1,$arrRows);
			if(count($arrDiffResult) == 0 && !$searchResult)
			{
				array_push($arrTempRows,$keys+1);
			}
		}

		if(count($arrTempRows) > 1)
		{
			array_push($arrConflicts,$value[$key+1]);
			$arrayResult = ['conflictRows'=>$arrTempRows, 'conflictEntries'=>$value[$key+1]];
			array_push($withConflicts,$arrayResult);
			foreach($arrTempRows as $k => $v)
			{
				array_push($arrRows, $v);
			}
		}
		elseif(count($arrTempRows) == 1)
		{
			array_push($withoutConflicts,$value[$key+1]);
		}
	}

	$conflictRows = [];
	foreach ($withConflicts as $key => $value) 
	{
		array_push($conflictRows,$value['conflictEntries']);
	}

	$forUpload = array_merge($withoutConflicts,$conflictRows);

	$arrayFileResult = [
		'forUploadRows' => $forUpload,
		'withConflicts' => $withConflicts
	];

	return $arrayFileResult;
	// return $arrayData;
}

function checkDuplicateRows($rawData, $uniqueColumns)
{
	$rowConflictNumberArr = [];
	$rowConflictDataArr = [];
	foreach ($uniqueColumns as $key1 => $value1) 
	{
		$rowNumber = 1;
		foreach ($rawData as $key2 => $value2) 
		{
			$tempData = $value2[$value1];
			$rowNumber++;
			$countDuplicate = 0;
			foreach ($rawData as $key3 => $value3) 
			{
				// if($tempData == $value3[$value1] && $tempData != null)
				if(strcasecmp($tempData,$value3[$value1]) == 0 && $tempData != null)
				{
					$countDuplicate++;
				}
			}
			if($countDuplicate > 1)
			{
				if(!in_array($rowNumber,$rowConflictNumberArr))
				{
					$rowConflictNumberArr[] = $rowNumber;
					$value2['rowNumber'] = $rowNumber;
					$rowConflictDataArr[] = $value2;
				}
			}
		}
	}

	$rowNumberArr = [];
	$rowDataArr = [];
	$rowNumber = 1;
	foreach ($rawData as $key => $value)
	{
		$rowNumber++;
		if(!in_array($rowNumber, $rowConflictNumberArr))
		{
			$rowNumberArr[] = $rowNumber;
			$rowDataArr[] = $value;
		}
	}

	$finalDataArr = [
		'rowConflictData' => $rowConflictDataArr,
		'rowData' => $rowDataArr
	];

	return $finalDataArr;
}

function downloadContactConflicts($filename, $rawData = [], $header = [])
{
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	$column = [
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
	];
	$arrColumns = [];
	for ($i=0; $i < count($header); $i++) 
	{ 
		$arrColumns[] = ["{$column[$i]}1", $header[$i]];
	}

	foreach ($arrColumns as $key => $value) 
	{
		$sheet->setCellValue($value[0], $value[1]);
	}

	$index = 1;
	foreach ($rawData as $key => $value) 
	{
		$index++;
		for ($i=0; $i < count($header); $i++) 
		{ 
			$sheet->setCellValue("{$column[$i]}{$index}",$value["$header[$i]"]);
		}
	}

	$writer = new Xlsx($spreadsheet);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'. $filename .'"'); 
	header('Cache-Control: max-age=0');

	$writer->save('php://output'); // download file 

	exit();
}

function downloadOrganizationConflicts($filename, $rawData = [], $header = [])
{
   	$spreadsheet = new Spreadsheet();
   	$sheet = $spreadsheet->getActiveSheet();
	
   	$column = [
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
	];
	$arrColumns = [];
	for ($i=0; $i < count($header); $i++) 
	{ 
		$arrColumns[] = ["{$column[$i]}1", $header[$i]];
	}

	foreach ($arrColumns as $key => $value) 
	{
		$sheet->setCellValue($value[0], $value[1]);
	}

	$index = 1;
	foreach ($rawData as $key => $value) 
	{
		$index++;
		for ($i=0; $i < count($header); $i++) 
		{ 
			$sheet->setCellValue("{$column[$i]}{$index}",$value["$header[$i]"]);
		}
	}

   $writer = new Xlsx($spreadsheet);

   header('Content-Type: application/vnd.ms-excel');
   header('Content-Disposition: attachment;filename="'. $filename .'"'); 
   header('Cache-Control: max-age=0');

   $writer->save('php://output'); // download file 

   exit();
}

function downloadConflictRows($filename, $rawData = [])
{
  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $arrColumns = [
    ['A1','No.'],
    ['B1','PRC Number'],
    ['C1','First Name'],
    ['D1','Middle Name'],
    ['E1','Last Name'],
    ['F1','Email Address'],
    ['G1','Contact Number'],
    ['H1','Completed Units'],
    ['I1','Completed Dates'],
  ];

  foreach ($arrColumns as $key => $value) 
  {
    $sheet->setCellValue($value[0], $value[1]);
  }

  $index = 1;
  foreach ($rawData as $key => $value) 
  {
    $index++;
    $sheet->setCellValue("A{$index}", $index - 1);
    $sheet->setCellValue("B{$index}", $value['prc_number']);
    $sheet->setCellValue("C{$index}", $value['first_name']);
    $sheet->setCellValue("D{$index}", $value['middle_name']);
    $sheet->setCellValue("E{$index}", $value['last_name']);
    $sheet->setCellValue("F{$index}", $value['email_address']);
    $sheet->setCellValue("G{$index}", $value['contact_number']);
    $sheet->setCellValue("H{$index}", $value['completed_units']);
    $sheet->setCellValue("I{$index}", $value['completed_dates']);
  }
  

  $writer = new Xlsx($spreadsheet);

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'. $filename .'"'); 
  header('Cache-Control: max-age=0');

  $writer->save('php://output'); // download file 
}

function downloadCertificateList($filename, $rawData = [])
{
  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $arrColumns = [
    ['A1','No.'],
    ['B1','Name'],
    ['C1','PRC License #'],
    ['D1','Classification'],
    ['E1','Title'],
    ['F1','Control Number'],
    ['G1','Serial Code'],
    ['H1','Certificate Status'],
    ['I1','Date Issued'],
    ['J1','Date Conducted'],
    ['K1','Expiry Date'],
    ['L1','Units Earned'],
    ['M1','Download Count'],
  ];

  foreach ($arrColumns as $key => $value) 
  {
    $sheet->setCellValue($value[0], $value[1]);
  }

  $index = 1;
  foreach ($rawData as $key => $value) 
  {
    $index++;
    $sheet->setCellValue("A{$index}", $index - 1);
    $sheet->setCellValue("B{$index}", $value['participant_first_name'] . " " . $value['participant_middle_name'] . " " . $value['participant_last_name']);
    $sheet->setCellValue("C{$index}", $value['participant_prc_number']);
    $sheet->setCellValue("D{$index}", $value['event_classification']);
    $sheet->setCellValue("E{$index}", strip_tags($value['event_title']));
    $sheet->setCellValue("F{$index}", $value['control_number']);
    $sheet->setCellValue("G{$index}", decrypt_code($value['serial_code']));
    $sheet->setCellValue("H{$index}", $value['certificate_status']);
    $sheet->setCellValue("I{$index}", $value['event_issued_on']);
    $sheet->setCellValue("J{$index}", $value['event_conducted_date']);
    $sheet->setCellValue("K{$index}", $value['event_expiry_date']);
    $sheet->setCellValue("L{$index}", $value['participant_completed_units']);
    $sheet->setCellValue("M{$index}", $value['download_count']);
  }
  

  $writer = new Xlsx($spreadsheet);

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'. $filename .'"'); 
  header('Cache-Control: max-age=0');

  $writer->save('php://output'); // download file 
}