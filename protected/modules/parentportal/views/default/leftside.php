  <div id="parent_leftSect">
       
        	<ul>
            <li>
            <?php
			if(Yii::app()->controller->module->id=='mailbox' and  Yii::app()->controller->id!='news')
			{
				echo CHtml::link(Yii::t('parentportal','Messages'),array('/mailbox'),array('class'=>'mssg_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Messages'),array('/mailbox'),array('class'=>'mssg'));
			}
			?>
           </li>
         
           <li>
            <?php
			if(Yii::app()->controller->id=='news')
			{
				echo CHtml::link(Yii::t('parentportal','News'),array('/mailbox/news'),array('class'=>'news_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','News'),array('/mailbox/news'),array('class'=>'news'));
			}
			?>
           </li>
               <li>
            <?php
			if(Yii::app()->controller->action->id=='events')
			{
				echo CHtml::link(Yii::t('parentportal','Events'),array('/dashboard/default/events'),array('class'=>'events_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Events'),array('/dashboard/default/events'),array('class'=>'events'));
			}
           ?>
            </li>
               <li>
            <?php
			if(Yii::app()->controller->action->id=='eventlist')
			{
				echo CHtml::link(Yii::t('parentportal','Calender'),array('/parentportal/default/eventlist'),array('class'=>'cal_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Calender'),array('/parentportal/default/eventlist'),array('class'=>'cal'));
			}
           
			?>
            </li>
           <li>
           <?php
		   	if(Yii::app()->controller->id == 'default' and Yii::app()->controller->action->id == 'profile')
			{
				echo CHtml::link(Yii::t('parentportal','Profile'),array('/parentportal/default/profile'),array('class'=>'profile_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Profile'),array('/parentportal/default/profile'),array('class'=>'profile'));
			}
		   ?>
           </li>
            <li>
           <?php
		   	if(Yii::app()->controller->action->id=='studentprofile' or Yii::app()->controller->action->id=='documentupdate')
			{
				echo CHtml::link(Yii::t('parentportal','Student Profile'),array('/parentportal/default/studentprofile'),array('class'=>'s_profile_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Student Profile'),array('/parentportal/default/studentprofile'),array('class'=>'s_profile'));
			}
		   ?>
           </li>
             <li>
           <?php
		   	if(Yii::app()->controller->action->id=='attendance')
			{
				echo CHtml::link(Yii::t('parentportal','Attendance'),array('/parentportal/default/attendance'),array('class'=>'attendance_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Attendance'),array('/parentportal/default/attendance'),array('class'=>'attendance'));
			}
		   ?>
           </li>   
           <li>
           <?php
		   	if(Yii::app()->controller->action->id=='fees')
			{
				echo CHtml::link(Yii::t('parentportal','Fees'),array('/parentportal/default/fees'),array('class'=>'fees_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Fees'),array('/parentportal/default/fees'),array('class'=>'fees'));
			}
		   ?>
           </li>   
             
                  <li>
           <?php
		   	if(Yii::app()->controller->action->id=='exams')
			{
				echo CHtml::link(Yii::t('parentportal','Exams'),array('/parentportal/default/exams'),array('class'=>'exams_active'));
			}
			else
			{
				echo CHtml::link(Yii::t('parentportal','Exams'),array('/parentportal/default/exams'),array('class'=>'exams'));
			}
		   ?>
           </li>     
            
            <li>
           <?php
		   		if(Yii::app()->controller->module->id == 'user')
				{
					echo CHtml::link(Yii::t('parentportal','Settings'),array('/user/profile'),array('class'=>'settings_active'));
				}
				else
				{
		   			echo CHtml::link(Yii::t('parentportal','Settings'),array('/user/profile'),array('class'=>'settings'));
				}
		   ?>
           </li>    
              
            </ul>
      
        </div>