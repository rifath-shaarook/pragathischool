<?php

class PrivateTutorLocationController extends Controller
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
			'accessControl', // perform access control for CRUD operations
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
		$model = PrivateTutorLocation::model()->findByAttributes(array('center_id'=>$id));
		if(!$model)
			$this->redirect(array('create','id'=>$id));
		$this->render('view',array(
			'model'=>$model,
			'id'=>$id,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PrivateTutorLocation;

		if(isset($_POST['PrivateTutorLocation']))
		{
			$model->attributes=$_POST['PrivateTutorLocation'];
			//$model->internet_type =$_POST['PrivateTutorLocation']['internet_type'];
			if($model->internet_type!=='')
                $model->internet_type=implode(',',$model->internet_type);//converting to string...
			if($model->internet_speed!=='')
                $model->internet_speed=implode(',',$model->internet_speed);//converting to string...
			if($model->is_multifunction ==0)
				$model->multifunction = NULL;
			
			if($model->save())
				$this->redirect(array('privateTutorUploads/create','id'=>$model->center_id));
		}
		if($model->internet_type)
		$model->internet_type=explode(',',$model->internet_type);//converting to array...
		if($model->internet_speed)
		$model->internet_speed=explode(',',$model->internet_speed);//converting to array...
		
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=PrivateTutorLocation::model()->findByAttributes(array('center_id'=>$id));
		if($model == NULL)
			$model=new PrivateTutorLocation;
		if(isset($_POST['PrivateTutorLocation']))
		{
			$model->attributes=$_POST['PrivateTutorLocation'];
			
			if($model->internet_type!=='')
                $model->internet_type=implode(',',$model->internet_type);//converting to string...
			if($model->internet_speed!=='')
                $model->internet_speed=implode(',',$model->internet_speed);//converting to string...
			if($model->is_multifunction ==0)
				$model->multifunction = NULL;
			
			if($model->save())
				$this->redirect(array('privateTutor/view','id'=>$model->center_id));
		}
		
		$model->internet_type=explode(',',$model->internet_type);//converting to array...
		$model->internet_speed=explode(',',$model->internet_speed);//converting to array...
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

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PrivateTutorLocation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PrivateTutorLocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PrivateTutorLocation']))
			$model->attributes=$_GET['PrivateTutorLocation'];

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
		$model=PrivateTutorLocation::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='center-location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
