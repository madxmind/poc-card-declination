// Gestion multiple des collections (CollectionType prototype)
$(document).on('click', '.collection-add', (e) => {
    let collection = $('#' + e.currentTarget.dataset.collection);
    collection.prepend(collection.data('prototype').replace(/__name__/g, collection.data('index')));
    collection.data('index', collection.data('index') + 1);
});
$(document).on('click', '.collection-item-delete', (e) => {
    $(e.currentTarget).closest('.collection-item-container').remove();
});
$('.custom-file-input').on('change', function(e) {
    if (e.currentTarget.files) {
        $(e.currentTarget).parent().find('.custom-file-label').html(e.currentTarget.files[0].name);
    }
});
// ---------------------