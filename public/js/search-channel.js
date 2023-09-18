const twitchAccessToken = "ngz6zc4s8xytivzjo7d36p1pprcfyq";
const twitchClientID = "m9e8rsinvg4u59kr7tufkbb51axl0o";

const channelLoader = `
    <div class="channel-loader">
        <img src="${baseUrl}/images/loader.gif" alt="loader">
    </div>
`;

const channelLoadMore = `
    <div class="channel-more">
        Load More
    </div>
`;

var chanPag = '';
var chanQur = '';

$(document).on('keyup', '[name="twitch_channel"]', function(e) {
    e.preventDefault();

    var elm = $(this);
    var twitchChannel = $(".twitch-channels");
    var parent = elm.closest('.twitch-search');

    if (elm.val().length > 0) {
        parent.addClass('open-autocomplete');
        twitchChannel.html(channelLoader);

        chanQur = elm.val()

        $.ajax({
            type: 'GET',
            url: `https://api.twitch.tv/helix/search/channels?query=${chanQur}&first=100`,
            headers: {
                'Authorization': 'Bearer '+twitchAccessToken,
                'Content-Type': 'application/json',
                'Client-ID': twitchClientID,
            },
            success: function(response) {
                let d = response.data;
                chanPag = response.pagination.cursor

                let channelText = '';

                d.map((chann, index) => {
                    channelText += `
                        <div class="channel" data-id="${chann.id}" data-name="${chann.display_name}" data-img="${chann.thumbnail_url}">
                            <div class="channel-thumb">
                                <img src="${chann.thumbnail_url}" alt="Channel" class="img-fluid">
                            </div>
                            <div class="channel-meta">
                                <span class="channel-title">${chann.display_name}</span>
                                <span class="channel-id">${chann.id}</span>
                            </div>
                        </div>
                    `;
                })
                channelText += channelLoadMore
                twitchChannel.html(channelText);
            },
            error: function(xhr, status, error) {
                twitchChannel.html(`
                    <h5>No channel found!</h5>
                `);
            }
        });
    } else {
        parent.removeClass('open-autocomplete');
        twitchChannel.html("");
        // Yahan par validation error likhna hai
    }
});

$(document).on('click', '.channel-more', function(e) {
    e.preventDefault();

    var twitchChannel = $(".twitch-channels");
    $(".channel-more").remove();
    twitchChannel.append(channelLoader);

    $.ajax({
        type: 'GET',
        url: `https://api.twitch.tv/helix/search/channels?query=${chanQur}&first=100&after=${chanPag}`,
        headers: {
            'Authorization': 'Bearer '+twitchAccessToken,
            'Content-Type': 'application/json',
            'Client-ID': twitchClientID,
        },
        success: function(response) {
            let d = response.data;
            chanPag = response.pagination.cursor

            let channelText = '';

            d.map((chann, index) => {
                channelText += `
                    <div class="channel" data-id="${chann.id}" data-name="${chann.display_name}" data-img="${chann.thumbnail_url}">
                        <div class="channel-thumb">
                            <img src="${chann.thumbnail_url}" alt="Channel" class="img-fluid">
                        </div>
                        <div class="channel-meta">
                            <span class="channel-title">${chann.display_name}</span>
                            <span class="channel-id">${chann.id}</span>
                        </div>
                    </div>
                `;
            })
            channelText += channelLoadMore

            $(".channel-loader").remove();
            twitchChannel.append(channelText);
        },
        error: function(xhr, status, error) {

        }
    });
});
