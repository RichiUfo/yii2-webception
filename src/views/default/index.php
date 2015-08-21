<?php
use yii\helpers\Html;
use yii\helpers\Url;

use godardth\yii2webception\assets\Yii2WebceptionAsset;
Yii2WebceptionAsset::register($this);
?>

<div class="container">
    <h1>
        Webception
        
        <div class="btn-group btn-group-xs" role="group" aria-label="">
            <button type="button" class="btn btn-<?= $checks['configuration'] ? 'success' : 'danger' ?> disabled">Configuration</button>
            <button type="button" class="btn btn-<?= $checks['executable']['passed'] ? 'success' : 'danger' ?> disabled">Executable</button>
            <button type="button" class="btn btn-<?= $checks['logging'] ? 'success' : 'danger' ?> disabled">Writeable</button>
        </div>
        
        <button class="btn btn-default btn-xs pull-right" type="submit">Run All</button>
    </h1>
    
    <!-- Error -->
    <?php if (!$checks['executable']['passed']) : ?>
        <pre><samp>
            <?= $checks['executable']['error'] ?>
        </samp></pre>
    <?php endif; ?>
    
    <!-- Check the codeception initialization -->
    <!-- List the available sites and tests for each of them -->
    <table class="table table-striped">
        <?php foreach($sites as $site) : ?>
            <tr>
                <th colspan="2"><?= $site->name ?> 
                <?php if(!$site->logging['passed']) : ?>
                    <button type="button" class="btn btn-danger disabled btn-xs">Logging</button>
                <?php endif; ?>
                </th>
                <th><button class="btn btn-default btn-xs pull-right" type="submit">Run All</button></th>
            </tr>
            <?php foreach($site->tests as $test) : ?>
                <tr id="<?= $test->hash ?>">
                    <td><span class="label label-primary"><?= $test->type ?></span> <?= $test->title ?></td>
                    <td><span class="status label label-primary"><?= $test->state ?></span></td>
                    <td>
                        <button class="btn btn-default btn-xs pull-right run-test" 
                                hash="<?= $test->hash ?>"
                                type="submit">Run</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
    
</div>