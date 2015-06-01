<?php

namespace frontend\modules\accounting\widgets\editable;

/**
 * @author Theophile Godard <theo.godard@gmail.com>
 * @since 2.0
 */
class EditableAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/accounting/widgets/editable/assets';
    
    public $css = [
        'stylesheets/editable.css',
    ];
    public $js = [
        'js/editable.js',
    ];
    public $depends = [
        'frontend\assets\ThemeBaseAsset',
    ];
}