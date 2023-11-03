$(function () {
    $('.sonata-ba-list tr').attr('id', function () {
        return 'objectid-' + $(this).find('td').first().attr('objectid');
    });

    $('.sonata-ba-list tbody').sortable({
        stop: function (event, ui) {
            var source = ui.item.first();
            var data = {
                'sourceId': source.attr('id'),
                'destId': source.next().attr('id'),
                'entityClass': '{{ addslashes(admin.class) }}'
            };
            $.ajax({
                type: 'POST',
                url: Routing.generate('cms_core_admin_sortable'),
                data: data,
                dataType: 'json'
            }).success(function () {
                $('.content').prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Position mise à jour</div>');
            });
        }
    });
});
