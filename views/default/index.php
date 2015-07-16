<?php
use dosamigos\chartjs\ChartJs;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ButtonDropdown;
use dosamigos\datepicker\DateRangePicker;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<!-- HEADER -->
<?php $this->beginBlock('page-header'); ?>
    
    <!-- Title & Dates -->
    <div class="col-lg-12 time-range">
        <h1>Accounting</h1>
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
                        'changeDate' => 'function ev(){acc_sum_refresh();}'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    
    <!-- Page Summary -->
    <div id="page-header-summary"></div>
<?php $this->endBlock(); ?>

<!-- MAIN CONTENT -->
<div class="fp-acc-page">    
    <div id="accounting-summary-container" class="content"></div>
</div>

<!-- JAVASCRIPT -->
<?php $this->registerJs("acc_sum_init()", $this::POS_READY); ?>
