<h1>Current Value= <?= $value ?></h1>

<div class="row">
    <div class="col-lg-12">
        <h1>Multiple currencies histo valued</h1>
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Date vs Currencies</th>
                <?php foreach($currencies as $cur) : ?>
                <th><?= $cur ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>    
        <tbody>
            <?php foreach($histos as $date => $vals) : ?>
            <tr>
                <td><?= $date ?></td>
                <?php foreach($currencies as $cur) : ?>
                <td><?= $vals[$cur] ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>


<div class="row">
    
    <div class="col-lg-6">
        <h1>Related Transactions</h1>
        <table class="table table-striped">
            <tbody>
            <?php foreach($trans as $t) : ?>
            <tr>
                <td><?= $t->date_value ?></td>
                <td><?= $t->value ?></td>
                <td><?php var_dump($t->accountDebit); ?></td>
                <td><?php var_dump($t->transactionForex); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php var_dump($trans); ?>