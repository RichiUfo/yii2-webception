<div id="account-display">
    
    <div class="container-fluid">
        <div class="row">
            <!-- Account Summary -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <h2>Overview</h2>
                <p>Value <span class="money" value="<?= $account->sign *$account->value_converted ?>" currency=""></span></p>
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