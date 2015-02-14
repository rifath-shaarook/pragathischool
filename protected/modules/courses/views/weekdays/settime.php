<?php
$this->breadcrumbs=array(
	Yii::t('weekdays','Weekdays')=>array('index'),
	Yii::t('weekdays','Manage'),
);
?>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('weekdays','Create Job'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
				?>
                
<?php echo $form->dropDownList($model,'item_type_id', CHtml::listData(ItemType::model()->findAll(), 'id', 'type'), array('empty'=>'select Type')); ?>
				
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>