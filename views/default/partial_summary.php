<?php
use yii\helpers\Url;
use frontend\widgets\chartjs\ChartJs;

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ButtonDropdown;
use dosamigos\datepicker\DateRangePicker;
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
    
    <!-- Data Summary -->
    <div class="col-lg-4">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th colspan="3">Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Revenues</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Expenses</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Net Income</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Analytics -->
    <div class="col-lg-4">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th colspan="3">Analytics</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Debt To Equity</td>
                    <td class="fit-width"><span class="pull-right">47 %</span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Current Ratio</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Return On Assets</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Return On Equity</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
            </tbody>
        </table>
        
    </div>
    
    
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th colspan="3">Quick Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Debt To Equity</td>
                    <td class="fit-width"><span class="pull-right">47 %</span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Current Ratio</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Return On Assets</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
                <tr>
                    <td>Return On Equity</td>
                    <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                    <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="125.12" currency=""></span></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php $this->endBlock(); ?>

<div class="row">
    
    <!-- Balance Sheet -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="box">
            <span class="title"><a href="<?= Url::toRoute('/accounting/balancesheet') ?>">Balance Sheet</a></span>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <?php
                    $dates = [];
                    $equity = []; 
                    $liabilities = [];
                    foreach($balancesheet as $d => $v) {
                        array_push($dates, $d);
                        array_push($equity, $v[0]);
                        array_push($liabilities, $v[0]+$v[1]);
                    }
                    ?>
                    <div class="chart-container-full-width">
                        <?= ChartJs::widget([
                            'type' => 'Line',
                            'options' => [
                                'height' => 100,
                            ],
                            'clientOptions' => [
                                'showScale' => false,
                                //'maintainAspectRatio' => false,
                                'scaleShowGridLines' => false,
                                //'scaleShowLabels' => false,
                                'responsive' => true,
                                'showTooltips' => false,
                                'pointDot' => false,
                                'bezierCurve' => false,
                                'datasetStrokeWidth' => 1,
                            ],
                            'data' => [
                                'labels' => $dates,
                                'datasets' => [
                                    [
                                        'fillColor' => "rgba(41,171,164,0.2)",
                                        'strokeColor' => "rgba(41,171,164,1)",
                                        'data' => $equity
                                    ],
                                    [
                                        'fillColor' => "rgba(235,114,96,0.2)",
                                        'strokeColor' => "rgba(235,114,96,1)",
                                        'data' => $liabilities
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <div class="row">
                        <div class="col-xs-4 col-sm-12 col-md-12 col-lg-4">
                            <div class="data-block">
                                <span class="data-block-value money" value="<?= $data['total_assets'] ?>" currency="" decimal="0"></span>
                                <span class="data-block-title">Assets</span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-12 col-md-12 col-lg-4">
                            <div class="data-block">
                                <span class="data-block-value money" value="<?= $data['total_liabilities'] ?>" currency="" decimal="0"></span>
                                <span class="data-block-title">Debt</span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-12 col-md-12 col-lg-4">
                            <div class="data-block">
                                <span class="data-block-value money" value="<?= $data['total_equity'] ?>" currency="" decimal="0"></span>
                                <span class="data-block-title">Net Wealth</span>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Income -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="box">
            <span class="title"><a href="<?= Url::toRoute('/accounting/profitloss') ?>">Profits &amp; Losses</a></span>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 text-center">
                    <div class="chart-container-full-width">
                        <?= ChartJs::widget([
                            'type' => 'Line',
                            'options' => [
                                'height' => 100,
                            ],
                            'clientOptions' => [
                                'showScale' => false,
                                'scaleShowGridLines' => false,
                                //'scaleShowLabels' => false,
                                'responsive' => true,
                                'showTooltips' => false,
                                'pointDot' => false,
                            ],
                            'data' => [
                                'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                                'datasets' => [
                                    [
                                        'fillColor' => "rgba(41,171,164,0)",
                                        'strokeColor' => "rgb(41,171,164)",
                                        'data' => [0, 59, 90, 81, 56, 55, 90]
                                    ],
                                    [
                                        'fillColor' => "rgba(58,154,217,0)",
                                        'strokeColor' => "rgb(58,154,217)",
                                        'data' => [0, 5, 4, 10, 20, 27, 50]
                                    ],
                                    [
                                        'fillColor' => "rgba(254,254,254,0)",
                                        'strokeColor' => "rgb(235,114,96)",
                                        'data' => [0, -48, -40, -19, -96, -27, -100]
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <div class="row">
                        <div class="col-xs-4 col-sm-12 col-md-12 col-lg-4">
                            <div class="data-block">
                                <span class="data-block-value money" value="" currency=""></span>
                                <span class="data-block-title">Total</span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-12 col-md-12 col-lg-4">
                            <div class="data-block">
                                <span class="data-block-value money" value="" currency=""></span>
                                <span class="data-block-title">Operating</span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-12 col-md-12 col-lg-4">
                            <div class="data-block">
                                <span class="data-block-value money" value="" currency=""></span>
                                <span class="data-block-title">Non-Operating</span>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cash Flow -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="box">
            <span class="title"><a href="<?= Url::toRoute('/accounting/cashflow') ?>">Cash Flow</a></span>
            <div class="chart-container-full-width">
            <?= ChartJs::widget([
                'type' => 'Doughnut',
                'options' => [
                    'height' => 100,
                ],
                'clientOptions' => [
                    'responsive' => true,
                    // Specific doughnut
                    'segmentShowStroke' => true,
                    'segmentStrokeColor' => "#fff",
                    'segmentStrokeWidth' => 2,
                    'percentageInnerCutout' => 65,
                    'animationSteps' => 20,
                    'animationEasing' => "swing",
                    'animateRotate' => false,
                    'animateScale' => true,
                ],
                'data' => [
                    [
                        'value' => round($data['total_equity']),
                        'color' => "rgb(41,171,164)",
                        'label' => "Equity"
                    ],
                    [
                        'value' => round($data['total_liabilities']),
                        'color' => "rgb(235,114,96)",
                        'label' => "Debt"
                    ],
                    [
                        'value' => round($data['total_assets']),
                        'color' => "rgb(58,154,217)",
                        'label' => "Assets"
                    ]
                ]
            ]);
            ?>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="data-block">
                        <span class="data-block-value money" value="" currency=""></span>
                        <span class="data-block-title">Operating</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="data-block">
                        <span class="data-block-value money" value="" currency=""></span>
                        <span class="data-block-title">Investing</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="data-block">
                        <span class="data-block-value money" value="" currency=""></span>
                        <span class="data-block-title">Financing</span>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    
</div>