<?php
$this->breadcrumbs=array(
	'Mess Manages'=>array('/hostel'),
	'Mess Change',
);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>false,
)); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <?php $this->renderPartial('/settings/hostel_left');?>
 </td>
    <td valign="top"> 
    <div class="cont_right">
    <h1><?php echo Yii::t('hostel','Mess Manage');?></h1>
    <div class="formCon" >
<div class="formConInner"> 
<?php echo $student_id= $_REQUEST['id']; exit;
$stud=Students::model()->findByAttributes(array('id'=>$_REQUEST['id'])); 
$name=$stud->last_name.' '.$stud->first_name;
$new=FoodInfo::model()->findByAttributes(array('student_id'=>$_REQUEST['id']));
$fid=$new->id; echo 'oooo'.$fid;
exit;
?>
<table width="30%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="100%">  

     <td width="3%"><?php echo '<td><strong>'.CHtml::label(Yii::t('hostel','Name')).'</strong></td><td>'; ?></td>
    <td>&nbsp;</td>
    <td ><input type="text" name="name" value="<?php echo $name;?>" readonly="readonly"></td>
    <td><input type="text" name="id" value="<?php echo $student_id;?>" hidden="hidden"></td>
    </tr>
    <tr>
      <td width="100%">  
    <td width="3%">
<?php  
echo '<td><strong>'.CHtml::label(Yii::t('hostel','Food Preference')).'</strong></td><td>';?></td>
<td>&nbsp;</td>
<td><?php echo CHtml::dropDownList('food_preference','',CHtml::listData(FoodInfo::model()->findAll(),'id','food_preference'),array('prompt'=>'Select','id'=>'food_preference')).'</td>';	

?>
  </tr>
  <tr>
  <td>
  </td></tr>
</table>
</div>
<div style="padding-left:20px">
	<?php echo CHtml::button('Save', array('submit' => array('Registration/Messchange','id'=>$fid),'class'=>'formbut')); ?>
	</div></div>
</div>
</td>
</tr>
</table>
<?php $this->endWidget(); ?>
