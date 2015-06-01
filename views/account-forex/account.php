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

use frontend\controllers\LocalizationController;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<?php var_dump($account->account); ?>
