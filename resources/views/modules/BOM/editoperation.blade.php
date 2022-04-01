<script src="{{ asset('js/address.js') }}"></script>
<script src="{{ asset('js/operations.js') }}"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <h2 class="navbar-brand" style="font-size: 35px;">{{ $operation->operation_id }}</h2>
        <input type="text" name="hiddenId" id="hiddenOpId" value="{{ $operation->id }}" readonly
            style="display: none">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#responsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="responsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown li-bom">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Menu
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                    </ul>
                <li class="nav-item li-bom">
                    <button class="btn btn-refresh" style="background-color: #d9dbdb;" type="submit"
                        onclick="operationtable();">Cancel</button>
                </li>
                <li class="nav-item li-bom">
                    <button style="display: none;" class="btn btn-info btn" style="float: left;" onclick=""
                        id="operationModuleSave">Save</button>
                </li>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="operation_success_msg" class="alert alert-success" style="display: none;">
</div>

<div id="operation_alert_msg" class="alert alert-danger" style="display: none;">
</div>
<form action="#" method="POST" id="operationModuleForm" class="create">
    @csrf
    @method('PATCH')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="operation_name">Operation Name</label>
                    <input type="text" name="Operation_Name" id="Operation_Name" class="form-control om"
                        value="{{ $operation->operation_name }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="Default_workcenter">Default Work Center</label>
                    <input type="text" name="Default_WorkCenter" id="Default_WorkCenter" class="form-control om"
                        list="work_center_list" value="{{ $operation->wc_code }}">
                    <datalist id="work_center_list">
                        @foreach ($work_centers as $wc)
                            <option value="{{ $wc->wc_code }}">{{ $wc->wc_label }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="col-6">
            </div>
            <div class="form-group col-md-12">
                <label for="operation_Description">Description</label>
                <textarea id="Description" class="form-control om" name="Description">{{ $operation->description }}</textarea>
            </div>
        </div>
    </div>
    <br>
</form>
