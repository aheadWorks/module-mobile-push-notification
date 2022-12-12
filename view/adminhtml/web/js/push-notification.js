require(["jquery"],function ($) {
    $(document).ready(function () {
        setTimeout(function() {
            $(".aw-message-title input").keyup(function () {
                $("#previewtext").html($(this).val());
            });
            $(".aw-message textarea").keyup(function () {
                $("#previewmsg").html($(this).val());
            });
        }, 2000);
    });
});
