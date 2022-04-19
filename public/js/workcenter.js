var WC_SUCCESS = "#wc_success_msg";
var WC_FAIL = "#wc_alert_msg";

$(document).ready(function () {
    empSearchFunction();
});

function empSearchFunction() {
    $(".id_field").each(function() {
        $(this).change(function() {
            // if($(this).val() !== $(".id_field").val()) {
                
            // }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                }
            });
            var name_field = $(this).parent().siblings('.e_name').find('.name_field');
            $.ajax({
                type: 'GET',
                url: `/getEmployeeDetails/${$(this).val()}`,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    var name_string = response.last_name + ", " + response.first_name;
                    name_field.val(name_string);
                }
            });
        });
    });
}

function checkWC() {
    msg = 'Work Center created!';
    alert = WC_SUCCESS;

    flag = $("#Work_Center_label").val() === '' || $("#wc_select").val() === 'N/A';

    if (flag) {
        alert = WC_FAIL;
        if ($("#Work_Center_label").val() === '') msg = "No label indicated for work center.";
        if ($("#wc_select").val() === 'N/A') msg = "No type indicated for work center.";
    }

    if ($("#wc_select").val().includes("Human") && !checkEmployees()) {
        msg = "Incomplete data provided for employees.";
        alert = WC_FAIL;
    }

    if ($("#wc_select").val().includes("Machine") && !$("#Available_Machine").val()) {
        msg = "Must indicate a Machine for this Work Center.";
        alert = WC_FAIL;
    }

    $(".hour_rate_compu").each(function () {
        // element == this
        if ($(this).val() === '0') {
            msg = "Computation of hour rate is incomplete."
            alert = WC_FAIL;
        }
    });

    slideAlert(msg, alert);
    return (alert === WC_SUCCESS) ? true : false;

}

function checkEmployees() {
    var check = true;
    $(".wc_employee").each(function () {
        // element == this
        if (!$(this).val()) {
            check = false;
        }
    });
    return check;
}

$("#wc_select").change(function (e) { 

    var choice = $(this).val();
    if (choice === 'N/A') resetTypeTable();
    else if (choice === "Human") resetTypeTable("EMPLOYEE");
    else if (choice === "Machine") resetTypeTable("MACHINE");
    
});

$("form[name='deleteWC']").submit(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
        }
    });
    $.ajax({
        type: "DELETE",
        url: $(this).attr('action'),
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("success");
        }
    });
    return false;
});

$("#save_wc").click(function () {
    if (checkWC()) {
        $("#newworkcenter").submit();
    }
});

$("#newworkcenter").submit(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN, //protection :>
        }
    });

    var formData = new FormData();
    formData.append('wc_label', $("#Work_Center_label").val());
    formData.append('wc_type', $("#wc_select").val());
    formData.append('prod_cost', $("#Production_Capacity").val());
    formData.append('elec_cost', $("#Electricity_Cost").val());
    formData.append('con_cost', $("#Consumable_Cost").val());
    formData.append('rent_cost', $("#Rent_Cost").val());
    formData.append('wages', $("#Wages").val());
    formData.append('hour_rate', $("#Hour_rate").val());

    var hrs = document.getElementById("Employee_hours").value;
    var mins = document.getElementById("Employee_minutes").value;
    var sec = document.getElementById("Employee_seconds").value;

    var time = hrs + ":" + mins + ":" + sec;

    formData.append('duration', time);

    if ($("#wc_select").val().includes("Human")) {
        var employee_id_set = {};
        for (let i = 1; i <= $("#newemployee-input-rows tr").length; i++) {
            let employee_data = $(`#employee-${i}`);
            let emp_id = employee_data.find("#Employee_id").val();
            employee_id_set[i] = {
                'employee_id': emp_id,
                'e_hours': employee_data.find("#Employee_hours").val(),
                'e_min' : employee_data.find("#Employee_minutes").val(),
                'e_sec' : employee_data.find("#Employee_seconds").val(),
            }
        }
        formData.append('employee_id_set', JSON.stringify(employee_id_set));
    }

    if ($("#wc_select").val().includes("Machine")) { 
        formData.append('machine_code', $("#Available_Machine").val());
    }

    $.ajax({ //jqajax & jqattrget
        type: $("#newworkcenter").attr("method"),
        url: $("#newworkcenter").attr("action"),
        data: formData,
        contentType: false, //to successfully store data in laravel
        processData: false,
        success: function (response) {
            console.log("success");
            loadworkcenterlist();
        }
    });
})

$("#Available_Machine").change(function () {
    var machine_code = $(this).val(); //jqvalget

    if (machine_code == "n/a") { //to remove values if there's no option
        $("#machine_process").val(null);
        $("#setup_time").val(null);
        $("#Running_time").val(null);
    }

    $.ajax({ //jqajax
        type: "get",
        url: `/find-machine/${machine_code}`, //interpolation
        data: machine_code,
        success: function (response) {
            var machine = response.machine;
            $("#machine_process").val(machine.machine_process); //to get specific column
            $("#setup_time").val(machine.setup_time);
            $("#Running_time").val(machine.running_time);
        }
    });
});

$(".hour_rate_compu").change(function (e) {
    var sum = parseFloat($("#Electricity_Cost").val()) + parseFloat($("#Consumable_Cost").val()) + parseFloat($("#Rent_Cost").val()) + parseFloat($("#Wages").val());
    $("#Hour_rate").val(sum);
    e.preventDefault();

});

function resetTypeTable(choice = 'DEFAULT') {
    if (choice == "DEFAULT") {
        resetWCEmployees();
        resetWCMachine();
    }
    else if (choice == "MACHINE") {
        resetWCEmployees();
    }
    else if (choice = "EMPLOYEE") {
        resetWCMachine();
    }
}

function resetWCEmployees() {
    $(".newemployee-row").remove();
    $('#newemployee-input-rows').append(
        `
        <tr id="employee-1" class="newemployee-row">
            <td id="mr-code-input" class="mr-code-input e_id"><input type="text" name="Employee_id"
                list="employees" id="Employee_id" class="form-control wc_employee id_field">
            </td>
            <td class="mr-qty-input e_name" class="mr-code-input"><input type="text" value=""
                    name="Employee_name" id="Employee_name" class="form-control wc_employee name_field">
            </td>
            <td style="width: 15%;" class="mr-qty-input"><input type="number" min="0" value=""
                    name="Employee_hours" id="Employee_hours" class="form-control wc_employee"></td>
            <td style="width: 15%;" class="mr-qty-input"><input type="number" min="0" value=""
                    name="Employee_minutes" id="Employee_minutes" class="form-control wc_employee"></td>
            <td style="width: 15%;" class="mr-qty-input"><input type="number" min="0" value=""
                    name="Employee_seconds" id="Employee_seconds" class="form-control wc_employee"></td>
            <td>
                <a id="" class="btn delete-btn" href="#" role="button">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        `);
}

function resetWCMachine() {
    $('.wc_machine').val(null);
    $("#Available_Machine").val('n/a');
}

function addRownewEmployee() {
    if ($('#no-data')[0]) {
        deleteItemRow($('#no-data').parents('tr'));
    }
    //let lastRow = $('#newemployee-input-rows tr:last');
    let nextID = $("#newemployee-input-rows tr").length + 1;
    $('#newemployee-input-rows').append(
        `
    <tr id="employee-${nextID}" class="newemployee-row">
        <td id="mr-code-input" class="mr-code-input e_id"><input type="text" name="Employee_id"
            list="employees" id="Employee_id" class="form-control wc_employee id_field">
        </td>
        <td class="mr-qty-input e_name" class="mr-code-input"><input type="text" value=""
                name="Employee_name" id="Employee_name" class="form-control wc_employee name_field">
        </td>
        <td style="width: 15%;" class="mr-qty-input"><input type="number" min="0" value=""
                name="Employee_hours" id="Employee_hours" class="form-control wc_employee"></td>
        <td style="width: 15%;" class="mr-qty-input"><input type="number" min="0" value=""
                name="Employee_minutes" id="Employee_minutes" class="form-control wc_employee"></td>
        <td style="width: 15%;" class="mr-qty-input"><input type="number" min="0" value=""
                name="Employee_seconds" id="Employee_seconds" class="form-control wc_employee"></td>
        <td>
            <a id="" class="btn delete-btn" href="#" role="button">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
    `);
    empSearchFunction();
}

