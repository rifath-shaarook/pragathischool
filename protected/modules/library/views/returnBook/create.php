<?php
$this->breadcrumbs=array(
	'Return Books'=>array('/library'),
	'Create',
);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">

 <?php $this->renderPartial('/settings/library_left');?>
 </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<h1><?php echo Yii::t('library','Return Book'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'bookid'=>$_POST['BookID'])); ?>
</div>
</td>
</tr>
</table>
