tippy('[data-toggle="tooltip"]', {
    maxWidth: '200',
    trigger: 'click',
    content(reference) {
        const id = reference.getAttribute('data-template');
        const template = document.getElementById(id);
        return template.innerHTML;
    },
    allowHTML: true,
});

var currencyConversion = 0;
$.ajax({
    type: "GET",
    url: "https://ssl.geoplugin.net/json.gp?k=11ad8b36bf7360d4&baseCurrency=USD",
    success: function (response) {
        currencyConversion = response.geoplugin_currencyConverter;
    }
});

var channelThumb = `${baseUrl}/images/twitchviews-logo-light.png`;
var channelName = '';
var channelID = '';

var o = $.cookie('twitchChannel');
if (o !== undefined && o !== "") {
    o = JSON.parse(o);

    channelThumb = o.channelImg
    channelName = o.channelName
    channelID = o.channelId

    $(".order-channel-img > img").attr('src', channelThumb)
    $(".order-channel > strong").html(channelName)
}

var e = $.cookie('email');
if (e !== undefined && e !== "") {
    $("[name='email']").val(e)
}


const calcTotal = () => {
    var cost = 6;
    var views = $("[name='views']").val();

    var charge = (Number(views) / 1000) * cost;
    $(".original-amount").html(`$${charge.toFixed(2)}`);
    $(".order-account > h3").html(`$${charge.toFixed(2)}`);

    if (currencyConversion > 0) {
        var pkrAmnt = currencyConversion * charge;
        $(".converted-amount").html(`Approx. PKR ${pkrAmnt.toFixed(2)}`)
    };
}

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

$(document).on("change", "input[type='checkbox']", function(e) {
    let elm = $(this);
    let elmId = elm.attr('id');
    let errorLabelId = elmId+"-error";
    if (elm.hasClass('required')) {
        let parent = elm.closest("div.form-group");

        if (elm.is(":checked")) {
            elm.removeClass('error');
            $("#"+errorLabelId).remove();
        } else {
            elm.addClass('error');
            if (parent.children('label.error').length == 0) {
                parent.append(`<label id="${errorLabelId}" class="error-label">You must agree to our terms and conditions below to continue</label>`);
            }
        }
    }
});


$(document).on("click", ".confirm-details", function(e) {
    var button = $(this);
    var btnText = button.html();

    button.prop('disabled', true)
    button.html(`
        <span class="btn-loader"></span>
        ${btnText}
    `);

    var views = $("[name='views']");
    var viewer_count = $("[name='viewer_count']");
    var join_delay = $("[name='join_delay']");

    if (views.val().length <= 0) {
        views.addClass('error');
        if (views.closest("div.form-group").children('label.error-label').length == 0) {
            views.closest("div.form-group").append(`<label id="views-error" class="error-label">Required</label>`);
        }
    } else if (views.val() < 1000) {
        views.addClass('error');
        if (views.closest("div.form-group").children('label.error-label').length == 0) {
            views.closest("div.form-group").append(`<label id="views-error" class="error-label">Views must be greater than 1000</label>`);
        }
    } else if (views.val() > 300000) {
        views.addClass('error');
        if (views.closest("div.form-group").children('label.error-label').length == 0) {
            views.closest("div.form-group").append(`<label id="views-error" class="error-label">Views must be less than 300000</label>`);
        }
    } else if (views.val() % 100 != 0) {
        views.addClass('error');
        if (views.closest("div.form-group").children('label.error-label').length == 0) {
            views.closest("div.form-group").append(`<label id="views-error" class="error-label">Views must be multiple of 100</label>`);
        }
    }

    if (viewer_count.val().length <= 0) {
        viewer_count.addClass('error');
        if (viewer_count.closest("div.form-group").children('label.error-label').length == 0) {
            viewer_count.closest("div.form-group").append(`<label id="viewer_count-error" class="error-label">Required</label>`);
        }
    } else if (viewer_count.val() < 5) {
        viewer_count.addClass('error');
        if (viewer_count.closest("div.form-group").children('label.error-label').length == 0) {
            viewer_count.closest("div.form-group").append(`<label id="viewer_count-error" class="error-label">Viewers must be greater than 5</label>`);
        }
    } else if (viewer_count.val() > 30000) {
        viewer_count.addClass('error');
        if (viewer_count.closest("div.form-group").children('label.error-label').length == 0) {
            viewer_count.closest("div.form-group").append(`<label id="viewer_count-error" class="error-label">Viewers must be less than 30000</label>`);
        }
    }

    if (join_delay.val().length <= 0) {
        join_delay.addClass('error');
        if (join_delay.closest("div.form-group").children('label.error-label').length == 0) {
            join_delay.closest("div.form-group").append(`<label id="join_delay-error" class="error-label">Required</label>`);
        }
    } else if (join_delay.val() > 240) {
        join_delay.addClass('error');
        if (join_delay.closest("div.form-group").children('label.error-label').length == 0) {
            join_delay.closest("div.form-group").append(`<label id="join_delay-error" class="error-label">Join Delay must be less than 240</label>`);
        }
    } else if (join_delay.val() % 5 != 0) {
        join_delay.addClass('error');
        if (join_delay.closest("div.form-group").children('label.error-label').length == 0) {
            join_delay.closest("div.form-group").append(`<label id="join_delay-error" class="error-label">Join Delay must be multiple of 5</label>`);
        }
    }

    button.prop('disabled', false)
    button.html(btnText);

    if ($(".your-order .error").length > 0) {
        return false;
    } else {
        $('html, body').animate({
            scrollTop: $("#paymentDetails").offset().top
        }, 2000);
    }
});

$(document).on("click", ".confirm-payment", function(e) {
    var button = $(this);
    var btnText = button.html();

    button.prop('disabled', true)
    button.html(`
        <span class="btn-loader"></span>
        ${btnText}
    `);

    var email = $("[name='email']");
    var agree = $("[name='agree']");

    if (email.val().length <= 0) {
        email.addClass('error');
        if (email.closest("div.form-group").children('label.error-label').length == 0) {
            email.closest("div.form-group").append(`<label id="email-error" class="error-label">Required</label>`);
        }
    }

    if (!agree.is(":checked")) {
        agree.addClass('error');
        if (agree.closest("div.form-group").children('label.error-label').length == 0) {
            agree.closest("div.form-group").append(`<label id="agree-error" class="error-label">You must agree to our terms and conditions below to continue</label>`);
        }
    }

    if ($(".payment-details .error").length > 0) {
        button.prop('disabled', false)
        button.html(btnText);

        return false;
    } else {
        var views = $("[name='views']");
        var viewer_count = $("[name='viewer_count']");
        var join_delay = $("[name='join_delay']");

        if (views.val().length <= 0) {
            views.trigger('keyup')
        }

        if (viewer_count.val().length <= 0) {
            viewer_count.trigger('keyup')
        }

        if (join_delay.val().length <= 0) {
            join_delay.trigger('keyup')
        }

        if ($(".your-order .error").length > 0) {
            button.prop('disabled', false)
            button.html(btnText);

            return false;
        } else {
            $.ajax({
                type: "POST",
                url: baseUrl+"/place-order",
                data: {
                    _token: csrfToken,
                    email: email.val(),
                    views: views.val(),
                    viewer_count: viewer_count.val(),
                    join_delay: join_delay.val(),
                    channelName: o.channelName,
                    channelID: o.channelId,
                    channelImg: o.channelImg
                },
                success: function (response) {
                    $.cookie('email', email.val(), { expires: 1000, path: '/', });
                    window.location = response.redirect_url;
                },
                error: function(xhr, status, error) {
                    button.prop('disabled', false)
                    button.html(btnText);
                }
            });
        }
    }
});
