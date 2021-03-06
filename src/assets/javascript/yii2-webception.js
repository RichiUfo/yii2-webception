var testQueue = []
var changeButtonColor = function(button, code) {
    button.removeClass('btn-default btn-primary btn-success btn-info btn-warning btn-danger')
    button.addClass('btn-'+code)
}
var addTests = function(selector) {
    testQueue = $(selector)
}
var runTests = function() {
    
    if(testQueue.length > 0) {
        
        var hash = $(testQueue[0]).attr("hash")
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
                
                // Run test on next item
                testQueue.splice(0, 1)
                runTests()
            }
        })
    }
}
var resetTest = function(hash) {
    
    // Reset the status label
    var button = $('#'+hash+' .status')
    changeButtonColor(button, 'primary')
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
        var sitename = site.find('.test-site-name').html().toLowerCase()
        
        // Load the coverage data
        $.ajax({
            type: "GET",
            url: "testing/coverage/get-coverage", 
            data: { site: sitename },
            dataType: "json",
            success: function(result){
                
                console.log(sitename, result)
                
                // Case 1 : Date has already been generated
                if (result !== false) {
                    
                    site.find('.btn-view-coverage').attr('disabled', false)
                    site.find('.btn-refresh-coverage').html('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>')
                    site.find('.coverage-value').html(Math.round(result.coverage_methods)+' %')
                    
                    //Manage the coverage value <> color
                    var button = site.find('.coverage-value')
                    if (result.coverage_methods > 70) { 
                        changeButtonColor(button, 'success')    
                    }
                    else if (result.coverage_methods > 35) {
                        changeButtonColor(button, 'warning')  
                    }
                    else {
                        changeButtonColor(button, 'danger')  
                    }
                }
                // Case 2 : Coverage report doesn't exist
                else {
                    site.find('.btn-view-coverage').attr('disabled', true)
                    site.find('.btn-refresh-coverage').html('<span class="glyphicon glyphicon-play" aria-hidden="true"></span>')
                    changeButtonColor(site.find('.coverage-value'), 'default')
                }
                
            }
        })
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
        addTests(this)
        runTests()
    })
    
    $('.run-type').click(function(){
        var site = $(this).attr('site')
        var type = $(this).attr('type')
        addTests('#'+site+' .'+type+' .run-test')
        runTests()
    })
    
    $('.run-site').click(function(){
        var site = $(this).attr('site')
        addTests('#'+site+' .run-test')
        runTests()
    })
    
    $('.run-all').click(function(){
        addTests('.run-test')
        runTests()
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
            var sitename = $(this).parents('.site').find('.test-site-name').html().toLowerCase()
            window.location.assign('/tests/'+sitename+'/_output/coverage')
        }
    })
    
    /**
     * HTML Output Viewer
     */
    $('.btn-view-output').click(function(){
        var sitename = $(this).parents('.site').find('.test-site-name').html().toLowerCase()
        window.location.assign('/tests/'+sitename)
    })
    
    /**
     * Coverage Refresh
     */
    $('.btn-refresh-coverage').click(function(){
        
        // Prepare the request parameters
        var site = $(this).parents('.site')
        var sitename = site.find('.test-site-name').html().toLowerCase();
        
        // Show test is running status to the user
        site.find('.coverage-value').html('Running')
        site.find('.btn-refresh-coverage').attr('disabled', true)
        site.find('.btn-view-coverage').attr('disabled', true)
        
        // Request the update using AJAX
        $.ajax({
            type: "GET",
            url: "testing/coverage/run-coverage", 
            data: { site: sitename },
            dataType: "json",
            success: function(result){
                
                // Disable the running status
                site.find('.btn-refresh-coverage').attr('disabled', false)
                site.find('.btn-view-coverage').attr('disabled', false)
                
                // Update the coverage statuses
                checkCoverageAvailability()
            },
            timeout: 300000
        })
        
        
    })
    
})