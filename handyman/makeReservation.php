<form action="?" method="get"> ID Number: <input
type="text" name="idnumber" /><br/>
<input type="submit" value="Whats my
email address" /> </form> <p>Your
email address is
<?php echo isset($_GET['idnumber']) ? htmlspecialchars($_GET['idnumber']) : ''; ?>@email.com</p>

<html>
<head>
<title>Dynamic Form</title>
<script language="javascript">
var i = 1;
function changeIt()
{

my_div.innerHTML = my_div.innerHTML +"<br><input type='text' name='mytext'+ i>"
i++;
}
</script>
</head>
<body>

<form name="form" action="post" method="">
<input type="text" name=t1>
<input type="button" value="test" onClick="changeIt()">
<div id="my_div"></div>

</body>