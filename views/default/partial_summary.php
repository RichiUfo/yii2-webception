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
                'percentageInnerCutout' => 50,
                'animationSteps' => 20,
                'animationEasing' => "swing",
                'animateRotate' => false,
                'animateScale' => true,
                //'legendTemplate' => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>
            ],
            'data' => [
                [
                    'value' => 20,
                    'color' => "rgb(41,171,164)",
                    'highlight' => "#FF5A5E",
                    'label' => "Equity"
                ],
                [
                    'value' => 30,
                    'color' => "rgb(235,114,96)",
                    'highlight' => "#5AD3D1",
                    'label' => "Debt"
                ],
                [
                    'value' => 50,
                    'color' => "rgb(58,154,217)",
                    'highlight' => "#FFC870",
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
                        'fillColor' => "rgba(200,255,200,0.5)",
                        'strokeColor' => "rgba(220,220,220,1)",
                        'pointColor' => "rgba(220,220,220,1)",
                        'pointStrokeColor' => "#fff",
                        'data' => [0, 59, 90, 81, 56, 55, 90]
                    ],
                    [
                        'fillColor' => "rgba(205,107,105,0.7)",
                        'strokeColor' => "rgba(255,187,205,1)",
                        'pointColor' => "rgba(151,187,205,1)",
                        'pointStrokeColor' => "#fff",
                        'data' => [0, -48, -40, -19, -96, -27, -100]
                    ],
                    [
                        'fillColor' => "rgba(151,187,205,0.7)",
                        'strokeColor' => "rgba(151,187,205,1)",
                        'pointColor' => "rgba(151,187,205,1)",
                        'pointStrokeColor' => "#fff",
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
        <?= ChartJs::widget([
            'type' => 'Radar', 
            'clientOptions' => [
                'responsive' => true,
                'showTooltips' => false,
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
        ]); ?>
        
    </div>
    
</div>