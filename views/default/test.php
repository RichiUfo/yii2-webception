<h1 class="text-center">Historical Account Value </h1>

<div class="row">
    <div class="col-lg-12">
        <h1>Historical Values</h1>
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <?php foreach($currencies as $cur) : ?>
                <th><?= $cur ?></th>
                <?php endforeach; ?>
                <th>TOTAL</th>
            </tr>
        </thead>    
        <tbody>
            <?php foreach($histos as $date => $vals) : ?>
            <tr>
                <td><?= $date ?></td>
                <?php foreach($currencies as $cur) : ?>
                <td><?= $vals[$cur] ?></td>
                <?php endforeach; ?>
                <td><?= $vals['total'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>


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
                    <th>Forex</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($trans as $t) : ?>
                <tr>
                    <td><?= $t->id ?></td>
                    <td><?= $t->date_value ?></td>
                    <td><?= $t->name ?></td>
                    <td>
                        <?php
                        if($t->credit['isCredit'])
                            echo $t->credit['value'].' '.$t->credit['currency'];
                        ?>
                    </td>
                    <td>
                        <?php
                        if($t->debit['isDebit'])
                            echo $t->debit['value'].' '.$t->debit['currency'];
                        ?>
                    </td>
                    <td><?= ($t->transactionForex)?'FX':'' ?></td> 
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>