<?php
use yii\helpers\Url;
?>

<div id="account-display">
    
    <div class="container-fluid">
        <div class="row">
            <!-- Account Summary -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 account-overview">
                <h2>Overview</h2>
                
                <div class="row overview-row balances">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['opening_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Opening</span>
                        </div>
                        <div class="movements-container"> 
                            <div class="icon-container up">
                                <i class="material-icons">trending_up</i>
                            </div>
                            <span class="data-block-value money" value="<?= $account->sign*($movements['past_credits'] - $movements['past_debits']) ?>" currency="" decimal="2"></span><br>
                            <span class="data-block-value money" value="<?= $movements['past_debits'] ?>" currency="" decimal="2"></span><br>
                            <span class="data-block-value money" value="<?= $movements['past_credits'] ?>" currency="" decimal="2"></span>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['current_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Current</span>
                        </div>
                        <div class="movements-container"> 
                            <div class="icon-container down">
                                <i class="material-icons">trending_down</i>
                            </div>
                            <span class="data-block-value money" value="<?= $account->sign*($movements['future_credits'] - $movements['future_debits']) ?>" currency="" decimal="2"></span><br>
                            <span class="data-block-value money" value="<?= $movements['future_debits'] ?>" currency="" decimal="2"></span><br>
                            <span class="data-block-value money" value="<?= $movements['future_credits'] ?>" currency="" decimal="2"></span>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['closing_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Closing</span>
                        </div>
                    </div>
                </div>
                
                <!--div class="row overview-row movements">
                    <div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="movements-container green">
                            <div class="title">
                                <span class="data-block-value money" value="?= $account->sign*($movements['past_credits'] - $movements['past_debits']) ?>" currency="" decimal="2"></span>
                            </div>
                            <span class="data-block-value money" value="?= $movements['past_debits'] ?>" currency="" decimal="2"></span><br>
                            <span class="data-block-value money" value="?= $movements['past_credits'] ?>" currency="" decimal="2"></span>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="movements-container red">
                            <div class="title">
                                <span class="data-block-value money" value="?= $account->sign*($movements['future_credits'] - $movements['future_debits']) ?>" currency="" decimal="2"></span>
                            </div>
                            <span class="data-block-value money" value="?= $movements['future_debits'] ?>" currency="" decimal="2"></span><br>
                            <span class="data-block-value money" value="?= $movements['future_credits'] ?>" currency="" decimal="2"></span>
                        </div>
                    </div>
                </div-->
                
            </div>
            
            <!-- Children -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <h2>Composition</h2>
                <ul class="composition list-group clear-list m-t">
                    <?php 
                    $first = "fist-item";
                    foreach($account->children as $child) : 
                    ?>
                        <li class="list-group-item <?= $first ?>">
                            
                            <!-- First Line -->
                            <a href="<?= Url::to(['account/display', 'id' => $child->id]) ?>"><span class="first-line"><?= $child->alias ?></span></a>
                            <span   class="first-line pull-right money" 
                                    value="<?= $child->sign*$child->value_converted ?>" 
                                    currency=""></span>
                            <br>
                            
                            <!-- Second Line -->
                            <small>
                                <?php if($child->currency !== $account->currency) : ?>
                                <span>Foreign Currency Account</span>
                                <span class="pull-right"><?= $child->currency ?> <span class="money" 
                                          value="<?= $child->sign*$child->value ?>" 
                                          currency=""></span></span>
                                <?php else : ?>
                                <span>Regular Account</span>
                                <?php endif; ?>
                            </small>
                                
                        </li>
                    <?php 
                    $first = "";
                    endforeach; 
                    ?>
                </ul>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-12">
                <h2>Transactions</h2>
                <table class="table table-striped table-no-margin">
                    <thead>
                        <tr>
                            <th class="text-left">Date</th>
                            <th class="text-left">Transaction</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                            <th class="text-right">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <!-- Transactions Items -->
                        <?php foreach ($transactions as $t) : ?>
                        <tr>
                            <td class="text-left"><span class="date" datetime="<?= $t->date_value ?>"></span></td>
                            <td class="text-left"><?= $t->name ?></td>
                            <td class="text-right">
                                <?php if($t->valueDebit !== 0) : ?>
                                    <span class="money" value="<?= $t->valueDebit ?>" currency=""></span> <?= $t->accountDebit->currency ?>
                                <?php endif ?>
                            </td>
                            <td class="text-right">
                                <?php if($t->valueCredit !== 0) : ?>
                                    <span class="money" value="<?= $t->valueCredit ?>" currency=""></span> <?= $t->accountCredit->currency ?>
                                <?php endif ?>
                            </td>
                            <td class="text-right"><span class="money" value="<?= $account->sign * $t->updatedBalance ?>" currency=""></span></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <!-- Opening Balance -->
                        <tr>
                            <td class="text-left"><span class="date" datetime="<?= $start ?>"></span></td>
                            <td class="text-right">Opening Balance</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"><span class="money" value="<?= $account->sign*$movements['opening_balance'] ?>" currency=""></span></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>