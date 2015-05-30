<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\date\DatePicker;
use frontend\widgets\stepform\StepFormWidget;

?>

<?php $form = ActiveForm::begin([
    'id' => 'create-account-form',
    'enableClientValidation' => false
]); ?>

    <?php StepFormWidget::begin([
        'id' => 'formtest',
        'header' => [
            'title_strong' => 'NEW',
            'title' => 'ACCOUNT',
            'subtitle' => 'Register a new account'
            ],
        'steps' => [
            'step1' => 'Parent',
            'step2' => 'Account',
            'step3' => 'Summary'
            ]
        ]); ?>  
    
        <div class="tab-pane" id="step1">
            <div class="row">
                <h4 class="info-text">Choose a parent</h4>
              
                <div class="col-sm-10 col-sm-offset-1">
                    <?= $form
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
                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'currency') ?>
                </div>
            </div>
        </div>
    
        <div class="tab-pane" id="step3">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="info-text"> Confirm That ! </h4>
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                     
                </div>
            </div>
        </div>
    <?php StepFormWidget::end() ?>
<?php ActiveForm::end() ?>