require(["jquery"],function ($) {
    $(document).ready(function () {
        $("#message_title").keyup(function () {
            $("#previewtext").html($(this).val());
        });
        $("#message").keyup(function () {
            $("#previewmsg").html($(this).val());
        });
    });
});
