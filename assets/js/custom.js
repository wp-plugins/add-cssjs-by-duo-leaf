jQuery(document).ready(function () {

    if (jQuery("#resourceID").val() === "0")
        fillAttributesField('CSS');

    jQuery("#resourceType").change(function () {
        fillAttributesField(jQuery('option:selected', this).text());
    });

    jQuery('#confirm-delete').on('show.bs.modal', function (e) {
        jQuery(this).find('.btn-ok').attr('href', jQuery(e.relatedTarget).data('href'));
    });

});

function fillAttributesField(optionType) {
    if (optionType === 'CSS') {
        jQuery('#resourceAttributes').val('type=\'text/css\' media=\'all\'');
    }
    else if (optionType === 'Javascript') {
        jQuery('#resourceAttributes').val('type=\'text/javascript\'');
    }
}




  