var runTest = function(hash) {
    
    $('#'+hash+' .status').html('Running')
    
    $.ajax({
        type: "GET",
        url: "testing/test/run-test", 
        data: { hash: hash },
        dataType: "json",
        success: function(result){
            console.log(result)
            $('#'+hash+' .status').html(result.state)
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