<?php
use yii\helpers\Html;
use yii\helpers\Url;

use godardth\yii2webception\models\Site;

use godardth\yii2webception\assets\Yii2WebceptionAsset;
Yii2WebceptionAsset::register($this);
?>

<div class="container">
    <h1>Webception</h1>
    <h2>Test Sites</h2>
    <?= $ready?'Ready':'Not Ready'; ?><br>
    Test count : <?= $test_count ?><br><br>
    codeception object : <br> <?php var_dump($codeception); ?>
    
    <br><br> Available Sites <br>
    <?php var_dump($sites); ?>
</div>