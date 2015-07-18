<?php
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DateRangePicker;
use frontend\widgets\editable\Editable;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<!-- HEADER -->
<?php $this->beginBlock('page-header'); ?>
    
    <!-- Title & Dates -->
    <div class="row">
        <div class="col-lg-12 time-range">
            
            <?= Editable::widget([
                'identifier' => $account->id,
                'text' => $account->alias,
                'property' => 'alias',
                'default' => $account->name,
                'action' => '/accounting/rest/account/rename',    
            ]); ?>
        
            <div class="right-menu">
                <span class="icon"><i class="fa fa-calendar"></i></span> 
                <div id="input-daterange-container">
                    <?= DateRangePicker::widget([
                        'id' => 'input-daterange-widget',
                        'name' => 'date_from',
                        'size' => 'sm',
                        'value' => date("Y-m-d", strtotime(date("Y-m-d").' -1 months')),
                        'nameTo' => 'date_to',
                        'valueTo' => date("Y-m-d"),
                        'labelTo' => '<i class="fa fa-chevron-right"></i>',
                        'clientOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true
                        ],
                        'clientEvents' => [
                            'changeDate' => 'function ev(){acc_acc_refresh();}'
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Page Summary -->
    <div id="page-header-summary" class="row"></div>
    
<?php $this->endBlock(); ?>

<!-- MAIN CONTENT -->
<div class="fp-acc-page">    
    <div id="accounting-account-container" class="content" accountid="<?= $account->id ?>"></div>
</div>

<!-- JAVASCRIPT -->
<?php $this->registerJs("acc_acc_init()", $this::POS_READY); ?>