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
                <?php 
                $current_balance = $closing_balance;
                foreach ($transactions as $transaction) : ?>
                <?php
                $debits = 0;
                $credits = 0;
                ?>
                <tr>
                    <td class="text-left">
                        <span class="date" 
                              datetime="<?= $transaction->date_value ?>"></span>
                    </td>
                    <td class="text-left">
                        <?= $transaction->name ?>
                    </td>
                    <td class="text-right">
                        <?php if($transaction->debit) : ?>
                        <?php $debits = $transaction->value; ?>
                        <span class="money" 
                              value="<?= $transaction->value ?>" 
                              currency=""></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <?php if($transaction->credit) : ?>
                        <?php $credits = $transaction->value; ?>
                        <span class="money" 
                              value="<?= $transaction->value ?>" 
                              currency=""></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <span class="money" 
                              value="<?= $account->sign * $current_balance ?>" 
                              currency=""></span>
                    </td>
                    <?php
                    $current_balance = $current_balance - $credits + $debits;
                    ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
