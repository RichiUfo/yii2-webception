<?php
/**
 * @link http://www.fullplanner.com/
 * @copyright Copyright (c) 20015 Theophile Godard
 */

namespace frontend\modules\accounting\assets;

use yii\web\AssetBundle;

/**
 * @author Theophile Godard <theo.godard@gmail.com>
 */
class BaseAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/accounting/assets';
    
    public $css = [
        'stylesheets/stylesheets/screen.css',
    ];
    public $js = [
        'js/module_name.js',
    ];
    public $depends = [
        'frontend\assets\ThemeBaseAsset',
    ];
}