<?php

/**
 * ImportCSV Module
 *
 * @author Artem Demchenkov <lunoxot@mail.ru>
 * @version 0.0.3
 *
 * ImportCSV is used for load positions from CSV file to database.
 * Import occurs in three steps:
 *
 * Upload file;
 * Select delimiter and table;
 * Select mode and columns in table.
 * Module has 3 modes:
 * 
 * Insert all - Add all rows;
 * Insert new - Add new rows. Old rows remain unchanged;
 * Insert new and replace old - Add new rows. Old rows replace.
 * All parameters from the previous imports will be saved in a special .php file in upload folder.
 * 
 * Requirements 
 * 
 * Yii 1.1
 * 
 * Usage 
 * 
 * 1) Copy all the 'importcsv' folder under /protected/modules;
 * 
 * 2) Register this module in /protected/config/main.php
 * 
 * 'modules'=>array(
 *         .........
 *         'importcsv'=>array(
 *             'path'=>'upload/importCsv/', // path to folder for saving csv file and file with import params
 *         ),
 *         ......
 *     ),
 * 3) Create a directory which you use in 'path'. Do not forget to set access permissions for directory 'path';
 * 
 * 4) The module is available here:
 * 
 * http://yourproject/importcsv.
 * 
 * Or here:
 * 
 * http://yourproject/index.php?r=importcsv.
 * 
 * Or somewhere else:-) It depends from path settings in your project;
 * 
 * 5) ATTENTION! The first row of your csv-file must will be a row with column names. 
 *
*/

class DefaultController extends RController {

    public $colsArray = array();
	
	public function filters(){
		return array(
			'rights'
		);
	}

    /*
     * action for form
     */

    public function actionIndex() {
		
		//var_dump($_POST['ExtColumns']);
		
		$delimiter 		= Yii::app()->controller->module->delimiter;
		$textDelimiter 	= Yii::app()->controller->module->textDelimiter;
		$table			= Yii::app()->controller->module->table;
		$perRequest		= Yii::app()->controller->module->perRequest;
		$mode			= Yii::app()->controller->module->mode;
		$tableKey		= Yii::app()->controller->module->tableKey;
		$csvKey			= Yii::app()->controller->module->csvKey;
		
		
		//new configyarations
		$models			=	Yii::app()->controller->module->models;
		
		//publish css and js
	
		Yii::app()->clientScript->registerCssFile(
			Yii::app()->assetManager->publish(
				Yii::getPathOfAlias('application.modules.importcsv.assets') . '/styles.css'
			)
		);
	
		Yii::app()->clientScript->registerScriptFile(
			Yii::app()->assetManager->publish(
				Yii::getPathOfAlias('application.modules.importcsv.assets') . '/ajaxupload.js'
			)
		);
	
		Yii::app()->clientScript->registerScript('uploadActionPath', 'var uploadActionPath="' . $this->createUrl('default/upload') . '"', CClientScript::POS_BEGIN);
	
		Yii::app()->clientScript->registerScriptFile(
			Yii::app()->assetManager->publish(
				Yii::getPathOfAlias('application.modules.importcsv.assets') . '/download.js'
			)
		);
		
		
	
		//getting models for import
		if(is_array($models) and count($models)>0){
			foreach($models as $smodel=>$params){
				if(class_exists($smodel, true))
					$modelsArray[$smodel] = (isset($params['label']))?$params['label']:$smodel;
			}			
		}
		else{
			foreach(glob('./protected/models/*.php') as $filename){
				$modelname		=	str_replace(array("./protected/models/", ".php"), "", $filename);
				$modelsArray[$modelname]	=	$modelname;
			}
		}		
	
		if (Yii::app()->request->isAjaxRequest) {
			if ($_POST['thirdStep'] != 1) {
				//second step
		
				$delimiter = str_replace('&quot;', '"', str_replace("&#039;", "'", CHtml::encode(trim($_POST['delimiter']))));
				$textDelimiter = str_replace('&quot;', '"', str_replace("&#039;", "'", CHtml::encode(trim($_POST['textDelimiter']))));
				
				
				//$table = CHtml::encode($_POST['table']);
				
				//getting table name from model name
				$selectedmodel 	=	CHtml::encode($_POST['model']);
				$table			=	$selectedmodel::model()->tableSchema->name;
		
				if ($_POST['delimiter'] == '') {
					$error = 1;
					$csvFirstLine = array();
					$paramsArray = array();
				} else {
					// get all columns from csv file
					$error = 0;
					$uploadfile = $_POST['fileName'];
					$file = fopen($uploadfile, "r");
					$csvFirstLine = ($textDelimiter) ? fgetcsv($file, 0, $delimiter, $textDelimiter) : fgetcsv($file, 0, $delimiter);
					fclose($file);
		
					// checking file with earlier imports	
					$paramsArray = $this->checkOldFile($uploadfile);
				}
		
				//get all columns from selected table
		
				$model = new ImportCsv;
				if(isset($models[$selectedmodel]['allowedColumns']) and $models[$selectedmodel]['allowedColumns']!='all'){
					$tableColumns	=	$models[$selectedmodel]['allowedColumns'];
				}
				else{
					$tableColumns 	=	$model->tableColumns($table);
				}				
				
				//picking required columns
				if(isset($models[$selectedmodel]['requiredColumns'])){
					$requiredColumns	=	$models[$selectedmodel]['requiredColumns'];
				}
				else{
					$requiredColumns 	=	'';
				}
				
		
				$this->layout = 'clear';
				$this->render('secondResult', array(
					'error' => $error,
					'tableColumns' => $tableColumns,
					'requiredColumns' => $requiredColumns,
					'delimiter' => $delimiter,
					'textDelimiter' => $textDelimiter,
					'table' => $table,
					'fromCsv' => $csvFirstLine,
					'paramsArray' => $paramsArray,
					'selectedmodel' => $selectedmodel,
				));
			} else {
				//third step
				$delimiter 		=	str_replace('&quot;', '"', str_replace("&#039;", "'", CHtml::encode(trim($_POST['thirdDelimiter']))));
				$textDelimiter 	=	str_replace('&quot;', '"', str_replace("&#039;", "'", CHtml::encode(trim($_POST['thirdTextDelimiter']))));
				$table 			=	CHtml::encode($_POST['thirdTable']);
				$uploadfile 	=	CHtml::encode(trim($_POST['thirdFile']));
				$columns 		=	$_POST['Columns'];
				$perRequest 	=	CHtml::encode($_POST['perRequest']);
				$tableKey 		=	CHtml::encode($_POST['Tablekey']);
				$csvKey 		=	CHtml::encode($_POST['CSVkey']);
				$mode 			=	Yii::app()->controller->module->mode;
				
				
				$insertArray 	= array();
				$error_array 	= array();
				
				$selectedmodel 		=	CHtml::encode($_POST['hmodel']);				
				$allowedColumns		=	$models[$selectedmodel]['allowedColumns'];
				$requiredColumns	=	$models[$selectedmodel]['requiredColumns'];
				$uniqueColumns		=	$models[$selectedmodel]['uniqueColumns'];
				$dataTypes			=	$models[$selectedmodel]['dataTypes'];
				$external_entry		=	$models[$selectedmodel]['external'];
				$compare_entry		=	$models[$selectedmodel]['compare'];
				
				$total_rows			= 	0;
				$total_rows_inserted=	0;
				$exceptions			= 	array();
				$warnings			=  	array();
				
				if($requiredColumns==NULL)
					$requiredColumns	=	array();
		
				//required fields checking				
				$allSelected	=	true;
				
				if($requiredColumns=='all'){
					foreach($_POST['Columns'] as $index=>$singleColumn){
						if($singleColumn=='') $allSelected=false;
					}
				}
				else if(count($requiredColumns)>0){
					foreach($_POST['Columns'] as $index=>$singleColumn){
						if(in_array($allowedColumns[$index], $requiredColumns) and $singleColumn=='') $allSelected=false;
					}
				}
				
				//externals if any
				$externals	= NULL;
				if($external_entry){
					$externals	= (isset($_POST['ExtColumns']))?$_POST['ExtColumns']:NULL;
					foreach($external_entry as $field=>$entry){						
						if(isset($entry['requiredColumns'])){
							$ext_req_cols	=	$entry['requiredColumns'];
							foreach($ext_req_cols as $col){
								if(!isset($_POST['ExtColumns'][$field][$col]) or $_POST['ExtColumns'][$field][$col]==""){
									$allSelected=false;
								}
							}
						}
					}
				}
				
				//compare fileds validation if any
				$compares	= NULL;
				if($compare_entry){
					$compares	= (isset($_POST['CompColumns']))?$_POST['CompColumns']:NULL;
					foreach($compare_entry as $field=>$entry){						
						if(isset($entry['requiredColumns'])){
							$cmp_req_cols	=	$entry['requiredColumns'];
							foreach($cmp_req_cols as $col){
								if(!isset($compares[$field][$col]) or $compares[$field][$col]==""){
									$allSelected=false;
								}
							}
						}
					}
				}
				
				if($allSelected==true){
					if ($_POST['perRequest'] != '') {
						if (is_numeric($_POST['perRequest'])) {		
			
							if (($mode == 2 || $mode == 3) && ($tableKey == '' || $csvKey == '')) {
								$error = 4;
							} else {
								$error = 0;
				
								//import from csv to db
				
								$model = new ImportCsv;
								if(isset($models[$selectedmodel]['allowedColumns']) and $models[$selectedmodel]['allowedColumns']!='all'){
									$tableColumns	=	$models[$selectedmodel]['allowedColumns'];
								}
								else{
									$tableColumns = $model->tableColumns($table);
								}
				
								//select old rows from table
				
								if ($mode == 2 || $mode == 3) {
									$oldItems = $model->selectRows($table, $tableKey);
								}
				
								$filecontent = file($uploadfile);
								$lengthFile = sizeof($filecontent);
								$insertCounter = 0;
								$stepsOk = 0;
				
								// begin transaction
				
								$transaction = Yii::app()->db->beginTransaction();
								try {
				
									// import to database
				
									for ($i = 0; $i < $lengthFile; $i++) {
										if ($i != 0 && $filecontent[$i] != '') {
											$csvLine = ($textDelimiter) ? str_getcsv($filecontent[$i], $delimiter, $textDelimiter) : str_getcsv($filecontent[$i], $delimiter);
					
											//Mode 1. insert All
											
											if ($mode == 1) {
												$insertArray[] = $csvLine;
												$insertCounter++;
												
												if ($insertCounter == $perRequest || $i == $lengthFile - 1) {
													$import = $model->InsertAll($table, $insertArray, $columns, $tableColumns, $selectedmodel, $allowedColumns, $dataTypes, $uniqueColumns, $externals, $compares);
													$insertCounter = 0;
													$insertArray = array();
						
													if ($import['status'] != 1)
														$arrays[] = $i;
													$exceptions	=	$import['exceptions'];
													$warnings	=	$import['warnings'];
													$total_rows	=	$import['total_rows'];
													$total_rows_inserted = $import['total_rows_inserted'];
												}
											}
					
											// Mode 2. Insert new
					
											if ($mode == 2) {
												if ($csvLine[$csvKey - 1] == '' || !$this->searchInOld($oldItems, $csvLine[$csvKey - 1], $tableKey)) {
													$insertArray[] = $csvLine;
													$insertCounter++;
													if ($insertCounter == $perRequest || $i == $lengthFile - 1) {
														$import = $model->InsertAll($table, $insertArray, $columns, $tableColumns);
														$insertCounter = 0;
														$insertArray = array();
							
														if ($import != 1)
															$arrays[] = $i;
													}
												}
											}
					
											// Mode 3. Insert new and replace old
					
											if ($mode == 3) {
												if ($csvLine[$csvKey - 1] == '' || !$this->searchInOld($oldItems, $csvLine[$csvKey - 1], $tableKey)) {
						
													// insert new
													$insertArray[] = $csvLine;
													$insertCounter++;
													if ($insertCounter == $perRequest || $i == $lengthFile - 1) {
														$import = $model->InsertAll($table, $insertArray, $columns, $tableColumns);
														$insertCounter = 0;
														$insertArray = array();
							
														if ($import != 1)
															$arrays[] = $i;
													}
												}
												else {
						
													//replace old
						
													$import = $model->updateOld($table, $csvLine, $columns, $tableColumns, $csvLine[$csvKey - 1], $tableKey);
						
													if ($import != 1)
													$arrays[] = $i;
												}
											}
										}
									}
									
									if ($insertCounter != 0)
										$model->InsertAll($table, $insertArray, $columns, $tableColumns);
				
									// commit transaction if not exception
				
									$transaction->commit();
								} catch (Exception $e) { // exception in transaction
									$transaction->rollBack();
								}
				
								// save params in file
								//$this->saveInFile($table, $delimiter, $mode, $perRequest, $csvKey, $tableKey, $tableColumns, $columns, $uploadfile, $textDelimiter);
								
								//remove file after uploading
								$this->removefile($uploadfile);			
							
							}
						} else {
							$error = 3;
						}
					} else {
						$error = 2;
					}
				} else {
					$error = 1;
				}
		
				$this->layout = 'clear';
				$this->render('thirdResult', array(
					'error' => $error,
					'delimiter' => $delimiter,
					'textDelimiter' => $textDelimiter,
					'table' => $table,
					'uploadfile' => $uploadfile,
					'error_array' => $error_array,
					'exceptions' => $exceptions,
					'warnings' => $warnings,
					'total_rows' => $total_rows,
					'total_rows_inserted' => $total_rows_inserted,
				));
			}
	
			Yii::app()->end();
		} else {
			// first loading
			$this->render('index', array(
			'delimiter' => $delimiter,
			'table'=>$table,
			'textDelimiter' => $textDelimiter,
			'modelsArray' => $modelsArray,
			));
		}
    }

    /*
     * action for file upload
     */

    public function actionUpload() {
		$uploaddir 	= Yii::app()->controller->module->path;
		
		$directories = glob($uploaddir . '*' , GLOB_ONLYDIR);
		foreach($directories as $key=>$dir){
			$directories[$key]	=	 str_replace($uploaddir, '', $dir);
		}
		if(count($directories)>0){
			$newdir	=	max($directories) + 1;
		}
		else{
			$newdir	=	1;
		}
		
		mkdir($uploaddir . $newdir. '/');
		
		$uploadfile = $uploaddir . $newdir. '/' .basename($_FILES['myfile']['name']);
	
		$name_array = explode(".", $_FILES['myfile']['name']);
		$type = end($name_array);
	
		if ($type == "csv") {
			if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile)) {
			$importError = 0;
			} else {
			$importError = 1;
			}
		} else {
			$importError = 2;
		}
	
		// checking file with earlier imports
	
		$paramsArray = $this->checkOldFile($uploadfile);
		$delimiterFromFile = $paramsArray['delimiter'];
		$textDelimiterFromFile = $paramsArray['textDelimiter'];
		$tableFromFile = $paramsArray['table'];
	
		// view rendering
	
		$this->layout = 'clear';
		$this->render('firstResult', array(
			'error' => $importError,
			'uploadfile' => $uploadfile,
			'delimiterFromFile' => $delimiterFromFile,
			'textDelimiterFromFile' => $textDelimiterFromFile,
			'tableFromFile' => $tableFromFile,
		));
    }

    /*
     * search needle in old rows
     * 
     *  $array  - array with old items from database
     *  $needle - value from csv
     *  $key    - db column, where we search $needle
     *  @return boolean
     * 
     */

    public function searchInOld($array, $needle, $key) {
	$return = false;
	$arrayLength = sizeof($array);
	for ($i = 0; $i < $arrayLength; $i++) {
	    if ($array[$i][$key] == $needle)
		$return = true;
	}

	return $return;
    }

    /*
     * save import params in php file, for using in next imports
     *
     *  $table - db table
     *  $delimiter - csv delimiter
     *  $textDelimiter - csv text delimiter
     *  $mode - import mode
     *  $perRequest - items in one INSERT - mode
     *  $csvKey - key for compare from csv
     *  $tableKey - key for compare from table
     *  $tableColumns - list of table columns
     *  $csvColumns - list of csv columns
     *  $uploadfile - path to import file
     *
     */

    public function saveInFile($table, $delimiter, $mode, $perRequest, $csvKey, $tableKey, $tableColumns, $csvColumns, $uploadfile, $textDelimiter) {
	$columnsSize = sizeof($tableColumns);
	$columns = '';
	for ($i = 0; $i < $columnsSize; $i++) {
	    $columns = ($csvColumns[$i] != "") ? $columns . '"' . $tableColumns[$i] . '"=>' . $csvColumns[$i] . ', ' : $columns . '"' . $tableColumns[$i] . '"=>"", ';
	}

	$delimiter = addslashes($delimiter);
	$textDelimiter = addslashes($textDelimiter);

	$arrayToFile = '<?php
                $paramsArray = array(
                    "table"=>"' . $table . '",
                    "delimiter"=>"' . $delimiter . '",
		    "textDelimiter"=>"' . $textDelimiter . '",
                    "mode"=>' . $mode . ',
                    "perRequest"=>' . $perRequest . ',
                    "csvKey"=>"' . $csvKey . '",
                    "tableKey"=>"' . $tableKey . '",
                    "columns"=>array(
                        ' . $columns . '
                    ),
                );
            ?>';

	$uploadfileArray = explode(".", $uploadfile);
	$uploadfileArray[sizeof($uploadfileArray) - 1] = "php";
	$uploadfileNew = implode(".", $uploadfileArray);

	$fileForWrite = fopen($uploadfileNew, "w+");
	fwrite($fileForWrite, $arrayToFile);
	fclose($fileForWrite);
    }

    /*
     * checking file with earlier imports
     *
     * $uploadfile - path to import file
     * @return array Old params from file
     *
     */

    public function checkOldFile($uploadfile) {
		$selectfileArray = explode(".", $uploadfile);
		$selectfileArray[sizeof($selectfileArray) - 1] = "php";
		$selectfileNew = implode(".", $selectfileArray);
	
		if (file_exists($selectfileNew)) {
			require_once($selectfileNew);
			$paramsArray['delimiter'] = stripslashes($paramsArray['delimiter']);
			$paramsArray['textDelimiter'] = stripslashes($paramsArray['textDelimiter']);
		} else {
			$paramsArray['delimiter'] 		= Yii::app()->controller->module->delimiter;
			$paramsArray['textDelimiter'] 	= Yii::app()->controller->module->textDelimiter;
			$paramsArray['table'] 			= "";
			$paramsArray['mode'] 			= "";
			$paramsArray['perRequest'] 		= Yii::app()->controller->module->perRequest;
			$paramsArray['csvKey'] 			= "";
			$paramsArray['tableKey'] 		= "";
			$paramsArray['columns'] 		= array();
		}
	
		return $paramsArray;
    }
	public function actionUsers()
	{
		$this->render('users');
	}
	
	public function removefile($uploadfile){
		if(file_exists($uploadfile)){
			$dir	=	dirname( $uploadfile );			
			unlink( $uploadfile );
			if( is_dir($dir) )
				rmdir( $dir );
		}
	}
}
