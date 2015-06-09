<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\date\DatePicker;
use frontend\widgets\stepform\StepForm;

?>

<?php
$stepform = StepForm::begin([
	'id' => 'create-account',
	'activeFormOptions' => [
		'id' => 'create-account-form',
		'enableClientValidation' => false
	],
	'header' => [
		'title_strong' => 'NEW',
		'title' => 'ACCONUT',
		'subtitle' => 'General Account Creation'
		],
	'steps' => [
		'step1' => 'Parent',
		'step2' => 'Account',
		'step3' => 'Summary'
		]
	]
);
?>

    <div class="tab-pane" id="step1">
        <div class="row">
            <h4 class="info-text">Choose a parent</h4>
          
            <div class="col-sm-10 col-sm-offset-1">
                <?= $stepform->form
                ->field($model, 'parent_id')
                ->dropDownList($accounts, [
                    'class' => 'form-control account-select', 
                    'prompt' => 'Select An Account'
                ]) ?>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="step2">
        <h4 class="info-text">Give it a name</h4>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <?= $stepform->form->field($model, 'name') ?>
                <?= $stepform->form->field($model, 'currency') ?>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="step3">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="info-text">Confirm That !</h4>
            </div>
            <div class="col-sm-10 col-sm-offset-1">
                 
            </div>
        </div>
    </div>
<?php $stepform->end() ?>