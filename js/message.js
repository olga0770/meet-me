$('#formMessage').submit(function (e) {
    e.preventDefault();

    // validation
    let sMessage = $('#message').val();

    if (sMessage.length < 3 || sMessage.length > 300) {
        $('.errorMessage').text('Must be from 3 to 300 characters')
    }

    const toUserId = $('#toUserId').val();


    $.ajax({
        url: "apis/api-message.php",
        method: "POST",
        data: $('#formMessage').serialize(),
        dataType: "JSON"

    }).done(function (jData) {
        console.log('done callback called.');
        console.log(jData);
        location.href = "message.php?id=" + toUserId;
    })
        .fail(function (jData) {
            console.log('fail callback called.');
            console.log(jData);
        })
        .always(function (jData) {
            console.log('always callback called.');
            console.log(jData);
        })
});


