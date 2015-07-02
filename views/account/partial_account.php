<div id="account-display">
    
    <div class="container-fluid">
        <div class="row">
            <!-- Account Summary -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 account-overview">
                <h2>Overview</h2>
                
                <div class="row movements">
                    <div class="col-lg-4">&nbsp;</div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                </div>
                <div class="row balances">
                    <div class="col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['opening_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Opening</span>
                        </div>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                    <div class="col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['current_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Today</span>
                        </div>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                    <div class="col-lg-4">
                        <div class="data-block">
                            <span class="data-block-value money" value="<?= $account->sign*$movements['closing_balance'] ?>" currency="" decimal="2"></span>
                            <span class="data-block-title">Closing</span>
                        </div>
                    </div>
                </div>
                <div class="row movements">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                </div>
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