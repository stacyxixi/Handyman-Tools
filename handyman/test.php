<form action="?" method="get"> ID Number: <input
type="text" name="idnumber" /><br/>
<input type="submit" value="Whats my
email address" /> </form> 

<html>
<head>
<title>Dynamic Form</title>
<script src="scripts/jquery-1.12.3.min.js"></script>
<script language="javascript">
var i = 1;
function changeIt()
{
my_div.innerHTML = my_div.innerHTML +"<br><input type='text' id=i>";

i++;
}

$(document).ready(function(){
    $("#remove").click(function(){
        $("#l").empty();
    });
});
</script>
</script>
</head>
<body>

<form name="form" action="post" method="">
<input type="text" name=t1>
<input type="button" value="test" onClick="changeIt()">
<button id ="remove">l</button>
<div id="my_div"></div>
<p id ="l"> lalala</p>

</body>


