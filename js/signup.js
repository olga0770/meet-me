$(document).ready(function () {
    $(document).ajaxStart(function () {
        setTimeout(function () {
            $("#wait").css("display", "block");
        }, 3000);
    });
    $(document).ajaxComplete(function () {
        $("#wait").css("display", "none");
    });


    $("#formSignup").submit(function (e) {
        e.preventDefault();

        let sUserName = $('#userName').val();
        let sPassword = $('#password').val();
        let sConfirmPassword = $('#confirmPassword').val();
        let sBio = $('#bio').val();
        let iAge = $('#age').val();

        if (sUserName.length <= 3 || sUserName.length >= 20) {
            $('.errorUserName').text('Must be from 3 to 20 characters')
        }

        if (sPassword.length <= 8 || sPassword.length >= 20) {
            $('.errorPassword').text('Must be from 8 to 20 characters')
        }

        if (sBio.length <= 10 || sBio.length >= 275) {
            $('.errorBio').text('Must be from 10 to 275 characters')
        }

        if (iAge <= 18 || iAge >= 100) {
            $('.errorAge').text('Must be from 18 to 100')
        }

        if (sPassword !== sConfirmPassword) {
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
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log('fail callback called.');
                $('.errorEmail').text(jqXHR.responseText)
            })
            .always(function (jData) {
                console.log('always callback called.');
                console.log(jData);
            })
    });


});
