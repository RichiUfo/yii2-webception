<?php
use yii\helpers\Html;
use yii\helpers\Url;

use godardth\yii2webception\assets\Yii2WebceptionAsset;
Yii2WebceptionAsset::register($this);
?>

<div class="container">
    <h1>Webception</h1>
    
    <!-- Check the codeception initialization -->
    
    <!-- List the available sites and tests for each of them -->
    <br><br> Available Sites <br>
    <ul>
    <?php foreach($sites as $site) : ?>
        <li><?= $site->name ?></li>
        <ul>
            <?php foreach($site->tests as $test) : ?>
                <li><?= $test->title ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
    </ul>
    
</div>