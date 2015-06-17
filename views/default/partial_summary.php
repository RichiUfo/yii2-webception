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
    </div>
    
    <!-- Cash Flow -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <h2 class="text-center">Cash Flow</h2>
        <?= ChartJs::widget([
            'type' => 'Radar', 
            'options' => [ 
                'height' => 270, 
                'width' => 270 
                ], 
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