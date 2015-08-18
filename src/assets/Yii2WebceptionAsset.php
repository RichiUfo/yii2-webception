<?php
/**
 * @link http://www.fullplanner.com/
 * @copyright Copyright (c) 20015 Theophile Godard
 */

namespace godardth\yii2webception\assets;

use yii\web\AssetBundle;

/**
 * @author Theophile Godard <theo.godard@gmail.com>
 */
class Yii2WebceptionAsset extends AssetBundle
{
    public $sourcePath = '@vendor/godardth/yii2-webception/src/assets';
    
    public $css = [
        'stylesheets/stylesheets/screen.css',
    ];
    public $js = [
        'javascript/yii2-webception.js',
    ];
    public $depends = [
    ];
}