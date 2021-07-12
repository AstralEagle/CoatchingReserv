jQuery(function($){
    $('.month').hide();
    $('.month:first').show();
    $('.monthsList a:first').addClass('active');
    var current = $('.monthsList a:first').attr('id').replace('linkMonth','');
    $('.monthsList a').click(function(){
        var month = $(this).attr('id').replace('linkMonth','');
        if(month != current){
            $('#month'+ current).slideUp();
            $('#month'+ month).slideDown();
            current = month;
            $('.monthsList a').removeClass('active');
            $('.monthsList a#linkMonth'+month).addClass('active');
        }
        return false;
    })
});
