$(document).ready(function(){
    
    $('.run-test').click(function(){
        
        console.log('Trying to run a test with hash ' + $(this).attr('hash'));
        
        $.ajax({
            method: "GET",
            url: "testing/test/run-test", 
            data: { hash: $(this).attr('hash') },
            success: function(result){
                console.log('Test executed. Output ' + result);
            }
        });
        
    })
    
});