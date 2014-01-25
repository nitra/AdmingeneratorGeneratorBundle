$(document).ready(function(){
    $('.main_menu > ul > li').click(function(){
        $(this).addClass('active').siblings('li.active').removeClass('active');  
        // add class if menu has submenu
        if ($(this).children('ul').length > 0) {
            $('.main_menu').addClass('has_submenu');
        } else {
            $('.main_menu').removeClass('has_submenu');
        }
    })
    $('.main_menu > ul > li > ul > li').click(function(){
        $(this).addClass('active').siblings('li.active').removeClass('active');  
        // add class if menu has submenu
        if ($(this).children('ul').length > 0) {
            $('.main_menu').addClass('has_submenu_level2');
        } else {
            $('.main_menu').removeClass('has_submenu_level2');
        }
    })
    
    // first display
    if ($('.main_menu .active').children('ul').length > 0) {
        $('.main_menu').addClass('has_submenu');
    }
    if ($('.main_menu .active ul li.active').children('ul').length > 0) {
        $('.main_menu').addClass('has_submenu_level2');
    }
});