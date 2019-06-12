$(document).on('click', '.btnDeactivate', function(){
    console.log('test deactivate');

    let oUser = $(this).parents('.userObject');
    let id = $(this).parents('.userObject').attr('id');
    console.log('id:', id, oUser);

    $.ajax({
        url: "apis/api-deactivate-user.php",
        method: "GET",
        data: {"id": id},
        dataType: "JSON"
    }).done(function(jData){
        console.log(jData);
        location.href = "admin.php";

    }).fail(function(jData){
        console.log(jData);
        console.log('something went wrong with deactivating user')
    })
});


$(document).on('click', '.btnActivate', function(){
    console.log('test activate');

    let oUser = $(this).parents('.userObject');
    let id = $(this).parents('.userObject').attr('id');
    console.log('id:', id, oUser);

    $.ajax({
        url: "apis/api-activate-user.php",
        method: "GET",
        data: {"id": id},
        dataType: "JSON"
    }).done(function(jData){
        console.log(jData);
        location.href = "admin.php";

    }).fail(function(jData){
        console.log(jData);
        console.log('something went wrong with activating user')
    })
});