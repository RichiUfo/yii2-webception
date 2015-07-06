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
    
    <div class="header time-range">
        <h1>Income Statement</h1>
    
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
                        'changeDate' => 'function ev(){acc_pl_refresh();}'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    
    <div id="accounting-income-container" class="content"></div>
    
</div>

<!-- JAVASCRIPT -->
<?php $this->registerJs("acc_pl_init()", $this::POS_READY); ?>