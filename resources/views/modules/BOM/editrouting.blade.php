<script src="{{ asset('js/address.js') }}"></script>
<script src="{{ asset('js/newrouting.js') }}"></script>
@php
$i = 1;
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <h2 class="navbar-brand" style="font-size: 35px;">{{ $route->routing_id }}</h2>
        <input type="text" name="" id="hiddenRouteID" value="{{ $route->id }}" style="display: none;" readonly>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#responsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="responsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown li-bom">
                    <div class="btn-group">
                        <button class="nav-link dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            New Operation / Work Center
                        </button>
                        <div class="dropdown-menu">
                            <td class="mr-qty-input">
                                <a class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#operation_modal">
                                    New Operation
                                </a>
                            </td>

                            <td class="mr-unit-input">
                                <a class="dropdown-item" type="button" type="submit" onclick="loadnewworkcenter();">
                                    New Work Center
                                </a>
                            </td>
                        </div>
                    </div>

                </li>
                <li class="nav-item li-bom">
                    <button class="btn btn-refresh" style="background-color: #d9dbdb;" type="submit"
                        onclick="RoutingTable();">Cancel</button>
                </li>
                <li class="nav-item li-bom">
                    <button style="background-color: #007bff;" class="btn btn-info btn" style="float: left;"
                        id="saveRouting" onclick="">Save</button>
                </li>
                <li class="nav-item li-bom">
                    <form action="{{ route('routing.destroy', ['routing' => $route->id]) }}" id="deleteRouting"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button style="background-color: #ff0000d7;" class="btn btn-danger btn" style="float: left;"
                            onclick="" id="routeDelete">Delete</button>
                    </form>
                </li>
            </ul>
        </div>
</nav>

<div id="routing_success_msg" class="alert alert-success" style="display: none;">
</div>

<div id="routing_alert_msg" class="alert alert-danger" style="display: none;">
</div>

<form action="{{ route('routing.update', ['routing' => $route->id]) }}" method="POST" id="routingsForm"
    class="create">
    @csrf
    @method('PATCH')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="Routing_Name">Routing Name</label>
                    <input type="text" name="Routing_Name" id="Routing_Name" value="{{ $route->routing_name }}"
                        class="form-control">
                </div>
            </div>
        </div>
        <label>BOM Operation</label>
        <table class="table border-bottom table-hover table-bordered" id="operations">
            <thead class="border-top border-bottom bg-light">
                <tr class="text-muted">
                    <td class="text-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input">
                        </div>
                    </td>
                    <td class="text-center">Seq. ID</td>
                    <td class="text-center">Operation</td>
                    <td class="text-center">Work Center</td>
                    <td class="text-center">Description</td>
                    <td class="text-center">Hour Rate</td>
                    <td class="text-center">Operation Time</td>
                    <td></td>
                </tr>
            </thead>
            <tbody class="" id="newrouting-input-rows">
                @foreach ($routing_operations as $ro)
                    <tr data-id="<?= $i ?>">
                        <td class="text-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input">
                            </div>
                        </td>
                        <td id="mr-code-input" class="mr-code-input"><input type="number"
                                value="{{ $ro['sequence_id'] }}" name="seq_id" id="seq_id<?= $i ?>"
                                class="form-control" readonly></td>
                        <td class="mr-qty-input"><input type="text" value="{{ $ro['operation_id'] }}"
                                name="operation" id="operation<?= $i ?>" class="form-control operation"
                                list="operations_list" onchange="operationSearch(<?= $i ?>);">
                        </td>
                        <td class="mr-unit-input"><input type="text" value="{{ $ro['operation']->wc_code }}"
                                name="workcenter" id="workcenter<?= $i ?>" class="form-control" disabled>
                        </td>
                        </td>
                        <td class="mr-unit-input"><input type="text" value="{{ $ro['operation']->description }}"
                                name="description" id="description<?= $i ?>" class="form-control" disabled></td>
                        <td class="mr-unit-input"><input type="number" value="{{ $ro['hour_rate'] }}"
                                name="hour_rate" id="hour_rate<?= $i ?>" class="form-control"></td>
                        <td class="mr-unit-input"><input type="text" value="{{ $ro['operation_time'] }}"
                                name="operation_time" id="operation_time<?= $i ?>" class="form-control"></td>
                        <td>
                            <a id="" class="btn" data-toggle="modal" data-target="#edit_routing" href="#"
                                role="button">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>
                            <a id="" class="btn delete-btn" href="#" role="button">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php ++$i; ?>
                @endforeach
            </tbody>
            <datalist id="operations_list">
                @foreach ($operations as $operation)
                    <option value="{{ $operation->operation_id }}">{{ $operation->operation_name }}</option>
                @endforeach
            </datalist>

        </table>
        <td colspan="7" rowspan="5">
            <button type="button" onclick="addRowbomOperation()" class="btn btn-sm btn-sm btn-secondary">Add
                Row</button>
        </td>

    </div>
    <br>
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_routing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Routing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table border-bottom table-hover table-bordered" id="operations">
                                    <thead class="border-top border-bottom bg-light">
                                        <tr class="text-muted">
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input">
                                                </div>
                                            </td>
                                            <td class="text-center">Seq. ID</td>
                                            <td class="text-center">Operation</td>
                                            <td class="text-center">WorkCenter</td>
                                            <td class="text-center">Description</td>
                                            <td class="text-center">Operation Time</td>
                                            <td class="text-center">Operating Cost</td>
                                            <td class="text-center">Hour Rate</td>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="newrouting-input-rows">
                                        <tr data-id="1">
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input">
                                                </div>
                                            </td>
                                            <td id="mr-code-input" class="mr-code-input"><input type="text" value=""
                                                    name="seq_id" id="seq_id" class="form-control"></td>
                                            <td style="width: 10%;" class="mr-qty-input"><input type="text" value=""
                                                    name="operation" id="operation" class="form-control">
                                            <td class="mr-unit-input"><input type="text" value="" name="workcenter"
                                                    id="workcenter" class="form-control">
                                            <td class="mr-unit-input"><input type="text" value="" name="description"
                                                    id="description" class="form-control"></td>
                                            <td class="mr-unit-input"><input type="text" value="" name="operation_time"
                                                    id="operation_time" class="form-control"></td>
                                            <td class="mr-unit-input"><input type="text" value="" name="operating_cost"
                                                    id="operating_cost" class="form-control"></td>
                                            <td class="mr-unit-input"><input type="text" value="" name="hour_rate"
                                                    id="hour_rate" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="operation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Operation</h5>
                <button type="button" class="close" data-dismiss="modal" id="operationCross"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="{{ route('operations.store') }}" method="POST" id="operationForm">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label for="Operation_Name">Operation Name</label>
                                <input type="text" name="Operation_Name" id="Operation_Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="Default_WorkCenter">Default Work Center</label>
                                <input type="text" name="Default_WorkCenter" id="Default_WorkCenter"
                                    class="form-control" list="work_center_list">
                                <datalist id="work_center_list">
                                    @foreach ($work_centers as $wc)
                                        <option value="{{ $wc->wc_code }}">{{ $wc->wc_label }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="Description">Description</label>
                            <textarea id="Description" class="form-control" name="Description"></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeOpModal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveOperation" data-dismiss="modal">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
