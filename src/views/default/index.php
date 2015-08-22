<?php
use yii\helpers\Html;
use yii\helpers\Url;

use godardth\yii2webception\assets\Yii2WebceptionAsset;
Yii2WebceptionAsset::register($this);

/**
 * Generating labels for different test types
 */
function genLabel($type){
    switch ($type) {
    case 'acceptance':
        $ret = '<span class="label label-primary">A</span>';
        break;
    case 'functional':
        $ret = '<span class="label label-info">F</span>';
        break;
    case 'unit':
        $ret = '<span class="label label-warning">U</span>';
        break;
    default:
        $ret = '<span class="label label-default">?</span>';
    }
    return $ret;
}

?>

<div class="container godardth-webception">
    <h1>
        Webception
        <div class="pull-right">
            <div class="btn-group btn-group-xs" role="group">
                <button type="button" class="btn btn-<?= $checks['configuration'] ? 'success' : 'danger' ?> disabled">Configuration</button>
                <button type="button" class="btn btn-<?= $checks['executable']['passed'] ? 'success' : 'danger' ?> disabled">Executable</button>
                <button type="button" class="btn btn-<?= $checks['logging'] ? 'success' : 'danger' ?> disabled">Writeable</button>
            </div>
            
            <div class="btn-group btn-group-xs" role="group" style="margin-left:25px">
                <button class="btn btn-default reset-all" type="submit">Reset All</button>
                <button class="btn btn-default run-all" type="submit">Run All</button>
            </div>
        </div>
    </h1>
    
    <!-- Error -->
    <?php if (!$checks['executable']['passed']) : ?>
        <pre><samp>
            <?= $checks['executable']['error'] ?>
        </samp></pre>
    <?php endif; ?>
    
    <!-- Check the codeception initialization -->
    <!-- List the available sites and tests for each of them -->
    <table class="table table-condensed table-tests">
        <?php 
        $sitecounter = 0;
        foreach($sites as $site) : 
            $sitecounter++;
        ?>
            <thead>
                <tr>
                    <th><?= $site->name ?> 
                    <?php if(!$site->logging['passed']) : ?>
                        <button type="button" class="btn btn-danger disabled btn-xs">Logging</button>
                    <?php endif; ?>
                    </th>
                    <th>
                        <button class="btn btn-default btn-xs pull-right run-site" 
                        site="site<?= $sitecounter ?>"
                        type="submit">Run All</button>
                    </th>
                </tr>
            </thead>
            <tbody id="site<?= $sitecounter ?>">
                <?php foreach($site->tests as $test) : ?>
                    <tr id="<?= $test->hash ?>">
                        <td><?= genLabel($test->type) ?> <?= $test->title ?></td>
                        <td>
                            <div class="btn-group btn-group-xs pull-" role="group">
                                <button class="btn btn-primary status disabled" 
                                        type="submit">Ready</button>
                                <button class="btn btn-default run-test" 
                                        hash="<?= $test->hash ?>"
                                        type="submit">Run</button>
                                <button class="btn btn-default reset-test" 
                                        hash="<?= $test->hash ?>"
                                        type="submit"
                                        style="display:none">Reset</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="test-log <?= $test->hash ?>" style="display:none"> 
                        <td colspan="2">
                           <pre></pre>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <?php endforeach; ?>
    </table>
    
</div>