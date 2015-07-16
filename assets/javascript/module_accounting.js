/**************************
* Accounting Summary Page *
**************************/
function acc_sum_init() {
    acc_sum_refresh();
}
function acc_sum_refresh() {
    
    $('#accounting-summary-container').html('<div class="ajaxloader"><img src="/img/loader.png"></div>'); 
    $('#page-header').html('<div class="ajaxloader"><img src="/img/loader.png"></div>');
    
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
    
    $.ajax({
        url: '/accounting/default/index-header',
        type: 'GET',
        data: {start: start, end: end},
        success: function(result){
            $('#page-header').html(result);
            $(document).trigger('domupdated');
        }
    });
};

/*********************
* Balance Sheet Page *
*********************/
function acc_bs_init() {
    acc_bs_refresh();
}
function acc_bs_refresh() {
    
    $('#accounting-balancesheet-container').html('<div class="ajaxloader"><img src="/img/ajax-loader.gif"></div>');

    var start = moment($("#input-daterange-container input[name='date_from']").datepicker('getDate')).format('YYYY-MM-DD');
    var end = moment($("#input-daterange-container input[name='date_to']").datepicker('getDate')).format('YYYY-MM-DD');

    $.ajax({
        url: '/accounting/balancesheet/index',
        type: 'GET',
        data: {start: start, end: end},
        success: function(result){
            $('#accounting-balancesheet-container').html(result);
            $(document).trigger('domupdated');
        }
    });
};

/*********************
* Profits And Losses Page *
*********************/
function acc_pl_init() {
    acc_pl_refresh();
}
function acc_pl_refresh() {
    
    $('#accounting-income-container').html('<div class="ajaxloader"><img src="/img/ajax-loader.gif"></div>');

    var start = moment($("#input-daterange-container input[name='date_from']").datepicker('getDate')).format('YYYY-MM-DD');
    var end = moment($("#input-daterange-container input[name='date_to']").datepicker('getDate')).format('YYYY-MM-DD');

    $.ajax({
        url: '/accounting/profitloss/index',
        type: 'GET',
        data: {start: start, end: end},
        success: function(result){
            $('#accounting-income-container').html(result);
            $(document).trigger('domupdated');
        }
    });
};

/***************
* Account Page *
***************/
function acc_acc_init() {
    acc_acc_refresh();
}
function acc_acc_refresh() {
    
    $('#accounting-account-container').html('<div class="ajaxloader"><img src="/img/ajax-loader.gif"></div>');

    var accountid = $("#accounting-account-container").attr("accountid");
    var start = moment($("#input-daterange-container input[name='date_from']").datepicker('getDate')).format('YYYY-MM-DD');
    var end = moment($("#input-daterange-container input[name='date_to']").datepicker('getDate')).format('YYYY-MM-DD');

    $.ajax({
        url: '/accounting/account/display',
        type: 'GET',
        data: {id: accountid, start: start, end: end},
        success: function(result){
            $('#accounting-account-container').html(result);
            $(document).trigger('domupdated');
        }
    });
};

