var runTest = function(hash) {
    $.ajax({
        type: "GET",
        url: "testing/test/run-test", 
        data: { hash: hash },
        dataType: "json",
        success: function(result){
            $('#'+hash+' .status').html(result.state)
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
            console.log(obj)
            //runTest(obj.attr('hash'))
        });
        
    })
    
})