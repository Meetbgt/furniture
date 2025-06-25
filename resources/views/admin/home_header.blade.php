@extends('admin.template.template')

@section('title', 'Dashboard')

@section('header_link')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form-tab-pane"
                        type="button" role="tab" aria-controls="form-tab-pane" aria-selected="true">Form</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-tab-pane"
                        type="button" role="tab" aria-controls="table-tab-pane" aria-selected="false">Table</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- first tab -->
                <div class="tab-pane fade show active" id="form-tab-pane" role="tabpanel" aria-labelledby="form-tab"
                    tabindex="0">
                    <form id="home_header" enctype="multipart/form-data">
                        <div class="row"> @csrf <input type="hidden" name="id" id="id">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control " id="heading" name="heading"
                                        placeholder="Heading" required>
                                    <label for="heading">Heading</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control " id="description" name="description"
                                        placeholder="Description" required>
                                    <label for="description">Description</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="contact_us_button"
                                        name="contact_us_button" placeholder="Contact Us button" required>
                                    <label for="contact_us_button" class="form-check-label">Contact Us button</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        required>
                                    <label for="image">Image</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
                <!-- second tab -->
                <div class="tab-pane fade px-3" id="table-tab-pane" role="tabpanel" aria-labelledby="table-tab"
                    tabindex="0">
                    <!-- DataTable HTML -->
                    <table id="home_header_list" class="table table-striped table-md" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Heading</th>
                                <th>Description</th>
                                <th>Contact Us button</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- DataTable Script -->
    <script>
        $(document).ready(function () {
            var table = $("#home_header_list").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('home_header_list') }}",
                    type: "GET",
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                },
                columns: [{ data: "heading", title: "Heading" }, { data: "description", title: "Description" }, { data: "contact_us_button", title: "Contact Us button" }, { data: "image", title: "Image" }, { data: "Action", title: "Actions" },]
            });
        });

        $(document).on("click", ".home_header_edit", function () {
            const id = $(this).data("id");
            $.ajax({
                url: "{{ route('home_header_getdata') }}",
                type: "POST",
                headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                data: { id: id },
                success: function (response) {
                    $("#heading").val(response.data.heading);
                    $("#description").val(response.data.description);
                    $("#contact_us_button").prop("checked", response.data.contact_us_button == 1);
                    $("#image").val(response.data.image);
                    $("#id").val(id);
                    $("#form-tab").tab("show");
                }
            });
        });

        $(document).on("click", ".home_header_delete", function () {
            const id = $(this).data("id");
            $.ajax({
                url: "{{ route('home_header_delete') }}",
                type: "POST",
                headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                data: { id: id },
                success: function (response) {
                    if (response.success) {
                        iziToast.success({
                            title: "Register Success",
                            message: response.message,
                            position: "topRight"
                        });
                        $("#home_header_list").DataTable().ajax.reload();
                    } else {
                        iziToast.warning({
                            title: "Register failed",
                            message: response.message,
                            position: "topRight"
                        });
                    }
                },
                error: function () {
                    iziToast.error({
                        title: "Register Error",
                        message: "error",
                        position: "topRight"
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#home_header").submit(function (e) {
                e.preventDefault();
                const data = new FormData(this);
                $.ajax({
                    url: "{{ route('home_header_insert') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            iziToast.success({
                                title: "Register Success",
                                message: response.message,
                                position: "topRight"
                            });
                            $("#home_header").trigger("reset");
                            $("#id").val("");
                            $("#home_header_list").DataTable().ajax.reload();
                            $("#table-tab").tab("show");
                        } else {
                            iziToast.warning({
                                title: "Register failed",
                                message: response.message,
                                position: "topRight"
                            });
                        }
                    },
                    error: function () {
                        iziToast.error({
                            title: "Register Error",
                            message: "error",
                            position: "topRight"
                        });
                    }
                });
            });
        });
    </script>
@endsection