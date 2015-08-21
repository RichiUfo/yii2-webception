$(document).ready(function(){
    
    $('.run-test').click(function(){
        
        console.log('Trying to run a test with hash ' + $(this).attr('hash'));
        
        $.ajax({
            ty: "GET",
            url: "testing/test/run-test", 
            data: { hash: $(this).attr('hash') },
            success: function(result){
                
                // Update the status
                var status = $('#'+$(this).attr('hash')).find('span.status');
                status.html(result.state);
                
                console.log('Test executed. Output ' + result);
            }
        });
        
    })
    
});