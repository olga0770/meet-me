$(document).on('click', '.btnDelete', function(){
    console.log('test delete');

    let oUser = $(this).parentsUntil('.userObject');
    let id = $('.userObject').attr('id');
    console.log('id:', id, oUser);

    $.ajax({
        url: "apis/api-delete-user.php",
        method: "GET",
        data: {"id": id},
        dataType: "JSON"
    }).done(function(jData){
        console.log(jData);
        if(jData.status){
            $(oUser).remove()
        }
    }).fail(function(jData){
        console.log(jData);
        console.log('something went wrong with deleting user')
    })

});