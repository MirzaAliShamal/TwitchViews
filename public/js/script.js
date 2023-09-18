const baseUrl = $('meta[name="baseUrl"]').attr('content');
const csrfToken = $('meta[name="csrfToken"]').attr('content');

var o = $.cookie('twitchChannel');
if (o !== undefined && o !== "") {
    o = JSON.parse(o);

    $(".selected-channel-thumb > img").attr('src', o.channelImg)
    $(".selected-channel-title").html(o.channelName)
    $(".selected-channel-id").html(o.channelId)

    $("[name='twitch_channel']").addClass('d-none');
    $("[name='twitch_channel']").val('');
    $('.twitch-selected').removeClass('d-none');
}

$(document).on('click', '.channel-action', function(e) {
    e.preventDefault();

    $('.twitch-selected').addClass('d-none');
    $("[name='twitch_channel']").val('');
    $("[name='twitch_channel']").removeClass('d-none');

    $.removeCookie('twitchChannel', { path: '/' });
});

const fireSearchError = () => {
    var messageDiv = $(".search-error-wrapper");
    messageDiv.show();
    setTimeout(function() { messageDiv.hide(); }, 3000);
}

$(document).on('click', '.channel', function(e) {
    e.preventDefault()

    var channelId = $(this).data('id');
    var channelName = $(this).data('name');
    var channelImg = $(this).data('img');

    var o = {
        channelId: channelId,
        channelName: channelName,
        channelImg: channelImg,
    }

    $.cookie('twitchChannel', JSON.stringify(o), {
        expires: 1000,
        path: '/',
    });

    $(".selected-channel-thumb > img").attr('src', channelImg)
    $(".selected-channel-title").html(channelName)
    $(".selected-channel-id").html(channelId)

    $("[name='twitch_channel']").addClass('d-none');
    $("[name='twitch_channel']").val('');
    $(".twitch-search-autocomplete").hide();
    $(".twitch-search").removeClass('open-autocomplete');
    $('.twitch-selected').removeClass('d-none');
});

$(document).on('submit', '.twitch-search', function(e) {
    e.preventDefault();

    var input = $("[name='twitch_channel']");
    var button = $(".twitch-search-button");
    var btnText = button.html();

    var o = $.cookie('twitchChannel');

    if (o == undefined || o == "") { fireSearchError(); return false; }

    button.prop('disabled', true)
    button.html(`
        <span class="btn-loader"></span>
        <span>Loading...</span>
    `);

    window.location = $(this).attr('action');
    return false;
})
