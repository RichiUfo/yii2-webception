<?php
use dosamigos\chartjs\ChartJs;
?>


<!-- Disabled by removing the echo -->
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