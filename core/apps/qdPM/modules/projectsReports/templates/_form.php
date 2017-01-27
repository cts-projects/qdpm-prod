<?php
/**
*qdPM
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@qdPM.net so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade qdPM to newer
* versions in the future. If you wish to customize qdPM for your
* needs please refer to http://www.qdPM.net for more information.
*
* @copyright  Copyright (c) 2009  Sergey Kharchishin and Kym Romanets (http://www.qdpm.net)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
?>

<?php if($form->getObject()->isNew()) $form->setDefault('users_id',$sf_user->getAttribute('id')) ?>

<form  class="form-horizontal" role="form"  id="projectsReports" action="<?php echo url_for('projectsReports/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('redirect_to',$sf_request->getParameter('redirect_to')) ?>

<?php echo $form->renderGlobalErrors() ?>

  <div class="form-group">
  	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['name'] ?>
  	</div>
  </div>

    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['display_on_home']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['display_on_home'] ?></label></div>
    	</div>
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['display_in_menu']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['display_in_menu'] ?></label></div>
    	</div>
    </div>


    <h3 class="form-section"><?php echo __('Projects Filters') ?></h3>
    
    <?php echo app::getReportFormFilterByTable('Status','projects_reports[projects_status_id]','ProjectsStatus',$form['projects_status_id']->getValue()) ?>
    
    <?php echo app::getReportFormFilterByTable('Type','projects_reports[projects_type_id]','ProjectsTypes',$form['projects_type_id']->getValue()) ?>    

        

    <?php
              
      if(count($choices = app::getProjectChoicesByUser($sf_user,true))>0)
      { 
        if(!is_string($v = $form['projects_id']->getValue())) $v = '';
        
        echo  '
          <div class="form-group">
          	<label class="col-md-3 control-label">' . __('Projects') . '</label>
          	<div class="col-md-9">
          		' . select_tag('projects_reports[projects_id]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('class'=>'form-control  multiple-select-tag','style'=>'')) . '
          	</div>
          </div>
        ';
        
      }          
      if(count($choices = app::getItemsChoicesByTable('Users',true))>0 and (Users::hasAccess('insert','projects',$sf_user) or Users::hasAccess('edit','projects',$sf_user)))
      { 
        if(!is_string($v = $form['in_team']->getValue())) $v = '';
        
        echo  '
          <div class="form-group">
          	<label class="col-md-3 control-label">' . __('In Team') . '</label>
          	<div class="col-md-9">
          		' . select_tag('projects_reports[in_team]',explode(',',$v),array('choices'=>$choices),array('class'=>'form-control')) . '
          	</div>
          </div>
        ';                
      }          
    ?>      

  </div>
</div>

<?php echo ajax_modal_template_footer() ?>

</form>

<?php include_partial('global/formValidator',array('form_id'=>'projectsReports')); ?>


