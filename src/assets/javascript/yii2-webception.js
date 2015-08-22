var runTest = function(hash) {
    
    $('#'+hash+' .status').html('Running')
    $('#'+hash+' .run-test').addClass('disabled')
    
    $.ajax({
        type: "GET",
        url: "testing/test/run-test", 
        data: { hash: hash },
        dataType: "json",
        success: function(result){
            
            // Show test status + color the label
            $('#'+hash+' .status').html(result.state)
            $('#'+hash+' .status').removeClass('label-default label-primary label-success label-info label-warning label-danger')
            switch(result.state) {
                case 'Failed':
                    $('#'+hash+' .status').addClass('label-danger')
                    break;
                case 'Passed':
                    $('#'+hash+' .status').addClass('label-success')
                    break;
                case 'Ready':
                    $('#'+hash+' .status').addClass('label-primary')
                    break;
                case 'Error':
                    $('#'+hash+' .status').addClass('label-warning')
                    break;
                default:
                    $('#'+hash+' .status').addClass('')
            }
            
            // Show test log in case of failure
            if(result.state == 'Failed') {
                $('.test-log.'+hash+' td pre').html(result.log) 
                $('.test-log.'+hash).show() 
            }
            
            // Update the button
            $('#'+hash+' .run-test').hide()
            $('#'+hash+' .reset-test').show()
            
        }
    })
}
var resetTest = function(hash) {
    
    // Reset the status label
    $('#'+hash+' .status').removeClass('label-default label-primary label-success label-info label-warning label-danger')
    $('#'+hash+' .status').addClass('label-primary')
    $('#'+hash+' .status').html('Ready')
    
    // Empty and hide the log
    $('.test-log.'+hash+' td pre').html('') 
    $('.test-log.'+hash).show() 
    
    // Buttons Reset
    $('#'+hash+' .run-test').show()
    $('#'+hash+' .reset-test').hide()
}

$(document).ready(function(){
    
    /**
     * Test Runners
     */
    $('.run-test').click(function(){
        var hash = $(this).attr('hash')
        runTest(hash)
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
})