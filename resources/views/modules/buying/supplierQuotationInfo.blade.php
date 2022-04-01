<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <script src="js/supplierquotation.js"></script>
    <h2 class="navbar-brand tab-list-title">
        <a href="#" onclick="loadIntoPage(this, '{{ route('supplierquotation.index') }}')"
            class="fas fa-arrow-left back-button"><span></span></a>
        <h2 class="navbar-brand" style="font-size: 35px;">{{ $sq->supp_quotation_id }}</h2>
    </h2>

    <div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
        <div class="navbar-nav ml-auto">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#">Send SMS</a>
                        <a class="dropdown-item" href="#">Print</a>
                        <a class="dropdown-item" href="#">Email</a>
                        <a class="dropdown-item" href="#">Jump to field <span
                                class="float-right small">Ctrl+J</span></a>
                        <a class="dropdown-item" href="#">Links</a>
                        <a class="dropdown-item" href="#">Duplicate</a>
                        <a class="dropdown-item" href="#">Rename</a>
                        <a class="dropdown-item" href="#">Reload</a>
                        <a class="dropdown-item" href="#">Customize</a>
                        <a class="dropdown-item" href="#">New Request for Quotation <span
                                class="float-right small">Ctrl+B</span></a>
                    </div>
                </div>
                @if($sq->sq_status == "Draft")
                  <button type="button" class="btn btn-primary ml-1" onclick="$('#submit').modal('show')">Submit</button>
                  <button type="button" class="btn btn-primary" onclick="$('#sq-form').submit()">Save</button>
                @endif
            </div>
        </div>
    </div>
    <br>
    
</nav>

<div class="container-fluid" style="margin: 0; padding: 0;">


<form  id="sq-form" class="update" method="POST" 
action="{{ route('supplierquotation.update', ['supplierquotation'=>$sq->supp_quotation_id]) }}">
@csrf
@method('PATCH')
<div id="accordion">
<br>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <a href="#" class="btn btn-link" data-toggle="collapse" data-target="#supplier" aria-expanded="true" aria-controls="supplier">
          Supplier
        </a>
      </h5>
    </div>
    <div id="supplier" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <!--dashboard contents-->
        <div class="container">
          {{-- <form id="contactForm" name="contact" role="form">
            @csrf --}}

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="supplier_group">Supplier</label>
                  <select name="supplier_id" id="supplier_id" class="form-control selectpicker">
                    @forelse ($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_id }}"
                        data-live-search="true" data-contact="{{ $supplier->contact_name }}" 
                        data-email="{{ $supplier->supplier_email }}"
                        @if($supplier->supplier_id == $sq->supplier->supplier_id) selected @endif>
                          {{ $supplier->company_name }}
                        </option>
                    @empty
                        <option value="{{ $sq->supplier->supplier_id }}">
                          {{ $sq->supplier->company_name }}
                        </option>
                    @endforelse
                  </select>
                </div>
              </div>

              <div class="col-6">
              <div class="form-group">
                  <label for="date_created">Date</label>
                  <input value="{{ $sq->date_created->format("Y-m-d") }}" type="date" min="<?php echo date("Y-m-d"); ?>" name="date_created" id="date_created" class="form-control">
                </div>
               </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="remarks">Supplier Remarks</label>
                  <textarea class="form-control" name="remarks" id="remarks" rows="5">{{ $sq->remarks }}</textarea>
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label for="sq_status">Status</label>
                  <select class="form-control" name="sq_status" id="sq_status">
                    <option value="{{ $sq->sq_status }}">{{ $sq->sq_status }}</option>
                  </select>
                </div>
               </div>
            </div>

            </div>
          {{-- </form> --}}

        </div>
        <!--end contents-->
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#contact" aria-expanded="false" aria-controls="contact">
          Address and Contact
        </a>
      </h5>
    </div>
    <div id="contact" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        <!--supplier detail contents-->
        <div class="container">
          {{-- <form id="contactForm" name="contact" role="form"> --}}
            
          <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="contact_name">Contact Name</label>
                  <input readonly value="{{ $sq->supplier->contact_name }}" type="text" name="contact_name" id="contact_name" class="form-control">
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label for="supplier_email">Email Address</label>
                  <input readonly value="{{ $sq->supplier->supplier_email }}" type="text" name="supplier_email" id="supplier_email" class="form-control">
                </div>
              </div>
            </div>
              
              
          {{-- </form> --}}
        </div>
        <!--end contents-->
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#cnpl" aria-expanded="false" aria-controls="cnpl">
          Currency and Price List
        </a>
      </h5>
    </div>
    <div id="cnpl" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        <!--supplier detail contents-->
        <div class="container">
          {{-- <form id="contactForm" name="contact" role="form"> --}}
            
         
              <table class="table border-bottom table-hover table-bordered" id="items-tbl">
                <thead class="border-top border-bottom bg-light">
                  <tr class="text-muted">
                    <th>
                      <div class="form-group">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input sq-check-all-box">
                        </div>
                      </div>
                    </th>

                    <th>Item Code</th>
                    <th>Quantity</th>
                    <th>Stock UOM</th>
                    <th>Rate</th>
                    <th>Sub-total</th>
                    <th>Delivery Date</th>
                    <th></th>
                    
                  </tr>
                </thead>
                <tbody class="" id="items-input-rows">
                  {{-- If the supplier quotation is a draft, then rows of the item table should be
                  deletable --}}
                  @if ($sq->sq_status == "Draft")
                    @foreach ($sq->items() as $item)
                      @include('modules.buying.supplierquotation.item_row', [
                        'item' => $item,
                        'units' => $units,
                        'deletable' => true,
                      ])
                    @endforeach
                  @else
                    @foreach ($sq->items() as $item)
                      @include('modules.buying.supplierquotation.item_row', [
                        'item' => $item,
                        'units' => $units,
                      ])
                    @endforeach
                  @endif
                </tbody>
                @if ($sq->sq_status == "Draft")
                  <tfoot>
                    <tr>
                      <td colspan="6">
                        <div class="d-flex">
                          <div class="m-1">
                            <button type="button" class="btn btn-secondary btn-sm sq-add-row-btn">
                              Add Row
                            </button>
                          </div>
                          <div class="m-1">
                            <button type="button" class="d-none btn btn-danger btn-sm sq-delete-rows-btn">
                              Delete Selected
                            </button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tfoot>

                @endif
              </table>
              <div class="row">
              <div class="col-6">
                
              </div>

              <div class="col-6">
              <div class="form-group">
                  <label for="grand_total">Grand Total</label>
                  <div class="row">
                    <div class="col-1 p-0">
                      <div class="currency-symbol-container p-0" style="height: 100%; display: grid; align-content: center; font-size:18px; text-align: right;">
                        ₱
                      </div>
                    </div>
                    <div class="col">
                      <input type="hidden" name="grand_total" id="grand_total" value="{{ $sq->grand_total ?? 0 }}">
                      <input value="{{ $sq->grand_total }}" readonly type="text" id="grand_total_display" class="form-control">
                    </div>
                  </div>
                </div>
               </div>
            </div>
              
          {{-- </form> --}}
        </div>
        <!--end contents-->
      </div>
    </div>
  </div>


      </div>
    </div>
  </div>

</div>
</form>
</div>

<!-- Modal -->
<div class="modal fade" id="submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        
      </div>
      <div class="modal-body">
        <p>Permanently submit {{ $sq->supp_quotation_id }} ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="$('#submit').modal('hide')">Cancel</button>
        <form action="{{ route('supplierquotation.submit', ['supplierquotation'=>$sq->supp_quotation_id]) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- This is the sample row that is being copied and appended to the items table --}}
<table class="d-none">
  <tbody class="row-sample">
    @include('modules.buying.supplierquotation.item_row',[
      'item' => null,
      'items' => $items,
      'units' => $units,
      'deletable' => true,
    ])
  </tbody>
</table>
@if (!isset($editable))
  <script>
    // Preventing the information from being editable
    $('input, textarea').each(function(){
      $(this).attr('readonly', 'true');
    });
    $('select').each(function(){
      $(this).attr('disabled', 'true');
    });
    // Unbinding functions attached to item-rate
    $('.item-rate').off();
  </script>
@endif
<script>
  $(document).off('submit', 'form').on('submit', 'form', function(){
    $.ajax({
        type: 'POST',
        url: this.action,
        data: new FormData(this),
        contentType: false,
        processData: false,
        cache: false,
        success: function(data){
          // In case there's more than one modal that ends up on this page in the future
          $('.modal').each(function(){
            $(this).modal('hide');
          });

          loadIntoPage($('.tab-pane form')[0], "{{ route('supplierquotation.index') }}");
        },
        error: function(data){
          alert("Error " + data.message);
        }
    });
    return false;
  }); 
</script>