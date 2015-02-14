<div>
	<?php 
	/*If $flag = 1, list of batches will be displayed. 
	 *If $flag = 2, exam schedule page will be displayed.
	 *If $flag = 3, exam result page will be displayed.
	 *If $flag = 0, Employee not teaching in any batch. A message will be displayed.
	*/
    if($_REQUEST['id']!=NULL){
			
	 }
	else{
		// Get batch ID from Batches
		$batches_id=Batches::model()->findAll("employee_id=:x AND is_active=:y AND is_deleted=:z", array(':x'=>$employee_id,':y'=>1,':z'=>0));
		if(count($batches_id) >= 1){ // List of batches is needed
			$flag = 1;
		}
		elseif(count($batches_id) <= 0){ // If not teaching in any batch
			$flag = 0;
			
		}
	}
	
	
	if($flag == 0){ // Displaying message
	?>
    <div class="yellow_bx" style="background-image:none;width:90%;padding-bottom:45px;margin-top:60px;">
        <div class="y_bx_head">
            <?php echo Yii::t('examination','No period is assigned to you now!'); ?>
        </div>      
    </div>
    <?php
	}
	if($flag == 1){ // Displaying batches the employee is assigned.
	?>
    	<div class="pdtab_Con">
            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="pdtab-h">
                        <td align="center"><?php echo Yii::t('Courses','Batch Name');?></td>
                        <td align="center"><?php echo Yii::t('Courses','Class Teacher');?></td>
                        <td align="center"><?php echo Yii::t('Courses','Actions');?></td>
                    </tr>
                    <?php 
					foreach($batches_id as $batch_id)
					{

						echo '<tr id="batchrow'.$batch_id->id.'">'; 
						echo '<td style="text-align:center; padding-left:10px; font-weight:bold;">'.$batch_id->coursename.'</td>';
						$teacher = Employees::model()->findByAttributes(array('id'=>$batch_id->employee_id));					
						echo '<td align="center">';
						if($teacher){
							echo $teacher->first_name.' '.$teacher->last_name;
						}
						else{
							echo '-';
						}
						// Count if any exam timetables are published in a batch.
						$exams_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch_id->id,'is_published'=>1));
						// Count if any exam results are published in a batch.
						$result_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch_id->id,'result_published'=>1));
						echo '<td align="center">';
						if($exams_published > 0 or $result_published > 0){
							echo CHtml::link(Yii::t('examination','View Examinations'), array('/teachersportal/default/classexam','bid'=>$batch_id->id));
						}
						else{
							echo Yii::t('examination','No Exam Scheduled');
						}
						echo '</td>';
						
						echo '</tr>';
					}
					?>
                </tbody>
            </table>
		</div>
	<?php
	}
	?>
</div>