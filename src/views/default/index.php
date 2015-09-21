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
        Software Testing Interface
        <div class="pull-right">
            <div class="btn-group btn-group-xs" role="group">
                <button type="button" class="btn btn-<?= $checks['configuration'] ? 'success' : 'danger' ?>" disabled>Configuration</button>
                <button type="button" class="btn btn-<?= $checks['executable']['passed'] ? 'success' : 'danger' ?>" disabled>Executable</button>
                <button type="button" class="btn btn-<?= $checks['logging'] ? 'success' : 'danger' ?>" disabled>Writeable</button>
            </div>
            
            <!-- GLOBAL COVERAGE TO BE IMPLEMENTED LATER --
            <div class="btn-group btn-group-xs" role="group">
                <button type="button" class="btn btn-default disabled">Coverage</button>
                <button type="button" class="btn btn-warning disabled">45 %</button>
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
            </div>
            --> 
            
            <div class="btn-group btn-group-xs" role="group">
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
    <div class="row site">
        <div class="col-lg-12">
            <h3>
                <span class="test-site-name"><?= $site->name ?></span>
                
                <div class="pull-right">
                    <div class="btn-group btn-group-xs coverage-site" role="group">
                        <button type="button" class="btn btn-default" disabled>Coverage</button>
                        <button type="button" class="btn btn-default coverage-value" disabled>- %</button>
                        <button type="button" class="btn btn-default btn-refresh-coverage"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                        <button type="button" class="btn btn-default btn-view-coverage" disabled><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></button> 
                    </div>
                    
                    <button class="btn btn-default btn-xs run-site" 
                            site="site<?= $sitecounter ?>"
                            type="submit"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                </div>
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
                                            <button class="btn btn-primary status" 
                                                    disabled
                                                    type="submit">Ready</button>
                                            <button class="btn btn-default view-log"
                                                    disabled
                                                    hash="<?= $test->hash ?>"
                                                    type="submit"><span class="glyphicon glyphicon-console" aria-hidden="true"></span></button>
                                            <button class="btn btn-default run-test" 
                                                    hash="<?= $test->hash ?>"
                                                    type="submit"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php Modal::begin([
                                'id' => 'modal-'.$test->hash,
                                'header' => $site->name.' - '.$test->type.' - '.$test->title,
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