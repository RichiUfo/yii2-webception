<?php
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DateRangePicker;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<!-- LEFT PANEL -->
<?php $this->render('@app/views/partials/left_panel', [
    'back_button' => $back_button,
    'left_menus' => $left_menus
]); ?>

<!-- MAIN CONTENT -->
<div class="fp-acc-page">
    
    <div class=" header time-range">
        <h1>Balance Sheet</h1>
    
        <div class="right-menu">
            
            <span class="icon"><i class="fa fa-calendar"></i></span> 
            
            <div id="input-daterange-container">
                <?= DateRangePicker::widget([
                    'id' => 'input-daterange-widget',
                    'name' => 'date_from',
                    'size' => 'sm',
                    'value' => date("Y-m-d", strtotime(date("Y-m-d").' -1 months')),
                    'nameTo' => 'name_to',
                    'valueTo' => date("Y-m-d"),
                    'labelTo' => '<i class="fa fa-chevron-right"></i>',
                    'clientOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true
                    ],
                    'clientEvents' => [
                        'changeDate' => 'function ev(){acc_bs_refresh();}'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    
    <div id="accounting-balancesheet-container" class="content"></div>
    
    
</div>

<!-- JAVASCRIPT -->
<?php $this->registerJs("acc_bs_init()", $this::POS_READY); ?>
