jQuery(function($){
    $('.commande').hide();
    $('.commande:first').show();
    $('.libre a:first').addClass('active');
    var current = $('.libre a:first').attr('id').replace('reservID','');
    $('.libre a').click(function(){
        var month = $(this).attr('id').replace('reservID','');
        if(month != current){
            $('#cour'+ current).slideUp();
            $('#cour'+ month).slideDown();
            current = month;
            $('.libre a').removeClass('active');
            $('.libre a#reservID'+month).addClass('active');
        }
        return false;
    })
});
