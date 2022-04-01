function showForm() {
    var wc_type = $("#wc_select").val();
    if (wc_type == "N/A") {
        $("#f2").css("display", "none");
        $("#f1").css("display", "none");
    }
    if (wc_type.includes("Human")) {
        $("#f1").css("display", "block");
        if (!wc_type.includes("Machine")) $("#f2").css("display", "none");
    }
    if (wc_type.includes("Machine")) {
        $("#f2").css("display", "block");
        if (!wc_type.includes("Human")) $("#f1").css("display", "none");
    }
}

$(function () {
    showForm();
});

/*function addRownewEmployee(){
  if($('#no-data')[0]){
      deleteItemRow($('#no-data').parents('tr'));
  }
  let lastRow = $('#newemployee-input-rows tr:last');
  let nextID = (lastRow.length != 0) ? lastRow.data('id') + 1 : 0;
  $('#newemployee-input-rows').append(
  ` <tr class="text-muted">
  <td class="text-center">Employee Name</td>
  <td class="text-center">Hours</td>
  <td class="text-center">Minutes</td>
  <td class="text-center">Seconds</td>
  <td></td>
</tr>
</thead>
<tbody class="" id="newemployee-input-rows">
<tr data-id="${nextID}">
<td id="mr-code-input" class="mr-code-input"><input type="text" value=""   name="Employee_name" id="Employee_name" class="form-control"></td>
<td style="width: 10%;" class="mr-qty-input"><input type="number" min="0" value=""  name="Employee_hours" id="Employee_hours" class="form-control"></td>
<td style="width: 10%;" class="mr-qty-input"><input type="number" min="0" value=""  name="Employee_minutes" id="Employee_minutes" class="form-control"></td>
<td style="width: 10%;" class="mr-qty-input"><input type="number" min="0" value=""  name="Employee_seconds" id="Employee_seconds" class="form-control"></td>
<td>
<a id="" class="btn delete-btn" href="#" role="button">
<i class="fa fa-trash" aria-hidden="true"></i>
</a>
</td>
</tr>`);
}
*/
