<h1 class="text-center">Historical Account Value </h1>



<div class="row">
    <div class="col-lg-12">
        <h1>Related Transactions</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID #</th>
                    <th>Date</th>
                    <th>Transaction</th> 
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Account Forex</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($trans as $t) : ?>
                <tr>
                    <td><?= $t->id ?></td>
                    <td><?= $t->date_value ?></td>
                    <td><?= $t->name ?></td>
                    <td><?= $t->valueCredit ?> <?= $t->accountCredit->currency ?></td>
                    <td><?= $t->valueDebit ?> <?= $t->accountDebit->currency ?></td>
                    <td><?= ($t->accountForex)? $t->accountForex->id : '' ?><?php var_dump($t->debug) ?></td> 
                </tr>
            <?php endforeach; ?> 
            </tbody>
        </table>
    </div>
</div>