$(document).on('click', '.btn-delete', function(e){
    e.preventDefault();
    var $form=$(this).data('form');
    $('#confirm').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete-btn', function(){
            document.getElementById($form).submit();
        });
});