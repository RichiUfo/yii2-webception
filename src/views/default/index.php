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
    <?php foreach($sites as $site) : ?>
        <table class="table table-striped">
            <tr>
                <th colspan="2"><?= $site->name ?></th>
                <th><button class="btn btn-default btn-xs" type="submit">Run All</button></th>
            </tr>
            <?php foreach($site->tests as $test) : ?>
                <tr>
                    <td><span class="label label-primary"><?= $test->type ?></span><?= $test->title ?></td>
                    <td><?= $test->state ?></td>
                    <td><button class="btn btn-default btn-xs" type="submit">Run</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
    
</div>