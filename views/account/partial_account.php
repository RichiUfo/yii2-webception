<div id="account-display">
    
    <div class="container-fluid">
        <div class="row">
            <div class="row-same-height row-full-height">
                <!-- Account Summary -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-sm-height col-full-height">
                    <div class="card informative-block">
                        <div class="card-header">
                            <div class="banner-title">
                                <p>Overview</p>
                            </div>
                            <div class="banner-subtitle">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-content">
                            Value <span class="money" value="<?= $account->sign *$account->value_converted ?>" currency=""></span><br>
                        </div>
                    </div>
                </div>
                
                <!-- Movements -->
                <div id="movements-summary-ajax" class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-sm-height col-full-height">
    
                </div>
                
                <!-- Children -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-sm-height col-full-height">
                    <div class="card informative-block">
                        <div class="card-header">
                            <div class="banner-title">
                                <p>Sub-Accounts</p>
                            </div>
                            <div class="banner-subtitle">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-content">
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
                </div>
            </div>
        </div>
    
        <div class="row">
            <div id="account-transactions-ajax" accountid="<?= $account->id ?>" class="col-lg-12">
                
            </div>
        </div>
    </div>
</div>