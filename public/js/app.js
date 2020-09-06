$(document).ready(function() {
    if (document.querySelector('#bloc_attribute_categories')) {
        selectGammes();
    }
});

$('#bloc_attribute_categories').on('change', '.select-attribute', function () {
    selectGammes($(this).data('attributeCategoryId'));
});
$('#bloc_attribute_categories').on('click', '.image-attribute', function(e){
    e.preventDefault();
    if(!$(this).hasClass('selected')) {
        $('.image-attribute').removeClass('selected');
        $('.image-attribute img').removeClass('rounded-circle');
        $(this).addClass('selected');
        $(this).find('img').addClass('rounded-circle');

        selectGammes($(this).data('attributeCategoryId'));
    }
});
$('#bloc_add_to_card').on('click', '.add-to-card', function(e){
    e.preventDefault();
    $.ajax({
        url: Routing.generate("add-to-card", {
            product:$('#bloc_add_to_card').data("productId"),
            attributesString:getAttributesString(),
            quantity:$('#bloc_add_to_card').find('.quantity').first().val(),
        }),
        type:'POST',
        dataType:'JSON',
    }).done(function(data){
        if(data.html_add_to_card) {
            $('#bloc_add_to_card').html(data.html_add_to_card);
        }
    });
});

function selectGammes(attributeCategoryId = null)
{
    // Remove previous informations
    if(document.querySelector('.bloc-attribute-category')) {
        $('.bloc-attribute-category').each(function () {
            if($(this).data('attributeNumber') > $('#bloc_attribute_category_' + attributeCategoryId).data('attributeNumber')) {
                $(this).remove();
            }
        });
    }
    $('#bloc_price_product_detail').html('');
    // -----

    $.ajax({
        url: Routing.generate("select-attributes", {
            product:$('#bloc_attribute_categories').data("productId"),
            attributeCategoryId:attributeCategoryId,
            attributesString:getAttributesString()
        }),
        type:'POST',
        dataType:'JSON',
    }).done(function(data){
        $('#bloc_attribute_categories').append(data.html);
        var attributeNumber = $('#bloc_attribute_categories').find('#bloc_attribute_category_' + attributeCategoryId).data('attributeNumber');
        attributeNumber = attributeNumber ? attributeNumber +1 : 1;
        $('#bloc_attribute_categories').find('#bloc_attribute_category_' + data.attributeCategoryId).attr('data-attribute-number', attributeNumber);

        if(data.attributeCategoryId) {
            selectGammes(data.attributeCategoryId);
        } else {
            $.ajax({
                url: Routing.generate("details-declination", {
                    product:$('#bloc_attribute_categories').data("productId"),
                    attributesString:getAttributesString()
                }),
                type:'POST',
                dataType:'JSON'
            }).done(function(data) {
                if(data.html_price) {
                    $('#bloc_price_product_detail').html(data.html_price);
                }
            });
        }
    });
}


function getAttributesString() {
    var attributesString = '';
    if(document.querySelector('.select-attribute')) {
        $('.select-attribute').each(function () {
            attributesString += $(this).val() + '|';
        });
    }
    if(document.querySelector('.image-attribute')) {
        $('.image-attribute.selected').each(function () {
            attributesString += $(this).data('attributeId') + '|';
        });
    }
    if(attributesString != '') {
        attributesString = attributesString.substr(0, attributesString.length - 1);
    }
    return attributesString;
}













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


// For Select User-Frendly Jquery : https://developer.snapappointments.com/bootstrap-select/examples/
$('.collection-item-container select').selectpicker();
$('.multi-select select').selectpicker();
// ---------------------