<!-- Title & Dates -->
<div class="col-lg-12 time-range">
    <h1>Accounting</h1>
    <div class="right-menu">
        <span class="icon"><i class="fa fa-calendar"></i></span> 
        <div id="input-daterange-container">
            <?= DateRangePicker::widget([
                'id' => 'input-daterange-widget',
                'name' => 'date_from',
                'size' => 'sm',
                'value' => date("Y-m-d", strtotime(date("Y-m-d").' -1 months')),
                'nameTo' => 'date_to',
                'valueTo' => date("Y-m-d"),
                'labelTo' => '<i class="fa fa-chevron-right"></i>',
                'clientOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true
                ],
                'clientEvents' => [
                    'changeDate' => 'function ev(){acc_sum_refresh();}'
                ]
            ]); ?>
        </div>
    </div>
</div>

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
                <td></td>
                <td></td>
                <td></td>
            </tr>
            
        </tbody>
    </table>
</div>