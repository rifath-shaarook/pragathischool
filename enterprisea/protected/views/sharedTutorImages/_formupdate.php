<script>
	function removeFile() 
	{	
		if(document.getElementById("new_file").style.display == "none")
		{
			document.getElementById("existing_file").style.display = "none";
			document.getElementById("new_file").style.display = "block";
			document.getElementById("new_file_field").value = "1";
		}
		
		return false;
	}
</script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'center-document-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'action'=>CController::createUrl('sharedTutorImages/update',array('document_id'=>$model->id))
)); ?>
<div class="panel panel-default">
	<div class="panel-heading" style="position:relative;">
    	
        <div class="col-sm-8"><h3 class="panel-title">Image Name</h3></div>
        <div class="col-sm-4">
        	 <?php echo CHtml::link('Images List', array('sharedTutorImages/create', 'id'=>$center_id),array('class'=>' btn btn-success pull-right')); ?>
        </div>
        <div class="clearfix "></div>
        	
            
  </div>
<div class="panel-body">


	<?php 
		if($form->errorSummary($model)){
	?>
        <div class="errorSummary"><?php echo 'Input Error'; ?><br />
        	<span><?php echo 'Please fix the following error(s).'; ?></span>
        </div>
    <?php 
		}
		//var_dump($model->attributes);exit;
	?>
    
  	<p class="note" style="float:left"><?php echo 'Fields with'; ?> <span class="required">*</span> <?php echo 'are required.'; ?></p>
    
    
    <?php
	Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$(".error").animate({opacity: 1.0}, 3000).fadeOut("slow");',
	   CClientScript::POS_READY
	);
	if(Yii::app()->user->hasFlash('errorMessage')): 
	?>
        <div class="error1" style="color:#C00; padding-left:200px; ">
            <?php echo Yii::app()->user->getFlash('errorMessage'); ?>
        </div>
	<?php
	endif;
	?>

    <div class="formCon" style="clear:left;">
        <div class="formConInner" id="innerDiv">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="documentTable">
            	<tr>
                	<td width="40%"><?php echo $form->labelEx($model,'Image Name'); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;<?php //echo $form->labelEx($model,Yii::t('students','file')); ?></td>
                </tr>
               
                <tr>
                	<td>
                    <div  ></a></div>
						<?php echo $form->textField($model,'title',array('size'=>25,'maxlength'=>225,'class'=>'form-control')); ?>
                         <?php echo $form->error($model,'title'); ?>
                    </td>
                    <td id="existing_file">
                    	<?php 
						if($model->file!=NULL and $model->file_type!=NULL)
						{
						?>
                        <div class="btn-demo" style="margin:10px 10px 5px;">
                        	 <?php echo CHtml::link('<span>'.Yii::t('students','View').'</span>', array('sharedTutorImages/download','id'=>$model->id,'center_id'=>$model->center_id),array('class'=>'btn btn-primary')); ?>
                             
                             
                             <?php echo CHtml::link('<span>'.Yii::t('students','Remove').'</span>', array('#'),array('class'=>'btn btn-danger','onclick'=>'return removeFile();')); ?>
                             
                        </div>
                        
                                                <?php
						}
						?>
                    </td>
                    <td id="new_file" style="display:none; padding-left:20px;">
						<?php echo $form->fileField($model,'file'); ?>
                        <?php echo $form->error($model,'file'); ?>
                        <?php echo $form->hiddenField($model,'new_file_field',array('value'=>0,'id'=>'new_file_field')); ?>
                    </td>
                </tr>
            </table>
			
            <div class="row" id="student_id">
                <?php echo $form->hiddenField($model,'center_id',array('value'=>$model->center_id)); ?>
                <?php echo $form->error($model,'center_id'); ?>
            </div>
        
            <div class="row" id="file_type">
                <?php //echo $form->labelEx($model,'file_type'); ?>
                <?php echo $form->hiddenField($model,'file_type'); ?>
                <?php echo $form->error($model,'file_type'); ?>
            </div>
        
            <div class="row" id="created_at">
                <?php //echo $form->labelEx($model,'created_at'); ?>
                <?php echo $form->hiddenField($model,'created_at'); ?>
                <?php echo $form->error($model,'created_at'); ?>
            </div>
        </div>
    </div>
    



</div>
<div class="panel-footer">
             
             
        <?php //echo CHtml::button('Add Another', array('class'=>'formbut','id'=>'addAnother','onclick'=>'addRow("documentTable");')); ?>
        <?php echo CHtml::submitButton('Update',array('class'=>'btn btn-orange')); ?>
              
                          </div><!-- form --><?php $this->endWidget(); ?>