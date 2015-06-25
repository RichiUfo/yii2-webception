<?php
use frontend\widgets\rotatingcard\RotatingCardWidget;
?>

<!-- Prepare the period display -->
<?php
$start_dt = new \DateTime($start);
$end_dt = new \DateTime($end);
$period = $start_dt->format('M j, Y').' - '.$end_dt->format('M j, Y');
?>

<div class="card informative-block">
    <div class="card-header">
        <div class="banner-title">
            <p>Transactions</p>
        </div>
        <div class="banner-subtitle">
            <p><?= $period ?></p>
        </div>
    </div>
    <div class="card-content">
        <table class="table table-striped table-no-margin">
            <thead>
                <tr>
                    <th class="text-left">Date</th>
                    <th class="text-left">Transaction</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-right">Balance</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- Transactions Items -->
                <?php foreach ($transactions as $t) : ?>
                <tr>
                    <td class="text-left"><span class="date" datetime="<?= $t->date_value ?>"></span></td>
                    <td class="text-left"><?= $t->name ?></td>
                    <td class="text-right"><?= $t->valueDebit ?> <?= $t->accountDebit->currency ?></td>
                    <td class="text-right"><?= $t->valueCredit ?> <?= $t->accountCredit->currency ?></td>
                    <td class="text-right"><span class="money" value="0" currency=""></span></td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
</div>

<?php var_dump($transactions); ?>