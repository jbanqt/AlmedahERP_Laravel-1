var MM_SUCCESS = "#mm_success_message";
var MM_FAIL = "#mm_alert_message";

$(document).ready(function () {
    $(".mm").keyup(onChangeFunction);
});

function onChangeFunction() {
    $("#saveMMBtn").css("display", "inline-block");
}

$("#mmDelete").click(function () {
    $("#deleteMM").submit();
});

$("#deleteMM").submit(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": CSRF_TOKEN,
        },
    });
    $.ajax({
        type: "DELETE",
        url: $(this).attr("action"),
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            loadmachine();
        },
    });
    return false;
});

$("#saveMMBtn").click(function () {
    var fields = document.getElementsByClassName("mm");
    for (var i = 0; i < fields.length; i++) {
        if (fields.item(i).value == "") {
            slideAlert("Empty field/s have been detected.", MM_FAIL);
            return false;
        }
    }
    $("#mmForm").submit();
});

$("#mmForm").submit(function () {
    var formData = new FormData(this);
    //formData.append($("#Machine_Image").val());

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            slideAlert("Record saved!", MM_SUCCESS);
            loadmachine();
        },
    });

    return false;
});
