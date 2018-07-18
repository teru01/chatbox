$(function () {
    $('.arrow').click(function (){
        let n = $('.arrow').index(this);
        $('.article_menu_wrapper').eq(n).slideToggle('fast');
        return false;
    });
});