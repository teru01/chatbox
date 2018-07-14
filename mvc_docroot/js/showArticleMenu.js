$(function () {
    $('.arrow').click(function (){
        let n = $('.arrow').index(this);
        $('.article_menu').eq(n).slideToggle('fast');
        return false;
    });
});