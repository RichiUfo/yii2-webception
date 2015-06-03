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

<!-- Account Name Edition -->
<?= Editable::widget([
    'identifer' => $account->account->id,
    'text' => $account->account->alias,
    'property' => 'alias',
    'default' => $account->account->name,
    'action' => '/accounting/rest/account/rename',    
]); ?>

