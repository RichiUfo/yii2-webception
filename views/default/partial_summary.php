<div class="row">
    
    <!-- Balance Sheet -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="card informative-block transparent">
            <div class="card-header">
                <div class="banner-title h2 text-center">
                    Balance Sheet
                    <!--p>
                        <i class="fa fa-pie-chart"></i>
                        <a href="?= yii\helpers\Url::toRoute('/accounting/balancesheet') ?">Balance Sheet</a>
                    </p-->
                </div>
                <div class="banner-subtitle">
                    <p></p>
                </div>
            </div>
            <div class="card-content">
                <?= $start ?><br><?= $end ?>
            </div>
        </div>
    </div>
    
    <!-- Income -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="card informative-block transparent">
            <div class="card-header">
                <div class="banner-title">
                    <p> 
                        <i class="fa fa-pie-chart"></i>
                        <a href="<?= yii\helpers\Url::toRoute('/accounting/balancesheet') ?>">Profits &amp; Losses</a>
                    </p>
                </div>
                <div class="banner-subtitle">
                    <p></p>
                </div>
            </div>
            <div class="card-content">
                
            </div>
        </div>
    </div>
    
    <!-- Cash Flow -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="card informative-block transparent">
            <div class="card-header">
                <div class="banner-title">
                    <p>
                        <i class="fa fa-pie-chart"></i>
                        <a href="<?= yii\helpers\Url::toRoute('/accounting/balancesheet') ?>">Cash Flow</a>
                    </p>
                </div>
                <div class="banner-subtitle">
                    <p></p>
                </div>
            </div>
            <div class="card-content">
                
            </div>
        </div>
    </div>
    
</div>