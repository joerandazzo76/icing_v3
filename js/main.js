$(document).ready(function() {

    $('input[type="radio"]').click(function(){
        $('.card').removeClass('active');
       if($(this).not(':checked')) {
           $(this).parent().parent().parent().addClass('active');
       }

    });
});