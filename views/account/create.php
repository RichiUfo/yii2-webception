<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\date\DatePicker;
use frontend\widgets\stepform\StepForm;

?>

<div id="account-create-app" ng-controller="NewAccountFormController" class="account-form">
    <?php
    $stepform = StepForm::begin([
    	'id' => 'create-account',
    	'activeFormOptions' => [
    		'id' => 'create-account-form',
    		'enableClientValidation' => false
    	],
    	'header' => [
    		'title_strong' => 'NEW',
    		'title' => 'ACCOUNT',
    		'subtitle' => 'General Account Creation'
    		],
    	'steps' => [
    		'step1' => 'Creation',
    		'step2' => 'Summary',
    		]
    	]
    );
    ?>
    
        <div class="tab-pane" id="step1">
            <div class="row">
                <div class="col-lg-5 col-sm-offset-1">
                    <h4 class="info-text">Parent Account</h4>
                    <?= $stepform->form
                    ->field($model, 'parent_id')
                    ->dropDownList($accounts, [
                        'class' => 'form-control account-select', 
                        'ng-model' => 'parent_account',
                        'prompt' => 'Select An Account'
                    ]) ?>
                </div>
                <div class="col-lg-5">
                    <h4 class="info-text">New Account</h4>
                    <?= $stepform->form->field($model, 'number'); /*->input('text', [
                        'disabled' => true, 
                        'ng-model' => 'account_number'
                    ]) */ ?>
                    <?= $stepform->form->field($model, 'name') ?>
                    <?= $stepform->form->field($model, 'currency') ?> 
                </div>
                
            </div>
        </div>
    
        <div class="tab-pane" id="step2">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="info-text">Confirm the following account creation</h4>
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                     
                </div>
            </div>
        </div>
        
    <?php $stepform->end() ?>
    
	<?php $this->registerJs('fp_angular_bootstrap("account-create-app", ["accountCreateApp"])'); ?>
</div>