<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\web\View;

use frontend\widgets\editable\Editable;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);
?>

<!-- Account Name Edition -->
<?= Editable::widget([
    'identifier' => $account->account->id,
    'text' => $account->account->alias,
    'property' => 'alias',
    'default' => $account->account->name,
    'action' => '/accounting/rest/account/rename',    
]); ?>

