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

<!-- MAIN CONTENT -->
<div class="fp-acc-page">    
    <div id="accounting-summary-container" class="content"></div>
</div>

<!-- JAVASCRIPT -->
<?php $this->registerJs("acc_sum_init()", $this::POS_READY); ?>
