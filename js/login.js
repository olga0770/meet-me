$('#formLogin').submit(function (e) {
    e.preventDefault();

    // validation
    let sPassword = $('#password').val();

    if (sPassword.length < 5 || sPassword.length > 21) {
        $('.errorPassword').text('Must be from 6 to 20 characters')
    }

    $.ajax({
        url: "apis/api-login.php",
        method: "POST",
        data: $('#formLogin').serialize(),
        dataType: "JSON"

    }).done(function (data, textStatus, jqXHR) {
        console.log('done callback called.');
        console.log(data);
        location.href = "home.php";
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log('fail callback called.');
            console.log('Fail. ', jqXHR.responseJSON);
            $('.errorLogin').text(jqXHR.responseJSON.error)
        })

        .always(function (jData) {
            console.log('always callback called.');
            console.log(jData);
        })


});
