$('#formSignup').submit(function (e) {
    e.preventDefault();
    console.log('signup');

    $.ajax({
        url: "apis/api-signup.php",
        method: "POST",
        data: $('#formSignup').serialize(),
        dataType: "JSON"

    }).done(function (jData) {
        console.log('done callback called.');
        console.log(jData);
        location.href = "account-activation.php";
    })
        .fail(function (jData) {
            console.log('fail callback called.');
            console.log(jData);
            $('.noSignup').text('Something wrong. Can not sign you up. Try again.')

        })
        .always(function (jData) {
            console.log('always callback called.');
            console.log(jData);
        })
});








