<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\web\View;

use frontend\modules\accounting\widgets\editable\Editable;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<?= Editable::widget([
    'text' => $account->account->alias,
]); ?>

<?php var_dump($account->account); ?>
