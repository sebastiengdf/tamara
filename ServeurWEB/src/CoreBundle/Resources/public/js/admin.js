$(function () {
    if ($('.help-block:contains("trans")').hide().closest('.form-group').find('label').before('<i class="fa fa-globe" style="color:#D6261E;"></i>&nbsp;').length == 0) {

        $('.help-block:contains("trans")').hide().closest('div[class*="box box-primary"]').find('h4[class*="box-title"]').before('<i class="fa fa-globe" style="color:#D6261E;"></i>&nbsp;');
    }
    $('label[class|="help-trans"]').append('&nbsp;<i class="fa fa-globe" style="color:#D6261E;"></i>');

    $('.confirm').on('click', function () {
        return confirm('Confirmation ?');
    });
});