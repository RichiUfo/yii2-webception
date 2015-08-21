$(document).ready(function(){
    
    $('.run-test').click(function(){
        
        console.log('Trying to run a test with hash ' + $(this).attr('hash'));
        
        var hash = $(this).attr('hash');
        
        $.ajax({
            ty: "GET",
            url: "testing/test/run-test", 
            data: { hash: hash },
            success: function(result){
                
                $('#'+hash+' .status').html(result.state);
                
                console.log('Test executed. Output ' + result[0], $('#'+hash+' .status').html(), result[0].state);
            }
        });
        
    })
    
});