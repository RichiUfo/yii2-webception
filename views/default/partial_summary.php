<?php
use dosamigos\chartjs\ChartJs;
?>

<div class="row">
    
    <!-- Balance Sheet -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <h2 class="text-center">Balance Sheet</h2>
        
    </div>
    
    <!-- Income -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
       <h2 class="text-center">Profits &amp; Losses</h2>
       <?= ChartJs::widget([
            'type' => 'Line',
            'clientOptions' => [
                'scaleShowGridLines' => false,
                'scaleShowLabels' => false,
                'responsive' => true,
                'showTooltips' => false,
            ],
            'data' => [
                'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                'datasets' => [
                    [
                        'fillColor' => "rgba(220,220,220,0.5)",
                        'strokeColor' => "rgba(220,220,220,1)",
                        'pointColor' => "rgba(220,220,220,1)",
                        'pointStrokeColor' => "#fff",
                        'data' => [65, 59, 90, 81, 56, 55, 40]
                    ],
                    [
                        'fillColor' => "rgba(151,187,205,0.5)",
                        'strokeColor' => "rgba(151,187,205,1)",
                        'pointColor' => "rgba(151,187,205,1)",
                        'pointStrokeColor' => "#fff",
                        'data' => [28, 48, 40, 19, 96, 27, 100]
                    ]
                ]
            ]
        ]);
        ?>
    </div>
    
    <!-- Cash Flow -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <h2 class="text-center">Cash Flow</h2>
        <?= ChartJs::widget([
            'type' => 'Radar', 
            'data' => [
                'labels' => ["Cash", "Savings", "Investments", "Equipments", "Real Estate", "Land"],
                'datasets' => [
                    [
                        'label' => "Assets Allocation",
                        'fillColor' => "rgba(26,179,148,0.2)",
                        'strokeColor' => "rgba(26,179,148,1)",
                        'pointColor' => "rgba(26,179,148,1)",
                        'pointStrokeColor' => "#fff",
                        'pointHighlightFill' => "#fff",
                        'pointHighlightStroke' => "rgba(151,187,205,1)",
                        'data' => [65, 59, 90, 81, 56, 55]
                    ]
                ]
            ]
        ]); 
        ?>
    </div>
    
</div>