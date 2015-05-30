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
                <a href="'.Url::to(['account/account', 'id' => $account->id]).'">';
        //echo '<i class="fa fa-chevron-'.($account->children != null)?'down':'right'.'"></i>&nbsp;&nbsp;';
        echo $account->alias.$currency.'</a>
                <span class="pull-right">
                    <span class="money" 
                          value="'.$account->display_value.'" 
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
        <div class="card informative-block">
            <div class="card-header">
                <div class="banner-title">
                    <p><a href="<?php echo Url::to(['account/account', 'id' => $assets->id]) ?>"><?= $assets->alias ?></a></p>
                </div>
                <div class="banner-subtitle">
                    <p>
                        <span class="money" 
                              value="<?= $assets->display_value ?>" 
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
        <div class="card informative-block">
            <div class="card-header">
                <div class="banner-title">
                    <p><a href="<?php echo Url::to(['account/account', 'id' => $equity->id]) ?>"><?= $equity->alias ?></a></p>
                </div>
                <div class="banner-subtitle">
                    <p>
                        <span class="money" 
                              value="<?= $equity->display_value ?>" 
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
        <div class="card informative-block">
            <div class="card-header">
                <div class="banner-title">
                    <p><a href="<?php echo Url::to(['account/account', 'id' => $liabilities->id]) ?>"><?= $liabilities->alias ?></a></p>
                </div>
                <div class="banner-subtitle">
                    <p>
                        <span class="money" 
                              value="<?= $liabilities->display_value ?>" 
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