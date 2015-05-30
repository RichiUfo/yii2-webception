<!-- Prepare the period display -->
<?php
$start_dt = new \DateTime($start);
$end_dt = new \DateTime($end);
$period = $start_dt->format('M j').' - '.$end_dt->format('M j');
?>
<div class="card informative-block">
    <div class="card-header">
        <div class="banner-title">
            <p>Movements</p>
        </div>
        <div class="banner-subtitle">
            <p><?= $period ?></p>
        </div>
    </div>
    <div class="card-content">
        <table style="width: 100%">
            <tr>
                <td>Opening Balance</td>
                <td class="text-right">
                    <span class="money" value="<?= $account->sign*$movements['opening_balance'] ?>" currency=""></span>
                </td>
            </tr>
            <tr>
                <td>Debits</td>
                <td class="text-right">
                    <span class="money" value="<?= $movements['passed_debits'] ?>" currency=""></span>
                </td>
            </tr>
            <tr>
                <td>Credits</td>
                <td class="text-right">
                    <span class="money" value="<?= $movements['passed_credits'] ?>" currency=""></span>
                </td>
            </tr>
            <tr>
                <td>Current Balance</td>
                <td class="text-right">
                    <span class="money" value="<?= $account->sign*$movements['current_balance'] ?>" currency=""></span>
                </td>
            </tr>
            <tr>
                <td>Future Debits</td>
                <td class="text-right">
                    <span class="money" value="<?= $movements['future_debits'] ?>" currency=""></span>
                </td>
            </tr>
            <tr>
                <td>Future Credits</td>
                <td class="text-right">
                    <span class="money" value="<?= $movements['future_credits'] ?>" currency=""></span>
                </td>
            </tr>
            <tr>
                <td>Closing Balance</td>
                <td class="text-right">
                    <span class="money" value="<?= $account->sign*$movements['closing_balance'] ?>" currency=""></span>
                </td>
            </tr>
        </table>
    </div>
</div>