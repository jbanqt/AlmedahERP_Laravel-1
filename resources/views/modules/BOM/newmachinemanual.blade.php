<!--
    Duplication of machineinfo.blade.php file. This file is made exclusively for creating a new
    Machine Manual.
-->
<script src="{{ asset('js/address.js') }}"></script>
<script src="{{ asset('js/machinemanual.js') }}"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <h2 class="navbar-brand" style="font-size: 35px;">New Machine Manual</h2>
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
                </li>
                </li>
                <li class="nav-item li-bom">
                    <button class="btn btn-refresh" style="background-color: #d9dbdb;" type="submit"
                        onclick="loadmachine();">Cancel</button>
                </li>
                <li class="nav-item li-bom">
                    <button style="background-color: #007bff;" class="btn btn-info btn" style="float: left;" onclick=""
                        id="saveMMBtn">Save</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="mm_success_message" class="alert alert-success" style="display: none;">
</div>

<div id="mm_alert_message" class="alert alert-danger" style="display: none;">
</div>

<form action="{{ route('machinemanual.store') }}" method="post" id="mmForm">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="">Machine Image</label>
                    <img id="MM_img_tmp" src="../images/thumbnail.png" style="width:100%;">
                    <br><br>
                    <input type="file" accept="image/*" name="Machine_Image[]" id="Machine_Image"
                        onchange="readURL1(this);" multiple>
                </div>
            </div>
            <script>
                function readURL1(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#MM_img_tmp')
                                .attr('src', e.target.result)
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
            <div class="col-6">
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="Machine_Code">Machine Code</label>
                    <input type="text" name="Machine_Code" id="Machine_Code" class="mm form-control"
                        value="Automatically Generated..." disabled>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="Machine_name">Machine Name</label>
                    <input type="text" name="Machine_name" id="Machine_name" class="mm form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="Machine_Process">Machine Process</label>
                    <input type="text" name="Machine_Process" id="Machine_Process" class="mm form-control">
                </div>
            </div>
            <div class="col-6">
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="Setup_time">Setup Time</label>
                    <input type="text" name="Setup_time" id="Setup_time" class="mm form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="Running_time">Running Time</label>
                    <input type="text" name="Running_time" id="Running_time" class="mm form-control">
                </div>
            </div>
            <div class="col-6">
            </div>
            <div class="form-group col-md-12">
                <label for="Machine_Description">Machine Description</label>
                <textarea id="Machine_Description" class="mm form-control" name="Machine_Description"></textarea>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200
        });
        $('#myTimeline').verticalTimeline({
            startLeft: false,
            alternate: false,
            arrows: false
        });
    });
</script>
