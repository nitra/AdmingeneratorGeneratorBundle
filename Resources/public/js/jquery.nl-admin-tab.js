jQuery.fn.tab = function() {
    $('.nav-tabs li a').click(function() {
        showFieldsetsForTab($(this).attr('data-target'));
    });
    function showFieldsetsForTab(name)
    {
        $('.admin_form fieldset.fieldset_tabbable').css('display', 'none');
        $('.form_tabs li').removeClass('active');
        $(name).css('display', 'block');
        $('.nav-tabs li a[data-target="' + name + '"]').parent('li').addClass('active');
    }
    showFieldsetsForTab($(this).attr('data-target'));
};