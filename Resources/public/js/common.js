$(document).ready(function () {
    
    // Colorbox link
    $('.colorbox').colorbox();
    
    // Popup box
    $('.popup').each(function(){
        $(this).html('<div class="popup_content">' + $(this).html() + '</div>');
        $(this).prepend('<div class="popup_arrow"></div>');
        $(this).addClass('popup_ready');
    })
    $('.popup .popup_arrow').click(function(){
        $(this).parent('div.popup').toggleClass('popup_active');
        $('.popup').not($(this).parent('div.popup')).removeClass('popup_active');
    });
    
});


// Общие функции
function common() {
    this.flash = flash;
    
    // Вывод флеш-сообщения
    function flash (message, type) {
       
        if(!message) return;
        
        type = type || 'warning';
        
        $('.notification_box').remove();
        
        $('.content').before('<div class="notification_box ' + type + '">' + message + '</div>');
   }
}
(function(){
    common = new common();
})();