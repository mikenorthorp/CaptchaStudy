// This function takes the start time when the page is loaded and the end time
// when the page is closed and sends the time to a timer.php script
$(function() {
    var start = null;
    // Get start time on window load
    $(window).load(function(event) {
        start = event.timeStamp;
    });
    // Get end time on window close
    $(window).unload(function(event) {
        var time = event.timeStamp - start;
        var captcha = "first";
        $.post('timer.php', {time: time, captcha: captcha});
    })
});