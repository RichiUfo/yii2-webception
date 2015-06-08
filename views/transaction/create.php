<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\widgets\stepform\StepForm;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

?>

<div id="transaction-create-app" ng-controller="FormController" class="transaction-form">
	
	<?php
	$stepform = StepForm::begin([
		'id' => 'formtest',
		'activeFormOptions' => [
			'id' => 'create-transaction-form',
			'enableClientValidation' => false
		],
		'header' => [
			'title_strong' => 'NEW',
			'title' => 'TRANSACTION',
			'subtitle' => 'General Accounting Transaction'
			],
		'steps' => [
			'accounts' => 'Accounts',
			'details' => 'Details',
			'summary' => 'Summary'
			]
		]
	);
	?>
	
	<!-- STEP 1 -->
	<div class="tab-pane" id="accounts">
		<div class="row">
			<!--h4 class="info-text">Pick the accounts</h4-->
			<div class="col-sm-5 col-sm-offset-1 acccount-select-group">
				<?= $stepform->form
					->field($model, 'account_debit_id')
					->dropDownList($accounts, [
						'class' => 'form-control account-select', 
						'ng-model' => 'account_debit_id',
						'prompt' => 'Select An Account'
					]) ?>
				<div class="account-summary" ng-show="account_debit">
					<div class="name"><img src="<?= Url::to('@web/img/flags/32/') ?>{{account_debit.currency.img}}">&nbsp;{{account_debit.name}} 
						<span class="pull-right">
							{{account_debit.display_value | number:2}} {{account_debit.currency.code}}
						</span>
					</div>
				</div>
			</div>
			<div class="col-sm-5 acccount-select-group">
				<?= $stepform->form
					->field($model, 'account_credit_id')
					->dropDownList($accounts, [
						'class' => 'form-control account-select', 
						'ng-model' => 'account_credit_id',
						'ng-disabled' => '{{error.valid}}',
						'prompt' => 'Select An Account'
					]) ?>
				<div class="account-summary" ng-show="account_credit">
					<div class="name"><img src="<?= Url::to('@web/img/flags/48/') ?>{{account_credit.currency.img}}">&nbsp;{{account_credit.name}} 
						<span class="pull-right">{{account_credit.display_value | number:2}} {{account_credit.currency.code}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="feedback info-text text-center">{{error.msg}}</p>
			</div>
		</div>
	</div>
	
	<!-- STEP 2 -->
	<div class="tab-pane" id="details">
		<div class="row">
			<div class="col-sm-5 col-sm-offset-1">
				<?= $stepform->form->field($model, 'date_value')
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
				<?= $stepform->form->field($model, 'name', [
					//'options' => ['style'=>'margin-bottom:30px'],
					'inputOptions' => [
						'placeholder' => 'Transaction Title',
					]
				]) ?>

				<?= $stepform->form->field($model, 'description', [
					'enableLabel' => false,
					'options' => ['style'=>'margin-bottom:30px'],
					'inputOptions' => [
						'placeholder' => 'Comment (optional)',
					]
				]) ?>

				<div ng-if="account_credit.currency.code == account_debit.currency.code">
					<div class="form-group field-transaction-value required">
						<label class="control-label" for="transaction-value">Value</label>
						<div class="input-group m-b">
	      					<input type="text" id="transaction-value" class="form-control" name="Transaction[value]" placeholder="">
	      					<div class="input-group-addon right">
	      						{{account_debit.currency.code}}&nbsp;
	      						<img src="<?= Url::to('@web/img/flags/24/') ?>{{account_debit.currency.img}}">
	  						</div>
      					</div>
					</div>
				</div>
				
				<div ng-if="account_credit.currency.code != account_debit.currency.code">
					<?= Html::label('Value', 'fp-sf-tr-vd', ['class'=>'control-label']); ?>
					<div class="input-group m-b">
      					<?= Html::input("text", "value_debit", '', [
      						'id'=>'fp-sf-tr-vd', 
      						'class'=>'form-control', 
      						'placeholder' => 'Debit {{account_debit.name}}',
      						'ng-model' => '$parent.debit_value',
  						]); ?>
      					<div class="input-group-addon right">
      						{{account_debit.currency.code}}&nbsp;
      						<img src="<?= Url::to('@web/img/flags/24/') ?>{{account_debit.currency.img}}">
  						</div>
      				</div>
      				<div class="input-group m-b">
						<?= Html::input("text", "value_credit", null, [
							'class'=>'form-control', 
      						'placeholder' => 'Credit {{account_credit.name}}',
      						'ng-model' => '$parent.credit_value',
      					]); ?>
						<div class="input-group-addon right">
							{{account_credit.currency.code}}&nbsp;
							<img src="<?= Url::to('@web/img/flags/24/') ?>{{account_credit.currency.img}}">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="feedback info-text text-center"></p>
			</div>
		</div>
	</div>
	
	<!-- STEP 3 -->
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
	
	<?php StepForm::end(); ?>

	<?php $this->registerJs('fp_angular_bootstrap("transaction-create-app", ["transactionCreateApp"])'); ?>
</div>