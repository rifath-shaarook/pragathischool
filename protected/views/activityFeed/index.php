
<?php
$this->breadcrumbs=array(
	'Activity Feed',
);?>
<?php /*?><h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p><?php */?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php //$this->renderPartial('//configurations/left_side');
			$this->renderPartial('mailbox.views.default.left_side');
			//$this->renderPartial('left_side');
			 ?>
        </td>
        <td valign="top">
        
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('activity','Activity Feed');?></h1>
              
                <!-- Activity Feed Search -->
                <div class="formCon" style="border:none;">
                	
     				<div class="feedConinner">
                    	<?php 
						$form=$this->beginWidget('CActiveForm', array(
							'id'=>'activity-feed-form',
							'action'=>Yii::app()->createUrl('activityFeed/index'),
							'method'=>'GET',
							'enableAjaxValidation'=>false,
						)); 
						?>
                            <table>
                                <tr>
                                     <td>&nbsp;</td>
                                     <td style="width:60px; font-size:12px;"><strong><?php echo Yii::t('Activity','Feed Type');?></strong></td>
                                     <td>&nbsp;</td>
                                     <td>
                                        <?php
                                        $criteria  = new CDbCriteria;
                                        $criteria->order='name ASC';
                                        $feed_type = ActivityType::model()->findAll($criteria);
                                        $feed_type_list = CHtml::listData($feed_type,'id','name');
										if($type)
										{
                                        	echo CHtml::dropDownList('activity_type','',$feed_type_list,array('prompt'=>'Select','options' => array($type=>array('selected'=>true))));
										}
										else
										{
											echo CHtml::dropDownList('activity_type','',$feed_type_list,array('prompt'=>'Select','style'=>'padding: 6px 3px'));
										}
                                        ?>
                                     </td>
                                     <td colspan="6">&nbsp;</td>
                                     
                                </tr>
                                <tr>
                                    <td colspan="10">&nbsp;</td>
                                </tr>
                                <tr>
                                     <td>&nbsp;</td>
                                     <td style="font-size:12px;"><strong><?php echo Yii::t('Activity','Start Date');?></strong></td>
                                     <td>&nbsp;</td>
                                     <td>
                                        <?php 
                                        $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                                        if($settings!=NULL)
                                        {
                                            $date=$settings->dateformat;                             
                                        }
                                        else
                                        {
                                            $date = 'dd-mm-yy';		
                                        }
                                       $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                        'name'=>'start_date',
										'value'=>$start_date,    
                                        'options'=>array(        
                                            'showAnim'=>'fold',
                                            'dateFormat'=>$date,
                                            'changeMonth'=> true,
                                            'changeYear'=>true,
                                            'yearRange'=>'2000:'.(date('Y')),
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'height:30px;'
                                        ),
                                    ));
                                        ?>
                                     </td>
                                     <td>&nbsp;</td>
                                     <td style="width:50px;font-size:12px;"><strong><?php echo Yii::t('Activity','End Date');?></strong></td>
                                     <td>&nbsp;</td>
                                     <td>
                                        <?php 
                                       $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                        'name'=>'end_date',
										'value'=>$end_date,        
                                        'options'=>array(        
                                            'showAnim'=>'fold',
                                            'dateFormat'=>$date,
                                            'changeMonth'=> true,
                                            'changeYear'=>true,
                                            'yearRange'=>'2000:'.(date('Y')),
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'height:30px;'
                                        ),
                                    ));
                                        ?>
                                     </td>
                                     <td style="width:30px;">&nbsp;</td>
                                     <td>
                                     	<?php echo CHtml::submitButton('Find',array('name'=>'find','class'=>'formbut')); ?>
                                     </td>
                                </tr>
                            </table>
                        <?php $this->endWidget(); ?>
                    </div>
				</div>
                <!-- END Activity Feed Search -->
                
                
                
                <div class="a_feed_cntnr" >
               <!-- <div class="a_feed_seprtr"><h1>9 Sep 2013</h1></div>-->
                	<div class="a_feed_bx" id="feed_content_box">
                    	
                    
						<?php
							
							//$feeds = ActivityFeed::model()->findAll($criteria); // Get all feeds
							$count = 0;
							if($feeds!=NULL)
							{
								foreach($feeds as $feed)
								{
								?>
                                	<div class="individual_feed">
                                <?php
									
									
									$initiator = Profile::model()->findByAttributes(array('user_id'=>$feed->initiator_id));
									
									// Generate appropriate url and id
									$roles=Rights::getAssignedRoles($initiator->user_id); // check for single role
									foreach($roles as $role)
									if(sizeof($roles)==1 and $role->name == 'Admin')
									{
										$url = "user/admin/view";	
										$id = $feed->initiator_id;
									}
									if(sizeof($roles)==1 and $role->name == 'parent')
									{
										$url = "students/guardians/view";
										$guardian = Guardians::model()->findByAttributes(array('uid'=>$feed->initiator_id));
										$id = $guardian->id;
									}
									if(sizeof($roles)==1 and $role->name == 'student')
									{
										$url = "/students/students/view";
										$student = Students::model()->findByAttributes(array('uid'=>$feed->initiator_id));
										$id = $student->id;
									}
									if(sizeof($roles)==1 and $role->name == 'teacher')
									{
										$url = "employees/employees/view";
										$teacher = Employees::model()->findByAttributes(array('uid'=>$feed->initiator_id));
										$id = $teacher->id;
									} 
									// End Generate appropriate url and id
									
									$feed_type = ActivityType::model()->findByAttributes(array('id'=>$feed->activity_type));
									
									// Determine the css class
									if($feed->activity_type==1)
									{
										$activity_class = "a_feed_login";
									}
									elseif($feed->activity_type==2)
									{
										$activity_class = "a_feed_logout";
									}
									elseif(in_array($feed->activity_type,array(3,8,11,17,20,23)))
									{
										$activity_class = "a_feed_create";
									}
									elseif(in_array($feed->activity_type,array(4,9,12,18,21,24,27)))
									{
										$activity_class = "a_feed_edit";
									}
									elseif(in_array($feed->activity_type,array(5,10,13,19,22,25)))
									{
										$activity_class = "a_feed_delet";
									}
									else
									{
										$activity_class = "a_feed_create";
									}
									
									// END determine the css class 
									
									
									$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
									
									if($settings!=NULL)
									{	
										$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
										/*$time = new DateTime("@".strtotime($feed->activity_time));
										$time->setTimezone(new DateTimeZone($timezone->timezone));   */
										date_default_timezone_set($timezone->timezone);
										$date = date($settings->displaydate,strtotime($feed->activity_time));	
										$time = date($settings->timeformat,strtotime($feed->activity_time));						
									}
									//$separator_date = '';
									
									if(Yii::app()->session['date']!= $date)
									{								
										Yii::app()->session['date']	= $date;
									?>
                            		<div class="a_feed_seprtr">
                                    	<h1><?php echo $date; ?></h1>
                                    </div>
                                    <?php 
									}
									/*$count++;
									echo $count.'--';
									echo $pages->getCurrentPage().' '.$separator_date;
									echo $pages->getCurrentPage().'-'.$pages->getPageCount().'---'.count($feeds);*/
									
									?>
                            		<!-- Individual Feed -->
									<div class="a_feed_innerbx">
										<div class="<?php echo $activity_class; ?>"></div>
										<div class="a_feed_innercntnt">
											<div class="a_feed_inner_arrow"></div>
											<h1>
												<strong>
													<?php echo CHtml::link(ucfirst($initiator->firstname).' '.ucfirst($initiator->lastname),array($url,'id'=>$id)); ?>
												</strong>
                                                <?php 
													$update_array = array(4,9,12,15,18,21,24,27);
													if(in_array($feed->activity_type,$update_array))
													{
														if($feed->initial_field_value=='' and $feed->new_field_value!='')
														{
															echo ' added the <strong>'.$feed->field_name.'</strong>';
														}
														elseif($feed->new_field_value!='' and $feed->new_field_value!='')
														{
															echo ' changed the <strong>'.$feed->field_name.'</strong>';
														}
														elseif($feed->initial_field_value!='' and $feed->new_field_value=='')
														{
															echo ' removed the <strong>'.$feed->field_name.'</strong>';
														}
													}
													echo ' '.$feed_type->text;
												?> 
												<strong>
													<?php 
													if($feed->activity_type!=1 and $feed->activity_type!=2)
													{
														//Student Activities
														if($feed->activity_type >= 3 and $feed->activity_type <= 10) 
														{
															
															$goal = Students::model()->findByAttributes(array('id'=>$feed->goal_id));
															
															if($goal!=NULL and $goal->is_deleted!=1)
															{
																echo CHtml::link(ucfirst($goal->first_name).' '.ucfirst($goal->middle_name).' '.ucfirst($goal->last_name),array('/students/students/view','id'=>$goal->id));
															}
															else
															{
																echo $feed->goal_name;
															}
															
														}
														// End Student Activities
														
														// Guardian Activities
														elseif($feed->activity_type >= 14 and $feed->activity_type <= 16)
														{
															$goal = Guardians::model()->findByAttributes(array('id'=>$feed->goal_id));
															if($goal!=NULL)
															{
																echo CHtml::link($feed->goal_name,array('/students/guardians/view','id'=>$goal->id));
															}
															else
															{
																echo $feed->goal_name;
															}
															
														}
														// End Guardian Activities
														
														// Exam Group Activities
														elseif($feed->activity_type >= 11 and $feed->activity_type <= 13) 
														{
															if($feed->goal_name == $feed->new_field_value)
															{
																$feed->goal_name = $feed->initial_field_value;
															}
															$goal = ExamGroups::model()->findByAttributes(array('id'=>$feed->goal_id));
															if($goal!=NULL)
															{
																
																echo CHtml::link(ucfirst($feed->goal_name),array('examination/exams/create','exam_group_id'=>$goal->id,'id'=>$goal->batch_id));
															}
															else
															{
																echo $feed->goal_name;
															}
														}
														// End Exam Group Activities
														
														// Exam ( Exam Subject) Activities 
														elseif($feed->activity_type >= 17 and $feed->activity_type <= 19)
														{
															$goal = Exams::model()->findByAttributes(array('id'=>$feed->goal_id));
															if($goal!=NULL)
															{
																
																echo CHtml::link(ucfirst($feed->goal_name),array('examination/exams/update','sid'=>$goal->id,'exam_group_id'=>$goal->exam_group_id,'id'=>$examgroup->batch_id));
																//echo $feed->goal_name;
															}
															else
															{
																echo $feed->goal_name;
															}
														}
														// End Exam ( Exam Subject) Acivities 
														
														// Exam score Activities
														elseif($feed->activity_type >= 20 and $feed->activity_type <= 22)
														{
															$goal = ExamScores::model()->findByAttributes(array('id'=>$feed->goal_id));	
															if($goal!=NULL)
															{
																$exam = Exams::model()->findByAttributes(array('id'=>$goal->exam_id));
																$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
																echo CHtml::link(ucfirst($feed->goal_name),array('examination/examScores/update','sid'=>$goal->id,'examid'=>$goal->exam_id,'id'=>$examgroup->batch_id));
															}
															else
															{
																echo $feed->goal_name;
															}
														}
														// End Exam score Activities
														
														// Employee Activities
														elseif($feed->activity_type >= 23 and $feed->activity_type <= 28)
														{
															$goal = Employees::model()->findByAttributes(array('id'=>$feed->goal_id));
															if($goal!=NULL and $goal->is_deleted!=1)
															{
																echo CHtml::link($feed->goal_name,array('employees/employees/view','id'=>$goal->id));	
															}
															else
															{
																echo $feed->goal_name;
															}
														}
														// End Employee Activities
													}
													?>
												</strong>
                                                <?php 
												
												// Update values
                                                if(in_array($feed->activity_type,$update_array))
												{
													if($feed->initial_field_value=='' and $feed->new_field_value!='' and $feed->activity_type!=9  and $feed->activity_type!=27)
													{
														echo ' as <strong>'.$feed->new_field_value.'</strong>';
													}
													elseif($feed->initial_field_value!='' and $feed->new_field_value!='' and $feed->activity_type!=9 and $feed->activity_type!=27)
													{
														if($feed->goal_name == $feed->initial_field_value)
														{
															echo ' to <strong>'.$feed->new_field_value.'</strong>';
														}
														else
														{
															echo ' from <strong>'.$feed->initial_field_value.'</strong> to <strong>'.$feed->new_field_value.'</strong>';
														}
													}
													/*elseif($feed->initial_field_value!='' and $feed->new_field_value=='')
													{
														echo ', <strong>'.$feed->initial_field_value.'</strong>';
													}*/
													
												}
												// End update values
												
												// Attendance
												if(in_array($feed->activity_type,array(8,10,26,28)))
												{
													echo ' for the day <strong>'.$feed->field_name.'</strong>';
												}
												if(in_array($feed->activity_type,array(9,27)))
												{
													echo ' on <strong>'.$feed->initial_field_value.'</strong> as <strong>'.$feed->new_field_value.'</strong>';
												}
												
												
												// End attendance
												?>
											</h1>
                                           
											<p>at <strong><?php echo $time;//$time->format($settings->timeformat); ?></strong>  - <strong> <?php echo $date; ?></strong>.</p>
										</div> <!-- END div class="a_feed_innercntnt" -->
									</div>
                                    <!-- END Individual Feed -->
                               </div>
							<?php
								
								} // END foreach
								
							?>
                            
                            <?php
							} // END $feed!=NULL
							else
							{
							?>
                                <div>
                                    <div class="a_feed_innercntnt" style="width:600px;">
                                        <div></div>
                                        <h1><strong><?php echo Yii::t('activity','The activity feed is empty.');?></strong></h1>
                                    </div>
                                </div>
								
							<?php
							}
                        ?>
					</div> <!-- END div class="a_feed_bx" -->
				</div> <!-- END div class="a_feed_cntnr" --> 
				<?php
					$this->widget('application.extensions.yiinfinite-scroll.YiinfiniteScroller', array(
						'contentSelector' => '#feed_content_box',
						'itemSelector' => 'div.individual_feed',
						//'navigationLinkText' => false,
						'loadingText' => 'Loading...',
						'donetext' => 'No more feeds to show..!',
						'pages' => $pages,
					));
					if(($pages->getCurrentPage() == ($pages->getPageCount()-1)) and ($count == count($feeds)))
					{
						Yii::app()->session->remove('date');
					}
					
				?>
                        
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table>
