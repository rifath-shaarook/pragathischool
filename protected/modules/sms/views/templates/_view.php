<div class="temp_view">
<div class="temp_div">
	<div class="temp_image"></div>
    <h2><strong><?php echo CHtml::link(CHtml::encode(($data->name)?$data->name:'No name'), array('view', 'id'=>$data->id)); ?></strong></h2>
    <div style=" margin: 2px 0 0 8px;
    position: absolute;
    right: 0;
    top: -4px;">			
        <?php echo CHtml::link(Yii::t('os_sms_module',''), array('update', 'id'=>$data->id),array('class'=>'temp_edit'));?>
        <?php echo CHtml::link(Yii::t('os_sms_module',''), array('delete', 'id'=>$data->id),array('class'=>'temp_dlt', 'confirm'=>'Are you sure ?'));?>
    </div>
    <div style="margin-top:-5px; text-align:justify ; color: #898989 !important;
    ">    
    
    <p><?php echo CHtml::encode($data->template); ?></p>
    

</div>
<div class="created_box">

<div class="created_box_r"><b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?></div>
</div>

<div class="clear"></div>

</div>
</div>