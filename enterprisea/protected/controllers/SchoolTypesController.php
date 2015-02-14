<?php

class SchoolTypesController extends RController
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
				'actions'=>array('admin','delete','ajaxcreate','ajaxupdate'),
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
		$model=new SchoolTypes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$model->status	= 1;

		if(isset($_POST['SchoolTypes']))
		{
			$model->attributes=$_POST['SchoolTypes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionAjaxcreate()
	{
		$model=new SchoolTypes;
		$model->status	= 1;
		if(isset($_POST['SchoolTypes']))
		{
			$model->attributes=$_POST['SchoolTypes'];
			if($model->validate()){
				if($model->save()){
					if(isset($_GET['controller']) and $_GET['controller']=="courseManager"){
						$data	= CHtml::tag('option', array('value'=>$model->id), CHtml::encode($model->type), true);
						echo json_encode(array('status'=>'success', 'message'=>'School Type Added','data'=>$data));
					}
					else{
						echo json_encode(array('status'=>'success', 'message'=>'School Type Added'));
					}
					Yii::app()->end();
				}
			}
			else{
				// Uncomment the following line if AJAX validation is needed
				$this->performAjaxValidation($model);
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

		if(isset($_POST['SchoolTypes']))
		{
			$model->attributes=$_POST['SchoolTypes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjaxUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['SchoolTypes']))
		{
			$model->attributes=$_POST['SchoolTypes'];
			if($model->validate()){
				if($model->save()){
					echo json_encode(array('status'=>'success', 'message'=>'School type updated'));
					Yii::app()->end();
				}
			}
			else{
				// Uncomment the following line if AJAX validation is needed
				$this->performAjaxValidation($model);
			}
		}
		
		$this->renderPartial('_form',array(
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
			
			//find categories and remove
			$categories	= CourseCategory::model()->findAllByAttributes(array('school_type'=>$id));
			foreach($categories as $category){			
				//find courses and remove
				$courses	= Course::model()->findAllByAttributes(array('category'=>$category->id));
				foreach($courses as $course){
					//find cps and remove
					$cps	= CurriculumProviders::model()->findAllByAttributes(array('course_id'=>$course->id));
					foreach($cps as $cp){			
						//find subjects of cp and remove
						CpSubjects::model()->deleteAllByAttributes(array('cp_id'=>$cp->id));
						$cp->delete();
					}
					$course->delete();
				}
				$category->delete();
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
	public function actionIndex()
	{
		$datas	= SchoolTypes::model()->findAll();
		$this->render('index',array(
			'datas'=>$datas,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SchoolTypes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SchoolTypes']))
			$model->attributes=$_GET['SchoolTypes'];

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
		$model=SchoolTypes::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='school-types-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}