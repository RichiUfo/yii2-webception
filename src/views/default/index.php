<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

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

<div class="godardth-webception">
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
                <button class="btn btn-default run-all" type="submit"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
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
    
    <?php 
        $sitecounter = 0;
        foreach($sites as $site) : 
            $sitecounter++;
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h3>
                <?= $site->name ?>
                <button class="btn btn-default btn-xs pull-right run-site" 
                        site="site<?= $sitecounter ?>"
                        type="submit"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
            </h3>
        </div>
        <?php
        $types = ['acceptance', 'functional', 'unit'];
        foreach($types as $type) :
        ?>
        <div class="col-lg-4">
            <table class="table table-condensed table-tests">
                    <thead>
                        <tr>
                            <th>
                            <?= $type ?> 
                            <?php if(!$site->logging['passed']) : ?>
                                <button type="button" class="btn btn-danger disabled btn-xs">Logging</button>
                            <?php endif; ?>
                            </th>
                            <th>
                                <button class="btn btn-default btn-xs pull-right run-type" 
                                site="site<?= $sitecounter ?>"
                                type="<?= $type ?>"
                                type="submit"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="site<?= $sitecounter ?>">
                        <?php 
                        foreach($site->tests as $test) : 
                        if ($test->type === $type) :
                        ?>
                            <tr id="<?= $test->hash ?>" class="<?= $test->type ?>">
                                <td><!--?= genLabel($test->type) ?--><?= $test->title ?></td>
                                <td>
                                    <div class="pull-right">
                                        <div class="btn-group btn-group-xs pull-right" role="group">
                                            <button class="btn btn-primary status disabled" 
                                                    type="submit">Ready</button>
                                            <button class="btn btn-default view-log disabled" 
                                                    hash="<?= $test->hash ?>"
                                                    type="submit"><span class="glyphicon glyphicon-console" aria-hidden="true"></span></button>
                                            <button class="btn btn-default run-test" 
                                                    hash="<?= $test->hash ?>"
                                                    type="submit"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                                            <button class="btn btn-default reset-test" 
                                                    hash="<?= $test->hash ?>"
                                                    type="submit"
                                                    style="display:none"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php Modal::begin([
                                'id' => 'modal-'.$test->hash,
                                'header' => $test->title,
                                'size' => Modal::SIZE_LARGE
                            ]) ?>
                            <pre class="test-log <?= $test->hash ?>"></pre>
                            <?php Modal::end() ?>
                        <?php 
                        endif;
                        endforeach; 
                        ?>
                    </tbody>
            </table>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    
    
    
</div>