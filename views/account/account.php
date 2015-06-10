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
use frontend\widgets\editable\Editable;

use frontend\controllers\LocalizationController;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<!-- LEFT PANEL -->
<?php $this->render('@app/views/partials/left_panel', [
    'back_button' => $back_button,
    'left_menus' => $left_menus
]); ?>

<!-- RIGHT PANEL -->
<?php $this->beginBlock('right_panel'); ?>
    <div class="side_panel_block">
        <div id="side-menu" class="text-center">
            <h2 class="title text-center">Time Period</h2>
            <div class="btn-group" style="margin: 10px">
                <button id="period-year" class="btn btn-white btn-xs btn-account-period" type="button">Year</button>
                <button id="period-quarter" class="btn btn-white btn-xs btn-account-period" type="button">Quarter</button>
                <button id="period-month" class="btn btn-white btn-xs  btn-account-period active" type="button">Month</button>
                <button id="period-week" class="btn btn-white btn-xs btn-account-period" type="button">Week</button>
            </div>
            <div id="account-period-selection" class="right-col-item" style="margin: 10px">
                <?= DateRangePicker::widget([
                    'name' => 'date_from',
                    'size' => 'sm',
                    'value' => date("Y-m-d", strtotime(date("Y-m-d").' -1 months')),
                    'nameTo' => 'name_to',
                    'valueTo' => date("Y-m-d"),
                    'clientOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true
                    ],
                    'clientEvents' => [
                        'changeDate' => 'function ev(){timePeriodChangeHandler();}'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
<?php $this->endBlock(); ?>

<!-- MAIN CONTENT -->

<!-----------------------
-- EDITABLE PAGE TITLE --
------------------------>

<!-- Account Name Edition -->
<?= Editable::widget([
    'identifier' => $account->id,
    'text' => $account->alias,
    'property' => 'alias',
    'default' => $account->name,
    'action' => '/accounting/rest/account/rename',    
]); ?>

<!------------------------
-- ACCOUNT PAGE CONTENT --
------------------------->
<div id="account-display">
    
    <div class="container-fluid">
        <div class="row">
            <div class="row-same-height row-full-height">
                <!-- Account Summary -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-sm-height col-full-height">
                    <div class="card informative-block">
                        <div class="card-header">
                            <div class="banner-title">
                                <p>Overview</p>
                            </div>
                            <div class="banner-subtitle">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-content">
                            Value <span class="money" value="<?= $account->display_value ?>" currency=""></span><br>
                        </div>
                    </div>
                </div>
                
                <!-- Movements -->
                <div id="movements-summary-ajax" class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-sm-height col-full-height">
    
                </div>
                
                <!-- Children -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-sm-height col-full-height">
                    <div class="card informative-block">
                        <div class="card-header">
                            <div class="banner-title">
                                <p>Sub-Accounts</p>
                            </div>
                            <div class="banner-subtitle">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-content">
                            <table style="width: 100%">
                                <?php foreach($account->children as $child) : ?>
                                <tr>
                                    <td><?= $child->name ?></td>
                                    <td class="text-right">
                                        <span class="money" 
                                              value="<?= $child->display_value ?>" 
                                              currency=""></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div id="account-transactions-ajax" accountid="<?= $account->id ?>" class="col-lg-12">
                
            </div>
        </div>
    </div>
</div>