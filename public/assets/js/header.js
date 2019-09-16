$(document).ready(function() {
    setInterval(timestamp, 1000);
});

function timestamp() {
    $.ajax({
        url: '/timestamp',
        success: function(data) {
            $('#timestamp').html(data);
        },
    });
}
