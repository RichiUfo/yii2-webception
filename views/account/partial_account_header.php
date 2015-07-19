<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use frontend\widgets\stepform\StepFormModalContainerWidget;
use frontend\widgets\buttonmodal\ButtonModal;
?>

<!-- Data Summary -->
<div class="col-lg-4">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th colspan="3">Key Figures</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Assets</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Revenues</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Expenses</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Net Income</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Account Owner</td>
                <td colspan="2" class="fit-width"><?= $ ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Analytics -->
<div class="col-lg-4">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th colspan="3">Analytics</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Debt To Equity</td>
                <td class="fit-width"><span class="pull-right">0</span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Current Ratio</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Return On Assets</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="0" currency=""></span></td>
            </tr>
            <tr>
                <td>Return On Equity</td>
                <td class="fit-width"><span class="pull-right money" value="0" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="0" currency=""></span></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Quick Actions -->
<div class="col-lg-4">
    <table class="table table-condensed quick-actions">
        <thead>
            <tr>
                <th colspan="2">Quick Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= ButtonModal::widget([
                        'caption' => 'New Transaction',
                        'icon' => 'plus',
                        'route' => '/accounting/transaction/create'
                    ]) ?>
                </td>
                <td>
                    <?= ButtonModal::widget([
                        'caption' => 'New Account',
                        'icon' => 'plus',
                        'route' => '/accounting/account/create'
                    ]) ?>
                </td>
            </tr>
            
        </tbody>
    </table>
</div>
