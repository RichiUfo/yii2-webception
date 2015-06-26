<div id="account-display" accountid="<?= $account->id ?>">
    
    <div class="container-fluid">
        <div class="row">
            <!-- Account Summary -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <h2>Overview</h2>
                <p>Value <span class="money" value="<?= $account->sign *$account->value_converted ?>" currency=""></span></p>
            </div>
            
            <!-- Movements -->
            <div id="movements-summary-ajax" class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <h2>Movements</h2>
                <table style="width: 100%">
                    <tr>
                        <td>Opening Balance</td>
                        <td class="text-right">
                            <span class="money" value="<?= $account->sign*$movements['opening_balance'] ?>" currency=""></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Debits</td>
                        <td class="text-right">
                            <span class="money" value="<?= $movements['passed_debits'] ?>" currency=""></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Credits</td>
                        <td class="text-right">
                            <span class="money" value="<?= $movements['passed_credits'] ?>" currency=""></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Current Balance</td>
                        <td class="text-right">
                            <span class="money" value="<?= $account->sign*$movements['current_balance'] ?>" currency=""></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Future Debits</td>
                        <td class="text-right">
                            <span class="money" value="<?= $movements['future_debits'] ?>" currency=""></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Future Credits</td>
                        <td class="text-right">
                            <span class="money" value="<?= $movements['future_credits'] ?>" currency=""></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Closing Balance</td>
                        <td class="text-right">
                            <span class="money" value="<?= $account->sign*$movements['closing_balance'] ?>" currency=""></span>
                        </td>
                    </tr>
                </table>
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
                <?php 
                    $start_dt = new \DateTime($start);
                    $end_dt = new \DateTime($end);
                    $period = ''; //$start_dt->format('M j, Y').' - '.$end_dt->format('M j, Y'); 
                ?>
                <h2>Transaction <small><?= $period ?></small></h2>
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
                            <td class="text-right"><?= $t->valueDebit ?> <?= $t->accountDebit->currency ?></td>
                            <td class="text-right"><?= $t->valueCredit ?> <?= $t->accountCredit->currency ?></td>
                            <td class="text-right"><span class="money" value="0" currency=""></span></td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>