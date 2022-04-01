/**
 * $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
        }
    });
 */

var OPERATION_SUCCESS = "#operation_success_msg";
var OPERATION_FAIL = "#operation_alert_msg";

$(document).ready(function () {
    $("#table_operations").DataTable();
    $(".om").keyup(onChangeFunction);
});

function onChangeFunction() {
    $("#operationModuleSave").css("display", "inline-block");
}

$("#operationModuleSave").click(function () {
    if (!$("#Operation_Name").val()) {
        slideAlert("Please provide a name for this operation.", OPERATION_FAIL);
        return;
    } else if (!$("#Default_WorkCenter").val()) {
        slideAlert("A default work center is required.", OPERATION_FAIL);
        return;
    }

    if (!$("#Description").val()) {
        slideAlert("Please fill up the Description.", OPERATION_FAIL);
        return;
    }

    $("#operationModuleForm").submit();
});

$("form[name='deleteOperation']").submit(function () {
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
            console.log("success");
        },
    });
    return false;
});

$(".mr-delete-form").each(function () {
    // element == this
    $(this).click(function () {
        var form = $(this).parent().find("form[name='deleteOperation']");
        form.submit();
    });
});

$("#operationModuleForm").submit(function () {
    var formData = new FormData(this);
    var url = $(this).attr("action");
    if ($("#hiddenOpId").val()) {
        formData.append("id", $("#hiddenOpId").val());
        url = `operations/${$("#hiddenOpId").val()}`;
    }
    $.ajax({
        type: $(this).attr("method"),
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            operationtable();
        },
    });
    return false;
});
