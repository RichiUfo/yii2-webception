var runTest = function(hash) {
    
    resetTest(hash)
    
    $('#'+hash+' .status').html('Running')
    $('#'+hash+' .run-test').attr('disabled', true)
    $('#'+hash+' .run-test').html('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>')
    
    $.ajax({
        type: "GET",
        url: "testing/test/run-test", 
        data: { hash: hash },
        dataType: "json",
        success: function(result){
            
            // Show test status + color the label
            $('#'+hash+' .status').html(result.state)
            $('#'+hash+' .status').removeClass('btn-default btn-primary btn-success btn-info btn-warning btn-danger')
            switch(result.state) {
                case 'Failed':
                    $('#'+hash+' .status').addClass('btn-danger')
                    break;
                case 'Passed':
                    $('#'+hash+' .status').addClass('btn-success')
                    break;
                case 'Ready':
                    $('#'+hash+' .status').addClass('btn-primary')
                    break;
                case 'Error':
                    $('#'+hash+' .status').addClass('btn-warning')
                    break;
                default:
                    $('#'+hash+' .status').addClass('')
            }
            
            // Update the test log
            $('.test-log.'+hash).html(result.log) 
            $('#'+hash+' .run-test').attr('disabled', false)
            $('.view-log[hash='+hash+']').attr('disabled', false)
            
        }
    })
}
var resetTest = function(hash) {
    
    // Reset the status label
    $('#'+hash+' .status').removeClass('btn-default btn-primary btn-success btn-info btn-warning btn-danger')
    $('#'+hash+' .status').addClass('btn-primary')
    $('#'+hash+' .status').html('Ready')
    
    // Empty and hide the log
    $('.test-log.'+hash).html('')
    $('.view-log[hash='+hash+']').attr('disabled', true)
    
    // Reset the button icon
    $('#'+hash+' .run-test').html('<span class="glyphicon glyphicon-play" aria-hidden="true"></span>')
    
}
var checkCoverageAvailability = function() {
    $('.site').each(function(){
        
        var site = $(this)
        var sitename = $(this).find('.test-site-name').html().toLowerCase()
        var url = window.location.origin+'/tests/'+sitename+'/coverage.xml'
        
        $.ajax({
            type: 'HEAD',
            url: url,
            success: function(){
                // If coverage data exists
                site.find('.btn-view-coverage').attr('disabled', false)
                site.find('.btn-refresh-coverage').html('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>')
            
                // Load the coverage data
                $.ajax({
                    type: "GET",
                    url: "testing/coverage/run-coverage", 
                    data: { site: sitename },
                    dataType: "json",
                    success: function(result){
                        site.find('.coverage-value').html(Math.round(result.coverage_methods)+' %')
                    }
                })
                
            },
            error: function() {
                // If coverage data doesn't exists
                site.find('.btn-view-coverage').attr('disabled', true)
                site.find('.btn-refresh-coverage').html('<span class="glyphicon glyphicon-play" aria-hidden="true"></span>')
            }
        });
        
    })
}

$(document).ready(function(){
    
    /**
     * Init The Page
     */
    checkCoverageAvailability()
    
    /**
     * Test Runners
     */
    $('.run-test').click(function(){
        var hash = $(this).attr('hash')
        runTest(hash)
    })
    
    $('.run-type').click(function(){
        var site = $(this).attr('site')
        var type = $(this).attr('type')
        $('#'+site+' .'+type+' .run-test').each(function(i, obj) {
            runTest($(obj).attr('hash'))
        })
    })
    $('.run-site').click(function(){
        var site = $(this).attr('site')
        $('#'+site+' .run-test').each(function(i, obj) {
            runTest($(obj).attr('hash'))
        })
    })
    
    $('.run-all').click(function(){
        $('.run-test').each(function(i, obj) {
            runTest($(obj).attr('hash'))
        })
    })
    
    /**
     * Test Resetters
     */
    $('.reset-all').click(function(){
        $('.reset-test').each(function(i, obj) {
            resetTest($(obj).attr('hash'))
        })
    })
    
    /**
     * Test Log Viewer Buttons
     */
    $('.view-log').click(function(){
        if (!$(this).attr('disabled')) {
            var hash = $(this).attr('hash')
            $('#modal-'+hash).modal('show')
        }
    })
    
    /**
     * Coverage Stats Viewer
     */
    $('.btn-view-coverage').click(function(){
        if(!$(this).attr('disabled')){
            var sitename = $(this).parents('.site').find('.test-site-name').html().toLowerCase();
            window.location.assign('/tests/'+sitename+'/coverage')
        }
    })
    
    /**
     * Coverage Refresh
     */
    $('.btn-refresh-coverage').click(function(){
        
        // Show test is running status to the user
        $(this).parent().find('.coverage-value').html('Running')
        $('#'+hash+' .btn-refresh-coverage').attr('disabled', true)
        $('#'+hash+' .btn-view-coverage').attr('disabled', true)
        
        // Prepare the request parameters
        var sitename = $(this).parents('.site').find('.test-site-name').html().toLowerCase();
        
        // Request the update using AJAX
        $.ajax({
            type: "GET",
            url: "testing/test/run-test", 
            data: { hash: hash },
            dataType: "json",
            success: function(result){
                
                // Show test status + color the label
                $('#'+hash+' .status').html(result.state)
                $('#'+hash+' .status').removeClass('btn-default btn-primary btn-success btn-info btn-warning btn-danger')
                switch(result.state) {
                    case 'Failed':
                        $('#'+hash+' .status').addClass('btn-danger')
                        break;
                    case 'Passed':
                        $('#'+hash+' .status').addClass('btn-success')
                        break;
                    case 'Ready':
                        $('#'+hash+' .status').addClass('btn-primary')
                        break;
                    case 'Error':
                        $('#'+hash+' .status').addClass('btn-warning')
                        break;
                    default:
                        $('#'+hash+' .status').addClass('')
                }
                
                // Update the test log
                $('.test-log.'+hash).html(result.log) 
                $('#'+hash+' .run-test').attr('disabled', false)
                $('.view-log[hash='+hash+']').attr('disabled', false)
                
            }
        })
        
        
    })
    
})