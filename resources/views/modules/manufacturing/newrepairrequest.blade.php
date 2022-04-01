
<form id="makeRepairForm" method="POST" enctype="multipart/form-data" action="#">
@csrf
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
   <div class="container-fluid">
      <h2 class="navbar-brand" style="font-size: 35px;">New Repair Request</h2>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#responsive">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="responsive">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item li-bom">
               <button class="btn btn-refresh" style="background-color: #d9dbdb;" onclick="repairtable();">Cancel</button>
            </li>
            <li class="nav-item li-bom">
               <button style="background-color: #007bff;" class="btn btn-info btn" style="float: left;" type='submit' onclick="repairtable();">Save</button>
            </li>
         </ul>
      </div>
   </div>
</nav>
<div class="card">
   <div class="card-body ml-auto">
   </div>
</div>
   <div id="accordion">
      <div class="card">
         <div class="card-header" id="headingOne">
            <h5 class="mb-0">
               <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
               Repair Details
               </button>
            </h5>
         </div>
         <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Repair ID</label>
                        <input type="text" name="wclaim_id" id="wclaim_id" class="form-control" disabled>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Customer</label>
                        <input list="customers" class="form-input form-control" name="customer_id" onchange="customerChange(this)" autocomplete="off">
                        <datalist id="customers">
                           @foreach ($customers as $row)
                           <option value="{{ $row->id }}"> {{ $row->customer_lname }}
                              {{ $row->customer_fname }} 
                           </option>
                           @endforeach
                        </datalist>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-control" required="true" name="repair_status"  id="repair_status" required>
                           <option value="Open">Open</option>
                           <option value="Repaired">Repaired</option>
                           <option value="Work in Progress">Work in Progress</option>
                           <option value="Cancelled">Cancelled</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Serial No.</label>
                        <select id="serial_no" name="serial_number" required class="form-control" onchange="setProductWarrantyDetails(this)" >
                           <option value="" selected disabled hidden>Select Serial</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Issue Date</label>
                        <input type="date" min="<?php echo date("Y-m-d"); ?>" name="issue_date" id="issue_date" class="form-control" required>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="purpose">Issue</label>
                        <textarea id="issue_desc" class="summernote" name="issue_desc"></textarea>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
               <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
               Product and Warranty Details
               </button>
            </h5>
         </div>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Warranty / AMC Status</label>
                        <input type="text" name="warranty_status" id="warranty_status" class="form-control" readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Warranty Expiry Date</label>
                        <input type="date" min="<?php echo date("Y-m-d"); ?>" name="warranty_expiry_date" id="warranty_expiry_date" readonly class="form-control" readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Description</label>
                        <input type="text" name="warranty_desc" id="warranty_desc" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">AMC Expiry Date</label>
                        <input type="date" min="<?php echo date("Y-m-d"); ?>" name="warranty_expiry_date" id="amc_expiry_date" readonly class="form-control">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" id="headingThree">
            <h5 class="mb-0">
               <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
               Resolution
               </button>
            </h5>
         </div>
         <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Resolution Date</label>
                        <input type="date" min="<?php echo date("Y-m-d"); ?>" name="resolution_date" id="resolution_date" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Resolved By</label>

                        <input list="employees" class="form-input form-control" name="employee_id" autocomplete="off">
                        <datalist id="employees">
                           @foreach ($employees as $row)
                           <option value="{{ $row->employee_id }}"> 
                              {{ $row->last_name }} {{ $row->first_name }} - {{$row->position}}
                           </option>
                           @endforeach
                        </datalist>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label for="purpose">Resolution Details</label>
                        <textarea class="form-control" name="resolution_details" id="exampleFormControlTextarea1" rows="3"></textarea>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" id="headingThree">
            <h5 class="mb-0">
               <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
               Customer Details
               </button>
            </h5>
         </div>
         <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Customer Name</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Branch Name</label>
                        <input type="text" name="branch_name" id="branch_name" class="form-control" readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Contact No.</label>
                        <input type="text" name="contact_no" id="contact_no" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Address</label>
                        <input type="text" name="address" id="address" class="form-control" readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Email Address</label>
                        <input type="text" name="email" id="email" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="purpose">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" readonly>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" id="headingThree">
            <h5 class="mb-0">
               <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
               More Information
               </button>
            </h5>
         </div>
         <div id="collapseFive" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
               <div class="form-group col-md-12">
                  <textarea id="Description" class="summernote" name="Description"></textarea>
               </div>
            </div>
         </div>
      </div>
   </div>

    <input type="text" name="sales_id" id="sales_id" class="form-control" hidden>
</form>


<script>
$(document).ready(function () {
    $("#table_operations").DataTable();
    $('.summernote').summernote({
        height: 200
    });
    $('#myTimeline').verticalTimeline({
        startLeft: false,
        alternate: false,
        arrows: false
    });
});


function customerChange(elem){
  customer_id = elem.value
  data= {}
  data['customer_id'] = customer_id

  $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
  $.ajax({
        url: "/getSerials",
        type: "POST",
        data: data,
        success: function (response) {
            selected = document.getElementById('serial_no')
            $("#serial_no").empty();

            response.forEach((sns) => {
                var opt = document.createElement('option');
                opt.value = sns['serial_no'];
                opt.innerHTML = sns['serial_no'] + " " + sns['product_code'];
                selected.appendChild(opt);
            });

        },
        error: function (response, error) {
            // alert("Request: " + JSON.stringify(request));
        },
  });

  $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
  $.ajax({
        url: "/getCustomerDetails",
        type: "POST",
        data: data,
        success: function (response) {
          $("#customer_name").val(response['customer_lname'] +" "+  response['customer_fname'])
          $("#branch_name").val(response['branch_name'])
          $("#contact_no").val(response['contact_number'])
          $("#address").val(response['address'])
          $("#email").val(response['email_address'])
          $("#company_name").val(response['company_name'])
        },
        error: function (response, error) {
            // alert("Request: " + JSON.stringify(request));
        },
  });
}

function setProductWarrantyDetails(elem){
  serial_no = elem.value
  data={}
  data['serial_no'] = serial_no
  $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
  });
  $.ajax({
        url: "/getSerialWithWarranty",
        type: "POST",
        data: data,
        success: function (response) {
            console.log(response);
            $("#product_code").val(response[0]['product_code'])
            $("#warranty_status").val('')
            $("#product_name").val(response[0]['product_code'])
            //Check date if expired
            //$("#warranty_expiry_date").val(response[0]['warranty_end_date'])
            var resDate = new Date(response[0]['warranty_end_date'])
            var jsDate = new Date();
            if (resDate < jsDate){
               $("#warranty_status").val("Warranty Expired")
               $("#warranty_expiry_date").val(response[0]['warranty_end_date'])
               $("#warranty_expiry_date").removeClass().addClass('form-control bg-warning');
            }else{
               $("#warranty_status").val("In Warranty")
               $("#warranty_expiry_date").val(response[0]['warranty_end_date'])
               $("#warranty_expiry_date").removeClass().addClass('form-control bg-success');
            }
            //warranty_expiry_date
            $("#description").val('')
            $("#amc_expiry_date").val(response[0]['amc_expiry_date'])
            $("#sales_id").val(response[0]['sales_id'])
        },
        error: function (response, error) {
            // alert("Request: " + JSON.stringify(request));
        },
  });
}

$('#makeRepairForm').submit(function(e){
  e.preventDefault();
  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
       }
  });
  var formData = new FormData(this);
  
  $.ajax({
      type:'POST',
      url:"/createRepair",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
          console.log(data)
      },
      error: function(data) {
          console.log(data)
      }
  });
});

</script>