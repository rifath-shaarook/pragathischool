<?php

class CenterStController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new StCenter;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StCenter']))
		{
			$model->attributes=$_POST['StCenter'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionAjaxcreate()
	{
		$model=new StCenter;
		if(isset($_POST['ajax']))
		{
		if(isset($_POST['StCenter']['group_id']))
		{
				$subnames	= $_POST['StCenter']['group_id'];
				$valid		= true;
				foreach($subnames as $subname)
				{
					if($subname!=NULL){
						$model=new StCenter;
						$model->center_id   	= $_POST['StCenter']['center_id'];
						$model->group_id	= $subname;
						$valid	= $valid && $model->validate();
					}
				}			
				if($valid)
				{
					foreach($subnames as $subname){
						if($subname!=NULL){
							$model=new StCenter;
							$model->center_id   = $_POST['StCenter']['center_id'];
							$model->group_id = $subname;
							$model->save();
						}
					}
					echo json_encode(array('status'=>'success', 'message'=>'Group Assigned'));
					Yii::app()->end();
				}
				else{
					echo json_encode(array('status'=>'error', 'message'=>'Select Group(s)'));
					Yii::app()->end();
				}
					
			
		}
		else{
				echo json_encode(array('status'=>'error', 'errors'=>array('StCenter_group_id'=>'Select Group(s)')));
				Yii::app()->end();
			}
		}
		$this->renderPartial('_form',array(
			'model'=>$model,
			false,
			true
		));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StCenter']))
		{
			$model->attributes=$_POST['StCenter'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
			
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			else
				echo json_encode(array('status'=>'success'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		$datas	= StCenter::model()->findAllByAttributes(array('center_id'=>$id));
		$this->render('index',array(
			'datas'=>$datas,
			'id' =>$id,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StCenter('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StCenter']))
			$model->attributes=$_GET['StCenter'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=StCenter::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='st-center-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}