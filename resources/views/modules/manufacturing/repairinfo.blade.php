<form id="editRepairForm" method="POST" enctype="multipart/form-data" action="#">
@csrf
@method('PATCH')
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
   <div class="container-fluid">
      <h2 class="navbar-brand" style="font-size: 35px;">Repair Request Info</h2>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#responsive">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="responsive">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item li-bom">
               <button class="btn btn-refresh" style="background-color: #d9dbdb;" type="submit" onclick="repairtable();">Cancel</button>
            </li>
            <li class="nav-item li-bom">
               <button style="background-color: #007bff;" class="btn btn-info btn" style="float: left;" onclick="repairtable();" type='submit'>Save</button>
            </li>
         </ul>
      </div>
   </div>
</nav>

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
                     <input type="text" name="wclaim_id" id="wclaim_id" class="form-control" value="{{$warranty_claims->wclaim_id }}" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Customer</label>
                     <input type="text" name="customer" id="customer" class="form-control" value="{{$warranty_claims->customer_name }}" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="">Status</label>
                     <select class="form-control" required="true" name="repair_status"  id="repair_status" value = "{{$warranty_claims->repair_status }}">
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
                     <input type="text" name="serial_number" id="serial_number" value="{{$warranty_claims->serial_number }}" class="form-control" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Issue Date</label>
                     <input type="date" min="<?php echo date("Y-m-d"); ?>" name="issue_date" value="{{$warranty_claims->issue_date}}" id="issue_date" class="form-control" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label for="purpose">Issue</label>
                     <textarea id="issue_desc" class="summernote" name="issue_desc">{{$warranty_claims->issue_desc }}</textarea>
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
                     <input type="text" name="product_code" id="product_code" class="form-control" value="{{$sn->product_code }}" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Warranty / AMC Status</label>
                     <input type="text" name="warranty_status" id="warranty_status" value="{{$warranty_claims->warranty_status }}" class="form-control" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Product Name</label>
                     <input type="text" name="product_name" id="product_name" class="form-control" value = "{{$product_name->product_name }}" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Warranty Expiry Date</label>
                     <input type="date" name="warranty_expiry_date" id="warranty_expiry_date" value ="{{$sn->warranty_end_date }}" readonly class="form-control">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Description</label>
                     <input type="text" name="internal_description" id="internal_description" value="{{$product_name->internal_description }}" class="form-control" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">AMC Expiry Date</label>
                     <input type="text" name="amc_expiry_date" id="amc_expiry_date" value="{{$sn->amc_expiry_date }}" readonly class="form-control">
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
                     <input type="date" name="resolution_date" id="resolution_date" value="{{$warranty_claims->resolution_date}}" class="form-control">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Resolved By</label>
                     <input type="text" name="employee_id" id="employee_id" value="{{$employee->last_name}} {{$employee->first_name}} - {{$employee->position}}" class="form-control" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label for="purpose">Resolution Details</label>
                     <textarea class="form-control" name="resolution_details" id="resolution_details" rows="3"> {{$warranty_claims->resolution_details}}</textarea>
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
                     <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{$customer->customer_fname}} {{$customer->customer_lname}}" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Branch Name</label>
                     <input type="text" name="branch_name" id="branch_name" class="form-control" value="{{$customer->branch_name}}" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Contact No.</label>
                     <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{$customer->contact_number}}" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Address</label>
                     <input type="text" name="address" id="address" class="form-control" value="{{$customer->address}}" readonly>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Email Address</label>
                     <input type="text" name="email" id="email" class="form-control" value="{{$customer->email_address}}" readonly>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for="purpose">Company Name</label>
                     <input type="text" name="company_name" id="company_name" class="form-control" value="{{$customer->company_name}}" readonly>
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
               <textarea id="Description" class="summernote" name="Description"> {{$warranty_claims->additional_notes}}</textarea>
            </div>
         </div>
      </div>
      <input type="text" id="warranty_id" name="warranty_id" class="form-control" value="{{$warranty_claims->id}}" hidden>
      <input type="text" name="sales_id" id="sales_id" value="{{$warranty_claims->sales_id}} class="form-control" hidden>
   </div>
</div>
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
    checkAvail()
});

function checkAvail(){
  var resDate = $("#warranty_expiry_date").val()
  var jsDate = new Date();
  if (resDate <= jsDate){
     $("#warranty_expiry_date").removeClass().addClass('form-control bg-success');
  }else{
     $("#warranty_expiry_date").removeClass().addClass('form-control bg-warning');
  }
}

$('#editRepairForm').submit(function(e){
  e.preventDefault();
  
  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
       }
  });
  var formData = new FormData(this);

  $.ajax({
      type:'POST',
      url:"/editRepairReq/"+  $("#warranty_id").val(),
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