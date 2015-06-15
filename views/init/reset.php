<h1>Accounts Deleted</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Owner ID</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($accounts as $a) : ?>
        <tr>
            <td><?= $a->id ?></td>
            <td><?= $a->owner_id ?></td>
            <td><?= $a->name ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h1>Forex Accounts Deleted</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Account ID</th>
            <th>Currency</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($accounts_forex as $a) : ?>
        <tr>
            <td><?= $a->id ?></td>
            <td><?= $a->account_id ?></td>
            <td><?= $a->forex_currency ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h1>Transactions Deleted</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($transactions as $t) : ?>
        <tr>
            <td><?= $t->id ?></td>
            <td><?= $t->account_debit_id ?></td>
            <td><?= $t->account_credit_id ?></td>
            <td><?= $t->name ?></td>   
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h1>Forex Transactions Deleted</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Transaction ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($transactions_forex as $t) : ?>
        <tr>
            <td><?= $t->id ?></td>
            <td><?= $t->transaction_id ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php var_dump($transactions[1]); ?>