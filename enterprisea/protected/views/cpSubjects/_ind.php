<div id="subject-<?php echo $data->id;?>" class="btn-group mr5 ind-subject">
    <button class="btn btn-default" type="button"><?php echo $data->name;?></button>   
    <a data-modal-label="Edit CP subject `<?php echo $data->name;?> - <?php echo $data->cprovidername;?>`" data-toggle="modal" data-target="#myModal" data-ajax-url="<?php echo Yii::app()->createUrl('cpSubjects/ajaxupdate', array('id'=>$data->id, 'stype'=>$_GET['stype'], 'category'=>$_GET['category']));?>" class="btn btn-default dropdown-toggle open_popup" href="javascript:void(0);"><span class="fa fa-pencil"></span></a>
    <a class="btn btn-default dropdown-toggle remove-button" data-target="#cpsubjects-<?php echo $data->cp_id;?>" href="<?php echo Yii::app()->createUrl('cpSubjects/delete', array('id'=>$data->id, 'ajax'=>'remove-sub', 'stype'=>$_GET['stype'], 'category'=>$_GET['category']));?>"> <span class="fa fa-trash-o"></span></a>
</div>