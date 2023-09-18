var historyLoader = `
    <div class="history-loader">
        <img src="${baseUrl}/images/ajax-loader.gif" alt="">
    </div>
`;

var noRecord = `
    <div class="no-record">
        <img src="${baseUrl}/images/no-record.png" alt="No Record">
        <p class="font-weight-700">You have no order history</p>
        <a href="${baseUrl}" class="btn-primary btn-sm">New Order</a>
    </div>
`;

$(document).on("keyup", "input", function(e) {
    let elm = $(this);
    let elmId = elm.attr('id');
    let errorLabelId = elmId+"-error";
    if (elm.hasClass('required')) {
        let parent = elm.closest("div.form-group");

        if (elm.val().length > 0) {
            elm.removeClass('error');
            $("#"+errorLabelId).remove();
        } else {
            elm.addClass('error');
            if (parent.children('label.error-label').length == 0) {
                parent.append(`<label id="${errorLabelId}" class="error-label">Required</label>`);
            }
        }
    }
});

var e = $.cookie('email');
if (e !== undefined && e !== "") {
    $(".dashboard-content").html(historyLoader);

    $.ajax({
        type: "GET",
        url: baseUrl+"/history",
        data: {
            email: e,
        },
        success: function (response) {
            $(".dashboard-content").html(response.result);
        },
        error: function(xhr, status, error) {
            console.log(error)
            $(".dashboard-content").html(noRecord);
        }
    });
} else {
    $(".dashboard-content").html(noRecord);
}

$(document).on('click', 'a.page-link', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('?')[1].split('=');

    $(".dashboard-content").html(historyLoader);

    $.ajax({
        type: "GET",
        url: baseUrl+"/history",
        data: {
            page: page['1'],
            email: e,
        },
        success: function (response) {
            $(".dashboard-content").html(response.result);
        },
        error: function(xhr, status, error) {
            console.log(error)
            $(".dashboard-content").html(noRecord);
        }
    });
});

$(document).on("click", ".historyFetch", function(e) {
    var button = $(this);
    var btnText = button.html();

    button.prop('disabled', true)
    button.html(`
        <span class="btn-loader"></span>
        ${btnText}
    `);

    var email = $("[name='email']");

    if (email.val().length <= 0) {
        email.trigger('keyup')
    }

    if ($(".fetch-history .error").length > 0) {
        button.prop('disabled', false)
        button.html(btnText);

        return false;
    } else {
        $.ajax({
            type: "GET",
            url: baseUrl+"/history",
            data: {
                email: email.val(),
            },
            success: function (response) {
                $.cookie('email', email.val(), { expires: 1000, path: '/', });
                button.prop('disabled', false)
                button.html(btnText);
                $("#fetchHistory .modal-close").trigger('click');

                $(".dashboard-content").html(response.result);
            },
            error: function(xhr, status, error) {
                console.log(error)

                button.prop('disabled', false)
                button.html(btnText);
                $("#fetchHistory .modal-close").trigger('click');

                $(".dashboard-content").html(noRecord);
            }
        });
    }
});
