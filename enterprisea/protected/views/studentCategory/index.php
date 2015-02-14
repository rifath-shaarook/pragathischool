<?php
$this->breadcrumbs=array(
	'Student Categories',
);
?>
<style>
.saving{
	background:url('<?php echo Yii::app()->request->baseUrl;?>/images/saving.gif') no-repeat right center;
	border:none;
}
</style>
<div class="pageheader">
	<h2><i class="glyphicon glyphicon-bookmark"></i> Student Categories<!--<span>Subtitle goes here...</span>--></h2>
    <!--<div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
            <li><a href="index.html">Bracket</a></li>
            <li class="active">Tables</li>
        </ol>
    </div>-->
</div>

<div class="contentpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-btns">
                    	<a class="minimize" href="#">−</a>
                    </div>
                	<h3 class="panel-title">Manage Student Category</h3>
                	
                   
                </div>
                
                <div class="panel-body">
                     <div class="col-lg-12">
                     <div class="btn-demo pull-right">
                      <button data-toggle="modal" data-target="#myModal" type="button" data-ajax-url="<?php echo Yii::app()->createUrl('studentCategory/ajaxcreate');?>" class="btn btn-primary open_popup">Add Category</button>
                     
                    </div>
                    </div>
                    </div>
                    
                    </div>
                    <div class="panel panel-default">
                <div class="panel-body" id="datas-body">
                    <?php echo $this->renderPartial('_categories', array('list'=>$list,
								'pages' => $pages,
								'item_count'=>$item_count,
								'page_size'=>$page_size))?>
                </div><!-- panel-body -->
            </div>
        <!-- table-responsive -->
        </div><!-- col-md-12 -->
    </div>
</div>
<script>


$('.edit-icon').click(function(e) {
    $(this).closest('tr').find('span.name_txt').dblclick();
});
$('.remove-icon').click(function(e) {
	if(confirm('Are you sure ?')){
		var that	= this;	
		var url		= $(that).attr('href');
		$.ajax({
			'url':url,
			type:'POST',
			success:function(){			
				$(that).closest('tr').remove();
				reorder_items();
			}
		});
	}
	return false;
});

open_popup_links();
</script>