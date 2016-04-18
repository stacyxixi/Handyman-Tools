$(document).ready(function(){
    var js =[];
    $.getJSON("http://localhost/handyman/getToolType.php", function(data){
        var options = "";
        for (var i =0; i<data.length; i++)
        {
            options +="<option value='"+data[i].toLowerCase()+"'>"+ data[i]+"</option>";
            js = data;
            
        }
        var tag = "#toolType";
        $(tag).append(options);
    });
    

    
    
    $("#toolType").change(function(){
        $.getJSON("process.php", success =function(data){
            var options = "";
            for (var i =0; i<data.length; i++){
                options +="<option value='"+data[i].toLowerCase()+"'>"+ data[i]+"</option>";
                $("#tool").append(options);
            }
        });

    });

});

