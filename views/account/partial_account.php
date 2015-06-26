<div id="account-display">
    
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
            <div id="account-transactions-ajax" accountid="<?= $account->id ?>" class="col-lg-12">
                
            </div>
        </div>
    </div>
</div>