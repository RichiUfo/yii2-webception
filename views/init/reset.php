Transactions to be removed<br>
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