Transactions to be removed<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($transactions as $t) : ?>
        <tr>
            <td><?= $t->id ?></td>
            <td><?= $t-> ?></td>
            <td><?= $t-> ?></td>
            <td><?= $t-> ?></td>   
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>