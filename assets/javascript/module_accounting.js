/**************************
* Accounting Summary Page *
**************************/
function acc_sum_refresh() {
    
    $('#accounting-summary-container').html('<img src="/img/ajax-loader.gif">');
    
    console.log($("#input-daterange-container input[name='date_from']"), $("#input-daterange-container input[name='date_from']").parent().datepicker('getDate'));

    var start = moment($("#input-daterange-container input[name='date_from']").datepicker('getDate')).format('YYYY-MM-DD');
    var end = moment($("#input-daterange-container input[name='date_to']").datepicker('getDate')).format('YYYY-MM-DD');

    $.ajax({
        url: '/accounting/default/index',
        type: 'GET',
        data: {start: start, end: end},
        success: function(result){
            $('#accounting-summary-container').html(result);
            $(document).trigger('domupdated');
        }
    });
};

/*********************
* Balance Sheet Page *
*********************/


/***************
* Account Page *
***************/

/* Date Picker Right Panel */
var accountPageInit = function(){
    
    // Account Page, Load the last 30 days transactions
    var start = moment().subtract(1, 'months').format('YYYY-MM-DD');
    var end = moment().format('YYYY-MM-DD');
    var accountid = $('#account-transactions-ajax').attr('accountid');
    $.ajax({
        url: '/accounting/transaction/get-transactions-view',
        data: {accountid: accountid, start: start, end: end},
        success: function(result) {
            $('#account-transactions-ajax').html(result);
            $(document).trigger('domupdated');
        }
    });
    $.ajax({
        url: '/accounting/account/get-movements-summary-view',
        data: {accountid: accountid, start: start, end: end},
        success: function(result) {
            $('#movements-summary-ajax').html(result);
            $(document).trigger('domupdated');
        }
    });
    
};
$('.btn-account-period').click(function(){
    
    // 1 - Set the active state
    $('.btn-account-period').each(function() {
        $(this).removeClass("active");
    });
    $(this).addClass("active");
    
    // 2 - Get the current date
    var to = moment();
    
    // 3 - Calculate the start date
    switch($(this).attr('id')) {
        case 'period-year':
            var from = moment().subtract(1, 'years');
            break;
        case 'period-quarter':
            var from = moment().subtract(3, 'months');
            break;
        case 'period-month':
            var from = moment().subtract(1, 'months');
            break;
        case 'period-week':
            var from = moment().subtract(7, 'days');
            break;
        default:
            var from = moment();
    }
    
    // 4 - Update the time range selector
    $("#account-period-selection input[name='date_from']").datepicker('update', from.format('YYYY-MM-DD'));
    $("#account-period-selection input[name='name_to']").datepicker('update', to.format('YYYY-MM-DD'));
    
    // 5 - Update the transactions section
    timePeriodChangeHandler();
});
function timePeriodChangeHandler(){
    
    var start = moment($("#account-period-selection input[name='date_from']").datepicker('getDate')).format('YYYY-MM-DD');
    var end = moment($("#account-period-selection input[name='name_to']").datepicker('getDate')).format('YYYY-MM-DD');
    var accountid = $('#account-transactions-ajax').attr('accountid');
    
    // 1- Update the transactions section
    $.ajax({
        url: '/accounting/transaction/get-transactions-view',
        data: {accountid: accountid, start: start, end: end},
        success: function(result){
            $('#account-transactions-ajax').html(result);
            $(document).trigger('domupdated');
        }
    });
    
    // 2- Update the movements sections
    $.ajax({
        url: '/accounting/account/get-movements-summary-view',
        data: {accountid: accountid, start: start, end: end},
        success: function(result){
            $('#movements-summary-ajax').html(result);
            $(document).trigger('domupdated');
        }
    });
    
}
