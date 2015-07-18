/********************************
* Generic Data Loading Function *
********************************/
function ajax_load(content) {
    
    $.ajax({
        url: content[0].url,
        type: 'GET',
        data: content[0].params,
        success: function(result, b, c){
            
            // Load the content and trigger the domupdated event
            $(content[0].target).html(result);
            $(document).trigger('domupdated');
            
            // Removes the first element and call the function again
            content.shift();
            if(content !== []) {
                ajax_load(content);
            }
            else {
                $(document).trigger('domupdated');
            }
        }
    });
    
}
function get_accounting_dates() {
    var start = moment($("#input-daterange-container input[name='date_from']").datepicker('getDate')).format('YYYY-MM-DD');
    var end = moment($("#input-daterange-container input[name='date_to']").datepicker('getDate')).format('YYYY-MM-DD');
    return {start: start, end: end};
}
function display_accounting_loader(selector) {
    $(selector).html('<div class="ajaxloader"><img src="/img/loader.png"></div>'); 
}

/**************************
* Accounting Summary Page *
**************************/
function acc_sum_init() {
    acc_sum_refresh();
}
function acc_sum_refresh() {
    
    display_accounting_loader('#accounting-summary-container');
    var dates = get_accounting_dates();
    
    ajax_load([
        {
            target: '#page-header-summary',
            url: '/accounting/default/index-header',
            loader: false,
            params: dates
        },
        {
            target: '#accounting-summary-container',
            url: '/accounting/default/index',
            loader: true,
            params: dates
        }
    ]);
};

/*********************
* Balance Sheet Page *
*********************/
function acc_bs_init() {
    acc_bs_refresh();
}
function acc_bs_refresh() {
    
    display_accounting_loader('#accounting-balancesheet-container');
    var dates = get_accounting_dates();
    
    ajax_load([
        {
            target: '#page-header-summary',
            url: '/accounting/balancesheet/index-header',
            loader: false,
            params: dates
        },
        {
            target: '#accounting-balancesheet-container',
            url: '/accounting/balancesheet/index',
            loader: true,
            params: dates
        }
    ]);
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
    
    display_accounting_loader('#accounting-account-container');
    var dates = get_accounting_dates();
    var accountid = $("#accounting-account-container").attr("accountid");
    
    ajax_load([
        {
            target: '#page-header-summary',
            url: '/accounting/balancesheet/index-header',
            loader: false,
            params: dates
        },
        {
            target: '#accounting-account-container',
            url: '/accounting/account/display',
            loader: true,
            params: $.extend({}, dates, {id: accountid})
        }
    ]);
};

