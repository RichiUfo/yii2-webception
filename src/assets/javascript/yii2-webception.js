$(document).ready(function(){
    
    $('.run-test').click(function(){
        
        console.log('Trying to run a test with hash ' + $(this).attr('hash'));
        
        $.ajax({
            url: "test/run-test", 
            success: function(result){
                console.log('Test executed. Output ' + result);
            }
        });
        
    })
    
});