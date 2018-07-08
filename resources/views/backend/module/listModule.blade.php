@extends('backend.home')

@section('css')
    <link rel="stylesheet" href="/sweetalert/dist/sweetalert.css">
    <style>
        .dataTables_paginate{
            text-align: right
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title" style="float: left">Danh sách Module hệ thống</h3>
                <a class="btn btn-default" style="float: right" id="addModule"> <i class="fa fa-plus"></i> Thêm mới Module</a>
            </div>
            <div class="box-body">
                <table id="module" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mã module</th>
                        <th>Tên module</th>
                        <th>id element</th>
                        <th>Tên modules</th>
                        <th>module_href</th>
                        <th>module_class</th>
                        <th>module_type</th>
                        <th>module_listaction</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ActionModule" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">Mã module<span style="color: red">*</span> </label>
                        <input class="form-control" id="module_id" name="module_id" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_value">Tên module<span style="color: red">*</span> </label>
                        <input class="form-control" id="module_name" name="module_name" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">id element<span style="color: red">*</span> </label>
                        <input class="form-control" id="idelement" name="idelement" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">Tên modules<span style="color: red">*</span> </label>
                        <input class="form-control" id="config_name" name="config_name" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">module_href<span style="color: red">*</span> </label>
                        <input class="form-control" id="config_name" name="config_name" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">module_class<span style="color: red">*</span> </label>
                        <input class="form-control" id="config_name" name="config_name" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">module_type<span style="color: red">*</span> </label>
                        <input class="form-control" id="config_name" name="config_name" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_name">module_listaction<span style="color: red">*</span> </label>
                        <input class="form-control" id="config_name" name="config_name" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="config_dateapply">Ngày áp dụng <span style="color: red">*</span> </label>
                        <input class="form-control datepicker" readonly id="config_dateapply" name="config_dateapply" placeholder="..." type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success" onclick="submitForm()">Thực thi</button>
            </div>
        </div>
    </div>
</div>

<form method="post">
    <input type="hidden" value="{{csrf_token()}}" id="_token">
</form>
@endsection

@section('javascript')
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        //Active thanh sidebar
        $("#li_config").addClass("active");
        var _page = 1;
        var _pagelimit = 10;
        var _data = [];
        var _isEdit = false;
        var _idEdit = "";

        oTable = $('#config').DataTable({
            oLanguage: {
                "sEmptyTable":      "Không có dữ liệu",
                "sInfo":            "Hiển thị _START_ đến _END_ của _TOTAL_ kết quả",
                "sInfoEmpty":       "Không có dữ liệu",
                "sInfoFiltered":    "",
                "sLoadingRecords":  "Đang tải dữ liệu...",
                "sSearch":          "Tìm kiếm",
                "sZeroRecords":     "Không có kết quả",
                "oPaginate": {
                    "sNext":        "Sau",
                    "sPrevious":    "Trước"
                }
            },
            serverSide: true,
            "searching":false,
            "lengthChange":false,
            "ordering": false,
            "iDisplayLength" : _pagelimit,
            ajax: function(data, callback, oSettings) {
                _page = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;
                $.get("/api/getListConfig", {
                    Page : _page,
                    PageLimit : _pagelimit,
                }, function(data) {
                    _data = data.data;
                    callback({
                        recordsTotal: data.CountData,
                        recordsFiltered: data.CountData,
                        data: data.data
                    });
                });
            },
            "columns": [
                { "data": null, 'mRender': function (data, type, row) {
                    return data.config_id;
                }},
                { "data": null, 'mRender': function (data, type, row) {
                    return data.config_name;
                }},
                { "data": null, 'mRender': function (data, type, row) {
                    return data.config_value;
                }},
                { "data": null, 'mRender': function (data, type, row) {
                    return moment(data.config_dateapply, "YYYY-MM-DD").format("DD/MM/YYYY");
                }},
                { "data": null, 'mRender': function (data, type, row) {
                    var stringEdit = '<a href="javascript:;" onclick="editConfig(\'' + data.config_id + '\')"><i class="fa fa-pencil"></i></a> ';
                    var stringDel = '<a href="javascript:;" onclick="deleteConfig(\'' + data.config_id + '\')" style="margin-left: 10px"><i class="fa fa-trash"></i></a>';
                    return stringEdit + stringDel;
                }},
            ]
        })

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $("#addConfig").on("click", function(){
            _isEdit = false;
            $(".modal-title").html("").append("Thêm mới cấu hình hệ thống");
            $("#config_name").val("");
            $("#config_value").val("");
            $("#config_dateapply").val("");
            $("#ActionModule").modal("show");
        })

        function editConfig(id){
            _isEdit = true;
            _idEdit = id;
            _data.forEach(function(item){
                if(id == item.config_id){
                    $(".modal-title").html("").append("Cập nhật cấu hình hệ thống");
                    $("#config_name").val(item.config_name);
                    $("#config_value").val(item.config_value);
                    $("#config_dateapply").val(moment(item.config_dateapply, "YYYY-MM-DD").format("DD/MM/YYYY"));
                    $("#ActionModule").modal("show");
                }
            })
            
        }

        function deleteConfig(id){
            swal({
                    title: "Xác nhận!",
                    text: "Bạn chắc chắn muốn xóa cấu hình này ra khỏi hệ thống!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "/api/deleteConfig",
                            data: {
                                id: id,
                                _token: $('#_token').val(),
                            },
                            success: function (data) {
                                if(data.success){
                                    oTable.draw(false);
                                    sweetAlert('Thành công','Xóa cấu hình thành công','success');
                                }
                                else {
                                    sweetAlert('Lỗi','Xóa cấu hình thất bại, vui lòng thử lại','info');
                                }
                            },
                            failure: function (response) {
                                sweetAlert('Lỗi','Xóa cấu hình thất bại, vui lòng xem lại','error');
                            }
                        });
                    }
                });
        }

        function submitForm(){
            if( $("#config_name").val() == "" ||  $("#config_value").val() == "" ||  $("#config_dateapply").val() == ""){
                sweetAlert('Chú ý','Vui lòng nhập đủ thông tin để tiếp tục','info');
            }
            else{
                submitFormValid();
            }
        }

        function submitFormValid(){
            if(!_isEdit){
                swal({
                    title: "Xác nhận!",
                    text: "Bạn chắc chắn muốn thêm thông tin cấu hình!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true,
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "/api/addConfig",
                            data: {
                                config_name: $("#config_name").val(),
                                config_value: $("#config_value").val(),
                                config_dateapply: moment($("#config_dateapply").val(), "DD/MM/YYYY").format("YYYY-MM-DD"),
                                _token: $('#_token').val(),
                            },
                            success: function (data) {
                                if(data.success){
                                    oTable.draw(false);
                                    $("#ActionModule").modal("hide");
                                    sweetAlert('Thành công','Thêm thông tin cấu hình thành công','success');
                                }
                                else {
                                    sweetAlert('Lỗi','Thêm thông tin thất bại, vui lòng thử lại','info');
                                }
                            },
                            failure: function (response) {
                                sweetAlert('Lỗi','Thêm thông tin thất bại, vui lòng xem lại','error');
                            }
                        });
                    }
                });
            }
            else{
                swal({
                    title: "Xác nhận!",
                    text: "Bạn chắc chắn muốn cập nhật thông tin cấu hình!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true,
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "/api/updateConfig",
                            data: {
                                config_id: _idEdit,
                                config_name: $("#config_name").val(),
                                config_value: $("#config_value").val(),
                                config_dateapply: moment($("#config_dateapply").val(), "DD/MM/YYYY").format("YYYY-MM-DD"),
                                _token: $('#_token').val(),
                            },
                            success: function (data) {
                                if(data.success){
                                    oTable.draw(false);
                                    $("#ActionModule").modal("hide");
                                    sweetAlert('Thành công','Cập nhật thông tin cấu hình thành công','success');
                                }
                                else {
                                    sweetAlert('Lỗi','Cập nhật thông tin thất bại, vui lòng thử lại','info');
                                }
                            },
                            failure: function (response) {
                                sweetAlert('Lỗi','Cập nhật thông tin thất bại, vui lòng xem lại','error');
                            }
                        });
                    }
                });
            }
        }

    </script>
@endsection