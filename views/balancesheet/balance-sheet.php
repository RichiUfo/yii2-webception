<?php

use yii\helpers\Url;
use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function displayHierarchy($accounts){
    
    $system_currency = \Yii::$app->user->identity->acc_currency;
    
    echo '<ul class="text-left">';
    foreach ($accounts as $account){
        
        $currency = ($system_currency != $account->currency)?'&nbsp('.$account->currency.')':'';
        
        echo '<li>
                <a href="'.Url::to(['account/display', 'id' => $account->id]).'">';
        echo $account->alias.$currency.'</a>
                <span class="pull-right">
                    <span class="money" 
                          value="'.$account->sign*$account->value_converted.'" 
                          currency="'.'">
                    </span>
                </span>
            </li>';

        if($account->children != null){
            displayHierarchy($account->children);
        }
    }
    echo '</ul>';
}

?>

<!-- LEFT PANEL -->
<?php $this->render('@app/views/partials/left_panel', [
    'back_button' => $back_button,
    'left_menus' => $left_menus
]); ?>

<!-- MAIN CONTENT -->
<h2 class="text-center">Balance Sheet</h2>

<div id="balance-sheet" class="row">
    <div class="col-lg-6">
        
        <!-- ASSETS -->
        <div class="card informative-block transparent">
            <div class="card-header">
                <div class="banner-title">
                    <p><a href="<?php echo Url::to(['account/display', 'id' => $assets->id]) ?>"><?= $assets->alias ?></a></p>
                </div>
                <div class="banner-subtitle">
                    <p>
                        <span class="money" 
                              value="<?= $assets->sign*$assets->value_converted ?>" 
                              currency="<?= $assets->currency ?>&nbsp;">
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-content">
                <?php displayHierarchy($assets->children); ?>
            </div>
        </div>
        <!-- END OF ASSETS -->
        
    </div>    

    <div class="col-lg-6">
        
        <!-- EQUITY -->
        <div class="card informative-block transparent">
            <div class="card-header">
                <div class="banner-title">
                    <p><a href="<?php echo Url::to(['account/display', 'id' => $equity->id]) ?>"><?= $equity->alias ?></a></p>
                </div>
                <div class="banner-subtitle">
                    <p>
                        <span class="money" 
                              value="<?= $equity->sign*$equity->value_converted ?>" 
                              currency="<?= $equity->currency ?>&nbsp;">
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-content">
                <?php displayHierarchy($equity->children); ?>
            </div>
        </div>
        <!-- END OF EQUITY -->
        
        <!-- LIABILITIES -->
        <div class="card informative-block transparent">
            <div class="card-header">
                <div class="banner-title">
                    <p><a href="<?php echo Url::to(['account/display', 'id' => $liabilities->id]) ?>"><?= $liabilities->alias ?></a></p>
                </div>
                <div class="banner-subtitle">
                    <p>
                        <span class="money" 
                              value="<?= $liabilities->sign*$liabilities->value_converted ?>" 
                              currency="<?= $liabilities->currency ?>&nbsp;">
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-content">
                <?php displayHierarchy($liabilities->children); ?>
            </div>
        </div>
        <!-- END OF LIABILITIES -->
        
    </div>
</div>