$(function () {

    $('body').on('click', '#get-next-items', function () {
        var data = {
            'manager': $('#archive').data('manager'),
            'offset': $('#archive .item').length,
            'slug': $('#archive').data('slug'),
            '_locale': $('#archive').data('locale')
        }
        $.ajax({
            type: 'GET',
            url: Routing.generate('cms_ajax_get_next_items', data),
            dataType: 'json',
            success: function (json) {
                $('#archive').append(json['html']);
                if (json['stop']) {
                    $('#get-next-items').remove();
                    $('#stop-next-items').show();
                }
            }
        });
    });


    $(".fancybox").fancybox({
        prevEffect: 'none',
        nextEffect: 'none',
        closeBtn: false,
        helpers: {
            title: {type: 'inside'},
            buttons: {},
            thumbs: {
                width: 50,
                height: 50
            }
        }
    });

    $('.fancybox-media').fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        helpers: {
            media: {}
        }
    });

    $('body').on('click','.link-ajax', function (e) {
        var self = $(this);
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: $(this).attr('href'),
            success: function (response) {
                if(self.data('size')) {
                    $('#main-modal .modal-dialog').addClass('modal-'+self.data('size'));
                }
                $('#main-modal').modal();
                $('#main-modal .modal-body').html(response);
            }
        });
    });
});

$(function () {

});


jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch([
                    "assets/img/2.jpg"
	              , "assets/img/3.jpg"
	              , "assets/img/1.jpg"
	             ], {duration: 3000, fade: 750});
});
