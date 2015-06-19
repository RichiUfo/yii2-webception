<h1>Current Value= <?= $value ?></h1>
<div class="row">
    <div class="col-lg-6">
        <h1>Historical Values</h1>
        <table class="table table-striped">
        <tbody>
        <?php foreach($histo as $date => $val) : ?>
        <tr>
            <td><?= $date ?></td>
            <td><?= $val ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
    
    
    <div class="col-lg-6">
        <h1>Related Transactions</h1>
        <table class="table table-striped">
            <tbody>
            <?php foreach($trans as $t) : ?>
            <tr>
                <td><?= $t->date_value ?></td>
                <td><?= $t->value ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <h1>Multiple currencies current value</h1>
        <table class="table table-striped">
        <tbody>
        <?php foreach($values as $cur => $val) : ?>
        <tr>
            <td><?= $cur ?></td>
            <td><?= $val ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>
