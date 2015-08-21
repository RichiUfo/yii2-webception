$(document).ready(function(){
    
    $('.run-test').click(function(){
        
        var hash = $(this).attr('hash');
        
        $.ajax({
            ty: "GET",
            url: "testing/test/run-test", 
            data: { hash: hash },
            dataType: "json",
            success: function(result){
                $('#'+hash+' .status').html(result.state);
            }
        });
        
    })
    
});