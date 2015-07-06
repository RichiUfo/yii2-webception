<?php

function displayHierarchy($accounts){
    
    echo '<ul class="text-left">';
    foreach ($accounts as $account){
        echo '<li>
                <a href="'.Url::to(['account/account', 'id' => $account->id]).'">'.$account->name.'</a>
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


<div id="profit-loss">
    <div class="row">
        <div class="col-lg-6">
            <!-- P&L SECTION -->
            <div class="godard-box">
                <div class="godard-box-header">
                    <div class="godard-box-icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="godard-box-title">
                        <h1>
                            <a href="">Operating Profit</a>
                            <span class="pull-right">
                                <span class="money" 
                                      value="<?= $operating_revenues->sign * $operating_revenues->value_converted ?>" 
                                      currency="<?= $operating_revenues->currency ?> ">
                                </span>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="godard-box-secondrow">
                    <div class="godard-box-filler">&nbsp;</div>
                    <div class="godard-box-content">

                        <div class="row">
                            <div class="row-same-height">
                                <div class="col-lg-12 col-same-height col-middle">
                                    <?php displayHierarchy(array($operating_revenues, $operating_expenses)); ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- BALANCE SHEET SECTION -->
            <div class="godard-box">
                <div class="godard-box-header">
                    <div class="godard-box-icon">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="godard-box-title">
                        <h1>
                            <a href="">Non-Operating Profit</a>
                            <span class="pull-right">
                                <span class="money" 
                                      value="<?= $non_operating_revenues->sign * $non_operating_revenues->value_converted ?>" 
                                      currency="<?= $non_operating_revenues->currency ?> ">
                                </span>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="godard-box-secondrow">
                    <div class="godard-box-filler">&nbsp;</div>
                    <div class="godard-box-content">

                        <div class="row">
                            <div class="row-same-height">
                                <div class="col-lg-12 col-same-height col-middle">
                                    <?php displayHierarchy(array($non_operating_revenues, $non_operating_expenses)); ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>