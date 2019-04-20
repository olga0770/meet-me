<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
</head>
<body>

<form id="form">
    <input name="userName" type="text">
    <input type="submit" value="submit">
</form>


<script src="jquery-3.3.1.min.js"></script>

<script>

    $('#form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "test-api.php",
            method: "POST",
            data: $('#form').serialize(),
            dataType: "JSON"
        }).done(function (data, textStatus, jqXHR) {
            console.log('Done. ', jqXHR.responseJSON);
        }).fail(function ( jqXHR, textStatus, errorThrown) {
            console.log('Fail. ', jqXHR.responseJSON)

            //let obj = JSON.parse(jqXHR.responseJSON)
            //alert(jqXHR.responseJSON.error)

            console.log(typeof jqXHR.responseJSON)
            console.log(typeof jqXHR.responseText)

            // to parse string into an object:
            JSON.parse(jqXHR.responseText)

            // let str = jqXHR.responseText
            // alert(JSON.parse(str).error)
        })
    });

</script>


</body>
</html>