var runTest = function(hash) {
    
    $('#'+hash+' .status').html('Running')
    
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
            
        }
    })
}

$(document).ready(function(){
    
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
    
})