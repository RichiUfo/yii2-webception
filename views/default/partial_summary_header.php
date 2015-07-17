<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use frontend\widgets\stepform\StepFormModalContainerWidget;
frontend\widgets\buttonmodal\ButtonModal;
?>

<!-- Data Summary -->
<div class="col-lg-4">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th colspan="3">Summary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Assets</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
            <tr>
                <td>Revenues</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
            <tr>
                <td>Expenses</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
            <tr>
                <td>Net Income</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
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
                <td class="fit-width"><span class="pull-right">47 %</span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">trending_up</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
            <tr>
                <td>Current Ratio</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
            <tr>
                <td>Return On Assets</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-red"><i class="material-icons">trending_down</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
            <tr>
                <td>Return On Equity</td>
                <td class="fit-width"><span class="pull-right money" value="51,000" currency=""></span></td>
                <td class="text-right fit-width text-green"><i class="material-icons">arrow_drop_up</i><span class="money" value="125.12" currency=""></span></td>
            </tr>
        </tbody>
    </table>
    
</div>


<!-- Quick Actions -->
<div class="col-lg-4">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th colspan="3">Quick Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="link-transaction-create-button">
                    <i class="fa fa-plus"></i><span>Create Transaction</span>
                </td>
                <td>
                    <?php
                    ButtonModal::widget([
                        'caption' => 'New Transaction',
                        'icon' => 'plus',
                        'route' => '/accounting/transaction/create'
                    ]);
                    ?>
                </td>
                <td></td>
            </tr>
            
        </tbody>
    </table>
</div>

<?php
// Generate the modal
$modal = Modal::begin([
        'id' => 'link-transaction-create',
        'size' => 'modal-lg',
        'options' => ['class' => 'no-padding']
    ]);
echo '<div class="link-transaction-create-content"></div>';
$modal->end();

// Load the content
$this->registerJs("
    $.ajax({
        url: '".Url::toRoute('/accounting/transaction/create')."',
        success: function(result){
            $('#link-transaction-create').find('.link-transaction-create-content').html(result);
            $(document).trigger('domupdated');
        }
    });
    
    $('#link-transaction-create-button').click(function (){
        $('#link-transaction-create').modal('show');
    });
", $this::POS_END);
?>