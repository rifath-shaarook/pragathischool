<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
);
?>
<?php
$currdate = date('d-m-Y');

	$one =date("m"); 
	$one_1=date("M");
	
	$two =date("m d y", strtotime("-1 months", strtotime($currdate))); 
	$two_1 =date("M", strtotime("-1 months", strtotime($currdate))); 
	
	$three =date("m", strtotime("-2 months", strtotime($currdate))); 
	$three_1=date("M", strtotime("-2 months", strtotime($currdate))); 
	
	$four =date("m", strtotime("-3 months", strtotime($currdate))); 
	$four_1 =date("M", strtotime("-3 months", strtotime($currdate))); 
	
	$five =date("m", strtotime("-4 months", strtotime($currdate))); 
	$five_1 =date("M", strtotime("-4 months", strtotime($currdate))); 
	
	$six =date("m", strtotime("-5 months", strtotime($currdate))); 
	$six_1 =date("M", strtotime("-5 months", strtotime($currdate))); 
	
	$seven =date("m", strtotime("-6 months", strtotime($currdate))); 
	$seven_1 =date("M", strtotime("-6 months", strtotime($currdate))); 
	
	$eight =date("m", strtotime("-7 months", strtotime($currdate))); 
	$eight_1 =date("M", strtotime("-7 months", strtotime($currdate))); 
	
	$nine =date("m", strtotime("-8 months", strtotime($currdate))); 
	$nine_1 =date("M", strtotime("-8 months", strtotime($currdate))); 
	
	$ten =date("m", strtotime("-9 months", strtotime($currdate))); 
	$ten_1 =date("M", strtotime("-9 months", strtotime($currdate))); 
	
	$eleven =date("m", strtotime("-10 months", strtotime($currdate))); 
	$eleven_1 =date("M", strtotime("-10 months", strtotime($currdate))); 
	
	$twelve =date("m", strtotime("-11 months", strtotime($currdate))); 
	$twelve_1 =date("M", strtotime("-11 months", strtotime($currdate))); 
	
	 $data_1 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$one,':status'=>'0'));	
	 $data_2 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$two,':status'=>'0'));
	 $data_3 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$three,':status'=>'0'));
	 $data_4 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$four,':status'=>'0'));
	 $data_5 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$five,':status'=>'0'));
	 $data_6 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$six,':status'=>'0'));
	 $data_7 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$seven,':status'=>'0'));
	 $data_8 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$eight,':status'=>'0'));
	 $data_9 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$nine,':status'=>'0'));
	 $data_10 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$ten,':status'=>'0'));
	 $data_11 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$eleven,':status'=>'0'));
	 $data_12 = Students::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$twelve,':status'=>'0'));
   
	 $month = '["'.$one_1.'","'.$two_1.'","'.$three_1.'","'.$four_1.'","'.$five_1.'","'.$six_1.'","'.$seven_1.'","'.$eight_1.'","'.$nine_1.'","'.$ten_1.'","'.$eleven_1.'","'.$twelve_1.'",]';
	 $data = "[".count($data_1).",".count($data_2).",".count($data_3).",".count($data_4).",".count($data_5).",".count($data_6).",".count($data_7).",".count($data_8).",".count($data_9).",".count($data_10).",".count($data_11).",".count($data_12).",]";
?>
<?php
$currdate = date('d-m-Y');

	$one =date("m"); 
	$one_1=date("M");
	
	$two =date("m d y", strtotime("-1 months", strtotime($currdate))); 
	$two_1 =date("M", strtotime("-1 months", strtotime($currdate))); 
	
	$three =date("m", strtotime("-2 months", strtotime($currdate))); 
	$three_1=date("M", strtotime("-2 months", strtotime($currdate))); 
	
	$four =date("m", strtotime("-3 months", strtotime($currdate))); 
	$four_1 =date("M", strtotime("-3 months", strtotime($currdate))); 
	
	$five =date("m", strtotime("-4 months", strtotime($currdate))); 
	$five_1 =date("M", strtotime("-4 months", strtotime($currdate))); 
	
	$six =date("m", strtotime("-5 months", strtotime($currdate))); 
	$six_1 =date("M", strtotime("-5 months", strtotime($currdate))); 
	
	$seven =date("m", strtotime("-6 months", strtotime($currdate))); 
	$seven_1 =date("M", strtotime("-6 months", strtotime($currdate))); 
	
	$eight =date("m", strtotime("-7 months", strtotime($currdate))); 
	$eight_1 =date("M", strtotime("-7 months", strtotime($currdate))); 
	
	$nine =date("m", strtotime("-8 months", strtotime($currdate))); 
	$nine_1 =date("M", strtotime("-8 months", strtotime($currdate))); 
	
	$ten =date("m", strtotime("-9 months", strtotime($currdate))); 
	$ten_1 =date("M", strtotime("-9 months", strtotime($currdate))); 
	
	$eleven =date("m", strtotime("-10 months", strtotime($currdate))); 
	$eleven_1 =date("M", strtotime("-10 months", strtotime($currdate))); 
	
	$twelve =date("m", strtotime("-11 months", strtotime($currdate))); 
	$twelve_1 =date("M", strtotime("-11 months", strtotime($currdate))); 
	
	 $data_1 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$one,':status'=>'0'));	
	 $data_2 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$two,':status'=>'0'));
	 $data_3 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$three,':status'=>'0'));
	 $data_4 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$four,':status'=>'0'));
	 $data_5 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$five,':status'=>'0'));
	 $data_6 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$six,':status'=>'0'));
	 $data_7 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$seven,':status'=>'0'));
	 $data_8 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$eight,':status'=>'0'));
	 $data_9 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$nine,':status'=>'0'));
	 $data_10 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$ten,':status'=>'0'));
	 $data_11 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$eleven,':status'=>'0'));
	 $data_12 = Employees::model()->findAll('month(created_at)=:id AND is_deleted=:status',array(':id'=>$twelve,':status'=>'0'));
   
	 $month = '["'.$one_1.'","'.$two_1.'","'.$three_1.'","'.$four_1.'","'.$five_1.'","'.$six_1.'","'.$seven_1.'","'.$eight_1.'","'.$nine_1.'","'.$ten_1.'","'.$eleven_1.'","'.$twelve_1.'",]';
	 $data1 = "[".count($data_1).",".count($data_2).",".count($data_3).",".count($data_4).",".count($data_5).",".count($data_6).",".count($data_7).",".count($data_8).",".count($data_9).",".count($data_10).",".count($data_11).",".count($data_12).",]";
?>
<script type="text/javascript">
var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'column'
		},
		title: {
			text: 'Monthly Average Admissions'
		},
		subtitle: {
			/*text: 'Cource: Computer Applications'*/
		},
		xAxis: {
			categories: 
				<?php echo $month; ?>
			
		},
		yAxis: {
			min: 0,
			title: {
				text: 'No.of Admissions'
			}
		},
		credits: {
			enabled: false
		},

		legend: {
			layout: 'none',

		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y +' Admissions';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
			series: [{
			name: 'Student Admission',
			data: <?php echo $data; ?>,
			color:'#adce5c',

		},
		{
			name: 'Employee Admission',
			data: <?php echo $data1; ?>,
			color:'#fdcf05',

		}, ]
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('left_side');?>
    
    </td>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%"><div style="padding-left:20px;">
<h1>Reports Dashboard</h1>
<div class="clear"></div>
  <div style="margin-top:20px; width:80%" id="container"></div>
  <?php if($list!=NULL)
{?>
<?php
//$sub = Employees::model()->findAll("is_deleted=:x", array(':x'=>0));

$data = '';

	$empy = EmployeeDepartments::model()->findAll();
	foreach($empy as $empy_1)
	{
		$emp_number=Employees::model()->findAll("employee_department_id=:x", array(':x'=>$empy_1->id));
	$data .='{name:"'.$empy_1->name.'",
			y:'.count($emp_number).',
			sliced: true,
			selected: true,},';
	}



//echo $data;
?>
  <div class="pdtab_Con" style="width:97%">
                <div style="font-size:13px; padding:5px 0px"><strong><?php echo '<strong>'.Yii::t('report','Recent Employee Admissions').'</strong>';?></strong></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="pdtab-h">
                      <td align="center" height="18"><?php echo Yii::t('report','Date');?></td>
                      <td align="center"><?php echo Yii::t('report','Employee Name');?></td>
                      <td align="center"><?php echo Yii::t('report','Employee No:');?></td>
                      <td align="center"><?php echo Yii::t('report','Department');?></td>
                      <td align="center"><?php echo Yii::t('report','Position');?></td>
                      
                    </tr>
                  </tbody>
                  <?php foreach($list as $list_1)
	              { ?>
                    <tbody>
                    <tr>
                    <td align="center"><?php 
											$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($list_1->joining_date));
									echo $date1;
		
								}
								else
								echo $list_1->joining_date;
					 ?>&nbsp;</td>
                    <td align="center"><?php echo CHtml::link($list_1->first_name.'  '.$list_1->middle_name.'  '.$list_1->last_name,array('/employees/employees/view','id'=>$list_1->id)) ?>&nbsp;</td>
                    <td align="center"><?php echo $list_1->employee_number; ?></td>
					<?php  $dept = EmployeeDepartments::model()->findByAttributes(array('id'=>$list_1->employee_department_id)); ?>
                    <td align="center"><?php if($dept!=NULL){echo $dept->name; }else{ echo '-';}?> </td>
                    <?php  $pos = EmployeePositions::model()->findByAttributes(array('id'=>$list_1->employee_position_id)); ?>
                    <td align="center"><?php if($pos!=NULL){echo $pos->name; }else{ echo '-';}?> </td>
                    
                  </tr>
                     
               </tbody>
               <?php
               } ?>
                               
               </table>
              </div>
              <?php } 
		 if($list1!=NULL)
{
			  ?>
              <div class="pdtab_Con" style="width:97%">
	<div style="font-size:13px; padding:5px 0px">
		<strong><?php echo '<strong>'.Yii::t('report','Recent Admissions').'</strong>';?></strong>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="pdtab-h">
                      <td align="center" height="18"><?php echo Yii::t('report','Date');?></td>
                      <td align="center"><?php echo Yii::t('report','Student Name');?></td>
                      <td align="center"><?php echo Yii::t('report','Admission No.');?></td>
                      <td align="center"><?php echo Yii::t('report','Course/Batch');?></td>
                      <td align="center"><?php echo Yii::t('report','Gender');?></td>
                      
                    </tr>
                  </tbody>
                  <?php foreach($list1 as $list_2)
	              { ?>
                    <tbody>
                    <tr>
                    <td align="center"><?php 
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($list_2->admission_date));
									echo $date1;
		
								}
								else
								echo $list_2->admission_date;
								 ?>&nbsp;</td>
                    <td align="center"><?php echo CHtml::link($list_2->first_name.'  '.$list_2->middle_name.'  '.$list_2->last_name,array('/students/students/view','id'=>$list_2->id)) ?>&nbsp;</td>
                    <td align="center"><?php echo $list_2->admission_no ?></td>
                    <td align="center">
                    <?php $batc = Batches::model()->findByAttributes(array('id'=>$list_2->batch_id)); 
					  if($batc!=NULL)
					  {
						  $cours = Courses::model()->findByAttributes(array('id'=>$batc->course_id)); ?>
						  <?php echo $cours->course_name.' / '.$batc->name; ?> 
					  <?php }
					  else{?> - <?php }?>
                      </td>
                    <td align="center">
					                      <?php if($list_2->gender=='M')
										  {
											  echo Yii::t('report','Male');
										  }
										  elseif($list_2->gender=='F')
										  {
											  echo Yii::t('report','Female');
										  }?>
                    </td>
                    
                  </tr>
                     
               </tbody>
               <?php
               } ?>
                
               </table>
</div>
<?php } ?>
 	</div></td>
        
      </tr>
    </table>
    </td>
  </tr>
</table><br />
<br />
