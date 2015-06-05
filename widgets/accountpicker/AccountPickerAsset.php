<?php

namespace frontend\modules\accounting\widgets\accountpicker;

/**
 * @author Theophile Godard <theo.godard@gmail.com>
 * @since 2.0
 */
class AccountPickerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/accounting/widgets/accountpicker/assets';
    
    public $css = [
        'style/accountpicker.css',
    ];
    public $js = [
        'js/accountpicker.js',
    ];
    public $depends = [
        'frontend\assets\ThemeBaseAsset',
        'yii\angularjs\AngularAsset',
    ];
}