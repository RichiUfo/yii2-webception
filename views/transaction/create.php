<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\widgets\stepform\StepFormWidget;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

?>

<div id="transaction-create-app" ng-controller="FormController" class="transaction-form">
	
	<?php $form = ActiveForm::begin([
		'id' => 'create-transaction-form',
		'enableClientValidation' => false
	]); ?>

	<?php StepFormWidget::begin([
		'id' => 'formtest',
		'header' => [
			'title_strong' => 'NEW',
			'title' => 'ACCOUNTING TRANSACTION',
			'subtitle' => 'Use this form to report a general accounting transaction'
			],
		'steps' => [
			'accounts' => 'Accounts',
			'details' => 'Details',
			'summary' => 'Summary'
			]
		]
	); ?>  

		<div class="tab-pane" id="accounts">
			<div class="row">
				<h4 class="info-text">Pick the accounts</h4>
				<div class="col-sm-5 col-sm-offset-1 acccount-select-group">
					<?= $form
						->field($model, 'account_debit_id')
						->dropDownList($accounts, [
							'class' => 'form-control account-select', 
							'ng-model' => 'account_debit_id',
							'prompt' => 'Select An Account'
						]) ?>
					<div class="account-summary">
						<div class="name">{{account_debit.name}} 
							<span class="pull-right">{{account_debit.display_value}} {{account_debit.currency.code}}</span>
						</div>
						<div class="root"><img src="<?= Url::to('@web/img/flags/48/') ?>{{account_debit.currency.img}}"></div>
					</div>
				</div>
				<div class="col-sm-5 acccount-select-group">
					<?= $form
						->field($model, 'account_credit_id')
						->dropDownList($accounts, [
							'class' => 'form-control account-select', 
							'ng-model' => 'account_credit_id',
							'prompt' => 'Select An Account'
						]) ?>
					<div class="account-summary">
						<div class="name">{{account_credit.name}} 
							<span class="pull-right">{{account_credit.display_value}} {{account_credit.currency.code}}</span>
						</div>
						<div class="root"><img src="<?= Url::to('@web/img/flags/48/') ?>{{account_credit.currency.img}}"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<p class="feedback info-text text-center"></p>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="details">
			<div class="row">
				<div class="col-sm-5 col-sm-offset-1">
					<?= $form->field($model, 'date_value')
						->widget(DatePicker::classname(), [
							'options' => [
								'placeholder' => '',
								'style' => 'display:none'
							],  
							'type' => DatePicker::TYPE_INLINE,
							'removeButton' => false,
							'size' => 'sm',
							'pluginOptions' => [
								'autoclose'=>true,
								'format' => 'yyyy/mm/dd'
							]
						]);
					?>
				</div>
				<div class="col-sm-5">
					<?= $form->field($model, 'name', ['options' => [
						'style'=>'margin-bottom:30px'
					]]) ?>

					<?= $form->field($model, 'description', ['options' => [
						'style'=>'margin-bottom:30px'
					]]) ?>

					<div ng-if="account_credit.currency.code == account_debit.currency.code">
						<?= $form->field($model, 'value') ?>
					</div>
					
					<div ng-if="account_credit.currency.code != account_debit.currency.code">
						<?= Html::input("text", "value_debit"); ?>
						<?= Html::input("text", "value_credit"); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<p class="feedback info-text text-center"></p>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="summary">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="info-text">Confirm the transaction ?</h4>
				</div>
				<div class="col-sm-7 col-sm-offset-1">
					 <div class="form-group">
						<label>debitaccount</label>
					  </div>
				</div>
				<div class="col-sm-3">
					 <div class="form-group">
						<label>Some info</label>
					  </div>
				</div>
			</div>
		</div>
		<?php StepFormWidget::end(); ?>
	<?php ActiveForm::end(); ?>

	<?php $this->registerJs('fp_angular_bootstrap("transaction-create-app", ["transactionCreateApp"])'); ?>
</div>