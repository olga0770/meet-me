$('#formSignup').submit(function (e) {
    e.preventDefault();

    // validation
    let sUserName = $('#userName').val();
    let sPassword = $('#password').val();
    let sConfirmPassword = $('#confirmPassword').val();
    let sBio = $('#bio').val();
    let iAge = $('#age').val();


    if( sUserName.length < 2 || sUserName.length > 21 ){
        $('.errorUserName').text('Must be from 3 to 20 characters')
    }

    if( sPassword.length < 5 || sPassword.length > 21 ){
        $('.errorPassword').text('Must be from 6 to 20 characters')
    }

    if( sBio.length < 9 || sBio.length > 101 ){
        $('.errorBio').text('Must be from 10 to 100 characters')
    }

    if( iAge < 17 || iAge > 101 ){
        $('.errorAge').text('Must be from 18 to 100')
    }

        if(sPassword !== sConfirmPassword) {
            $('.errorConfirmPassword').text('Wrong confirmation')
        }




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
        .fail(function ( jqXHR, textStatus, errorThrown ) {
            console.log('fail callback called.');
            console.log('Fail. ', jqXHR.responseJSON);
            $('.errorEmail').text(jqXHR.responseJSON.error)
            // $('.errorSignup').text(jqXHR.responseJSON.error)

        })
        .always(function (jData) {
            console.log('always callback called.');
            console.log(jData);
        })
});








