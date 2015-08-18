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
class BaseAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/accounting/assets';
    
    public $css = [
        'stylesheets/stylesheets/screen.css',
    ];
    public $js = [
        'javascript/module_accounting.js',
		'javascript/accounting_transaction_create.js',
		'javascript/accounting_account_create.js',
    ];
    public $depends = [
		'frontend\assets\angular\AngularAsset',
		'frontend\assets\angularaccounting\AngularAccountingAsset',
        'frontend\assets\ThemeBaseAsset',
    ];
}