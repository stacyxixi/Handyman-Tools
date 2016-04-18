$(document).ready(function(){
//        var js =[];
//    $.getJSON("http://localhost/handyman/getToolType.php", function(data){
//        var options = "";
//        for (var i =0; i<data.length; i++)
//        {
//            options +="<option value='"+data[i].toLowerCase()+"'>"+ data[i]+"</option>";
//            js = data;
//            
//        }
//        var tag = "#toolType";
//        $(tag).append(options);
//    });
//    
//        $("#toolType").change(function(){
//        $.getJSON("process.php", success =function(data){
//            var options = "";
//            for (var i =0; i<data.length; i++){
//                options +="<option value='"+data[i].toLowerCase()+"'>"+ data[i]+"</option>";
//                $("#tool").append(options);
//            }
//        });
//
//    });

    
    $.getJSON("http://localhost/handyman/getToolType.php", function(data){
        var options = "";
        for (var i =0; i<data.length; i++)
        {
            options +="<option value='"+data[i].toLowerCase()+"'>"+ data[i]+"</option>";
            
        }
        var tag = "#toolType";
        $(tag).append(options);
    });
    

    
    
    $("#toolType").change(function(){
        $.getJSON("process.php?type="+$(this).val(), success =function(result){
            var options = "";
            for (var i =0; i<result.length; i++){
                options +="<option value='"+result[i].toLowerCase()+"'>"+ result[i]+"</option>";
                
            }
            $("#tool").empty();
            $("#tool").append(options);
        });

    });
    

    
    

});
//var i = 1;
//function changeIt()
//{
//    toollist.innerHTML = toollist.innerHTML +"<tr><td><select id='"+i+"'></select></td><td><select id='"+i+"'></select></td></tr>";
//    i++;
//}



