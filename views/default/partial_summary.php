<?php
use frontend\widgets\chartjs\ChartJs;
?>

<div class="row">
    
    <!-- Balance Sheet -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <h2 class="text-center">Balance Sheet</h2>
        <?= ChartJs::widget([
            'type' => 'Doughnut',
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
                    'value' => 20,
                    'color' => "rgb(41,171,164)",
                    'label' => "Equity"
                ],
                [
                    'value' => 30,
                    'color' => "rgb(235,114,96)",
                    'label' => "Debt"
                ],
                [
                    'value' => 50,
                    'color' => "rgb(58,154,217)",
                    'label' => "Assets"
                ]
            ]
        ]);
        ?>
    </div>
    
    <!-- Income -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
       <h2 class="text-center">Profits &amp; Losses</h2>
       
        <?= ChartJs::widget([
            'type' => 'Line',
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
                        'fillColor' => "rgb(254,254,254)",
                        'strokeColor' => "rgb(235,114,96)",
                        'data' => [0, -48, -40, -19, -96, -27, -100]
                    ],
                    [
                        'fillColor' => "rgba(41,171,164,0.5)",
                        'strokeColor' => "rgb(41,171,164)",
                        'data' => [0, 59, 90, 81, 56, 55, 90]
                    ],
                    [
                        'fillColor' => "rgba(58,154,217,0.5)",
                        'strokeColor' => "rgb(58,154,217)",
                        'data' => [0, 5, 4, 10, 20, 27, 50]
                    ]
                ]
            ]
        ]);
        ?>
    </div>
    
    <!-- Cash Flow -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <h2 class="text-center">Cash Flow</h2>
        
        
    </div>
    
</div>