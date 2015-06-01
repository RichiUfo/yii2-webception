<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\web\View;

use \fruppel\googlecharts\GoogleCharts;
use dosamigos\datepicker\DateRangePicker;
use frontend\widgets\rotatingcard\RotatingCardWidget;

use frontend\controllers\LocalizationController;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>


<!-----------------------
-- EDITABLE PAGE TITLE --
------------------------>
<div class="editable-page-title">
    
    <!-- Default Display -->
    <h1 id="account-title" class="editable text-center">
        <span id="account-title-value"><?= $account->account->alias ?></span>
    </h1>
    
    <!-- Edition Mode -->
    <div id="account-title-edit" style="display: none">
        
        <?php 
            $form = ActiveForm::begin(['id' => 'account-title-edit-form', 'class' => 'form-inline']); 
            echo Html::input('hidden', 'account_id', $account->account->id);
        ?>
        
        <?= $form->field($account->account, 'alias', [
            'enableLabel' => false,
            'options' => ['class' => 'form-inline'],
            'inputOptions' => [
                'class' => 'form-field-invisible text-center h1',
                'id' => 'account-title-edit-form-field',
                'value' => $account->account->alias,
            ]]) ?>
            
        <div class="buttons-line pull-right form-inline">
            <?= Html::button('Default', [
                    'id' => 'account-title-edit-form-reset-button',
                    'class' => 'btn btn-xs'
            ]) ?>
            <?= Html::button('Save', [
                    'id' => 'account-title-edit-form-button',
                    'class' => 'btn btn-xs btn-primary'
            ]) ?> 
        </div>
        
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
/* Use Case : User click on the editable title */
$this->registerJs("$('#account-title').on('click', function(event) {
        $('#account-title').hide();
        $('#account-title-edit').show();
    });" , $this::POS_END);
    
/* Use Case : User click on the save button */
$this->registerJs("$('#account-title-edit-form-button').on('click', function(event) {
    if($('#account-title-edit-form-field').val() === ''){
        $('#account-title-value').html('".$account->account->name."');
    }
    else {
        $('#account-title-value').html($('#account-title-edit-form-field').val());
    }
    $('#account-title').show();
    $('#account-title-edit').hide();
    console.log($('#account-title-edit-form').serializeArray());
    $.ajax({
        method: 'POST',
        url: '/accounting/account/rename',
        data: $('#account-title-edit-form').serializeArray(),
        success: function(result){
            ToastrAjaxFeed.getNotifications('/notification/get-notifications', {'positionClass':'toast-bottom-right'});
        }
    });
});" , $this::POS_END);

/* Use Case : User click on the default button */
$this->registerJs("$('#account-title-edit-form-reset-button').on('click', function(event) {
    $('#account-title-edit-form-field').val('".$account->account->name."');
});" , $this::POS_END);


?>


<?php var_dump($account); ?>