const baseUrl = $('meta[name="baseUrl"]').attr('content');
const csrfToken = $('meta[name="csrfToken"]').attr('content');

$(document).on("click", "[data-toggle='modal']", function(e) {
    var elm = $(this);
    var target = elm.data('target');

    $(`${target}`).addClass('show');
});

$(document).on("click", "[data-modal='close']", function(e) {
    var elm = $(this);
    var target = elm.data('target');

    $(`${target}`).removeClass('show');
});
