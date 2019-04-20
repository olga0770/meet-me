$('#formAccountActivation').submit(function (e) {
    e.preventDefault();
    console.log('AccountActivation');

    $.ajax({
        url: "apis/api-account-activation.php",
        method: "POST",
        data: $('#formAccountActivation').serialize(),
        dataType: "JSON"

    }).done(function (jData) {
        console.log('done callback called.');
        console.log(jData);
        location.href = "login.php";
    })
        .fail(function (jData) {
            console.log('fail callback called.');
            console.log(jData);
            $('.noAccountActivation').text('Something wrong. Can not activate your account.')

        })
        .always(function (jData) {
            console.log('always callback called.');
            console.log(jData);
        })
});
