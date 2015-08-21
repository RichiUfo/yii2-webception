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
                console.log($('.test-log.'+hash).html())
                $('.test-log.'+hash).html(result.log) 
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