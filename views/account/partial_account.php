<div id="account-display">
    
    <div class="container-fluid">
        <div class="row">
            <!-- Account Summary -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 account-overview">
                <h2>Overview</h2>
                
                <!--div class="row overview-row movements">
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="?= $movements['past_debits'] ?" currency="" decimal="2"></span>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="?= $movements['past_credits'] ?" currency="" decimal="2"></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-total">
                        <div class="data-block">
                            <span class="data-block-value money" value="?= $movements['past_debits'] + $movements['past_credits'] ?" currency="" decimal="2"></span>
                        </div>
                    </div>
                </div-->
                
                <div class="row overview-row balances">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['opening_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Opening</span>
                        </div>
                        <div class="icon-container">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <svg height="50" width="1" style="position:absolute;right:0;bottom:0;height:50%;z-index:1">
                            <line x1="0" y1="0" x2="0" y2="49" style="stroke:rgb(231,234,236);stroke-width:1" />
                        </svg>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['current_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Current</span>
                        </div>
                        <div class="icon-container">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <svg height="50" width="1" style="position:absolute;right:0;bottom:0;height:50%;z-index:1">
                            <line x1="0" y1="0" x2="0" y2="49" style="stroke:rgb(231,234,236);stroke-width:1" />
                        </svg>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['closing_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Closing</span>
                        </div>
                    </div>
                </div>
                
                <div class="row overview-row movements">
                    <div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="movements-container">
                            content
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="movements-container">
                            content
                        </div>
                    </div>
                </div>
                
                <!--div class="row overview-row movements">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-total">
                        <div class="data-block">
                            <span class="data-block-value money" value="?= $movements['future_debits'] + $movements['future_credits'] ?" currency="" decimal="2"></span>
                            <span class="data-block-title">Future Movements</span>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="?= $movements['future_debits'] ?" currency="" decimal="2"></span>
                            <span class="data-block-title">Debits</span>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="?= $movements['future_credits'] ?" currency="" decimal="2"></span>
                            <span class="data-block-title">Credits</span>
                        </div>
                    </div>
                </div-->
            </div>
            
            <!-- Children -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <h2>Sub-Accounts</h2>
                <table style="width: 100%">
                    <?php foreach($account->children as $child) : ?>
                    <tr>
                        <td><?= $child->name ?></td>
                        <td class="text-right">
                            <span class="money" 
                                  value="<?= $child->sign*$child->value_converted ?>" 
                                  currency=""></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-12">
                <h2>Transaction</h2>
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
                            <td class="text-right"><span class="money" value="0" currency=""></span></td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>