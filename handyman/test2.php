<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript">
    function ajaxfunction(parent)
    {
        $.ajax({
            url: 'process.php?parent=' + parent;
            success: function(data) {
                $("#sub").html(data);
            }
        });
    }
</script>
</script
</head>
<body>

<select onchange="ajaxfunction(this.value)">
    <option value="Hand Tools">Hand Tools</option>
    <option value="Construction Equipment">Construction Equipment</option>
    <option value="Power Tools">Power Tools</option>
</select>
<select id="sub"></select> 

</body>
</html>

