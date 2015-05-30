<?php
use dosamigos\chartjs\ChartJs;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use frontend\modules\accounting\assets\AccountingAsset;
AccountingAsset::register($this);
?>

<!-- LEFT PANEL -->
<?php $this->render('@app/views/partials/left_panel', [
    'back_button' => $back_button,
    'left_menus' => $left_menus
]); ?>

<!-- MAIN CONTENT -->
<h1 class="text-center">Accounting</h1>
<div id="accounting-index">
    <div class="row">

        <!-- Balance Sheet -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card informative-block">
                <div class="card-header">
                    <div class="banner-title">
                        <p>
                            <i class="fa fa-pie-chart"></i>
                            <a href="<?= yii\helpers\Url::toRoute('/accounting/balancesheet') ?>">Balance Sheet</a>
                        </p>
                    </div>
                    <div class="banner-subtitle">
                        <p></p>
                    </div>
                </div>
                <div id="accounting-balance-sheet-overview" class="card-content">
                    <img src="/img/ajax-loader.gif">
                </div>
            </div>
        </div>

        <!-- Income -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card informative-block">
                <div class="card-header">
                    <div class="banner-title">
                        <p>
                            <i class="fa fa-bar-chart"></i>
                            <a href="<?= yii\helpers\Url::toRoute('/accounting/profitloss') ?>">Income</a>
                        </p>
                    </div>
                    <div class="banner-subtitle">
                        <p></p>
                    </div>
                </div>
                <div id="accounting-profit-loss-overview" class="card-content">
                    <img src="/img/ajax-loader.gif">
                </div>
            </div>
        </div>

        <!-- Cash Flow -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card informative-block">
                <div class="card-header">
                    <div class="banner-title">
                        <p>
                            <i class="fa fa-random"></i>
                            <a href="<?= yii\helpers\Url::toRoute('/accounting') ?>">Cash Flow</a>
                        </p>
                    </div>
                    <div class="banner-subtitle">
                        <p></p>
                    </div>
                </div>
                <div id="accounting-cash-flow-overview" class="card-content">
                    <img src="/img/ajax-loader.gif">
                </div>
            </div>
        </div>
  </div>
  <div class="row">
        <!-- Assets -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card informative-block">
                <div class="card-header">
                    <div class="banner-title">
                        <p>
                            <i class="fa fa-building-o"></i>
                            <a href="<?= yii\helpers\Url::toRoute('/accounting/asset') ?>">Assets</a>
                        </p>
                    </div>
                    <div class="banner-subtitle">
                        <p></p>
                    </div>
                </div>
                <div id="accounting-assets-overview" class="card-content">
                    <img src="/img/ajax-loader.gif">
                </div>
            </div>
        </div>

        <!-- Operating Expenses -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card informative-block">
                <div class="card-header">
                    <div class="banner-title">
                        <p>
                            <i class="fa fa-shopping-cart"></i>
                            <a href="<?= yii\helpers\Url::toRoute('/') ?>">Expenses</a></p>
                        </p>
                    </div>
                    <div class="banner-subtitle">
                        <p></p>
                    </div>
                </div>
                <div id="accounting-profit-loss-overview" class="card-content">
                    <!--img src="/img/ajax-loader.gif"-->
                </div>
            </div>
        </div>

        <!-- Contracts -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card informative-block">
                <div class="card-header">
                    <div class="banner-title">
                        <p>
                            <i class="fa fa-file-text-o"></i>
                            <a href="<?= yii\helpers\Url::toRoute('/') ?>">Contracts</a></p>
                        </p>
                    </div>
                    <div class="banner-subtitle">
                        <p></p>
                    </div>
                </div>
                <div id="accounting-cash-flow-overview" class="card-content">
                    <!--img src="/img/ajax-loader.gif"-->
                </div>
            </div>
        </div>
        
    </div>
</div>






<!-- JAVASCRIPT -->
<?php

// Loading the view blocks when the document is ready
$js = "
$(document).ready(function() {

    $.ajax({
        url: '/accounting/balancesheet/overview',
        success: function(result){
            $('#accounting-balance-sheet-overview').html(result);
            $(document).trigger('domupdated');
        }
    });
    
    $.ajax({
        url: '/accounting/profitloss/overview',
        success: function(result){
            $('#accounting-profit-loss-overview').html(result);
            $(document).trigger('domupdated');
        }
    });
    
    $.ajax({
        url: '/accounting/cashflow/overview',
        success: function(result){
            $('#accounting-cash-flow-overview').html(result);
            $(document).trigger('domupdated');
        }
    });
    
    $.ajax({
        url: '/accounting/asset/overview',
        success: function(result){
            $('#accounting-assets-overview').html(result);
            $(document).trigger('domupdated');
        }
    });

});
";
$this->registerJs($js, $this::POS_END);
?>
