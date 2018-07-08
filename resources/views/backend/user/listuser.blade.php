
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
                <h3 class="box-title" style="float: left">Danh sách user</h3>
                <a class="btn btn-default" style="float: right" id="addUser"> <i class="fa fa-plus"></i> Thêm mới user</a>
            </div>
            <div class="box-body">
                <table id="user" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Ho va Ten</th>
                        <th>Ngay sinh</th>
                        <th>email</th>
                        <th>so dien thoai</th>
                        <th>ten tai khoan</th>                       
                        <th>Ma quyen</th>
                        <th>Chuc nang</th>
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
                        <label for="user_fullname">Ho va Ten<span style="color: red">*</span> </label>
                        <input class="form-control" id="user_fullname" name="user_fullname" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="user_birthday">Ngày Sinh<span style="color: red">*</span> </label>
                        <input class="form-control datepicker" readonly id="user_birthday" name="user_birthday" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="user_email">Email<span style="color: red">*</span> </label>
                        <input class="form-control" id="user_email" name="user_email" placeholder="..." type="text">
                    </div>
                </div>
                 <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="user_phone">So dien thoai<span style="color: red">*</span> </label>
                        <input class="form-control" id="user_phone" name="user_phone" placeholder="..." type="text">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="user_username">Ten tai khoan<span style="color: red">*</span> </label>
                        <input class="form-control" id="user_username" name="user_username" placeholder="..." type="text">
                    </div>
                </div> 
                <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="user_password">Mat khau<span style="color: red">*</span> </label>
                        <input class="form-control" id="user_password" name="user_password" placeholder="..." type="text">
                    </div>
                </div>
                  <div class="col-md-12 col-xs-12 row" style="margin-top: 10px">
                    <div class="col-md-12 col-xs-12">
                        <label for="permission_id">Quyen<span style="color: red">*</span> </label>
                        <input class="form-control" id="permission_id" name="permission_id" placeholder="..." type="text">
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
        $("#li_user").addClass("active");
        var _page = 1;
        var _pagelimit = 10;
        var _data = [];
        var _isEdit = false;
        var _idEdit = "";

        oTable = $('#user').DataTable({
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
                $.get("/api/getListuser", {
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
                    var stringEdit = '<a href="javascript:;" onclick="edituser(\'' + data.config_id + '\')"><i class="fa fa-pencil"></i></a> ';
                    var stringDel = '<a href="javascript:;" onclick="deleteuser(\'' + data.config_id + '\')" style="margin-left: 10px"><i class="fa fa-trash"></i></a>';
                    return stringEdit + stringDel;
                }},
            ]
        })

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $("#adduser").on("click", function(){
            _isEdit = false;
            $(".modal-title").html("").append("Thêm mới cấu hình hệ thống");

            /*$("#config_name").val("");
            $("#config_value").val("");
            $("#config_dateapply").val("");*/

            $("#user_fullname").val("");
            $("#user_birthday").val("");
            $("#user_email").val("");
            $("#user_phone").val("");
            $("#user_username").val("");
            $("#user_password").val("");
            $("#permission_id").val("");


            $("#ActionModule").modal("show");
        })

        function edituser(id){
            _isEdit = true;
            _idEdit = id;
            _data.forEach(function(item){
                if(id == item.config_id){
                    $(".modal-title").html("").append("Cập nhật cấu hình hệ thống");
                    $("#user_fullname").val(item.user_fullname);
                    $("#user_email").val(item.user_email);
                    $("#user_phone").val(item.user_phone);
                    $("#user_username").val(item.user_username);
                    $("#user_password").val(item.user_password);
                    $("#permission_id").val(item.permission_id);
                    $("#user_birthday").val(moment(item.user_birthday, "YYYY-MM-DD").format("DD/MM/YYYY"));
                    $("#ActionModule").modal("show");
                }
            })
            
        }

        function deleteConfig(id){
            swal({
                    title: "Xác nhận!",
                    text: "Bạn chắc chắn muốn xóa user này ra khỏi hệ thống!",
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
                                    sweetAlert('Thành công','Xóa user thành công','success');
                                }
                                else {
                                    sweetAlert('Lỗi','Xóa user thất bại, vui lòng thử lại','info');
                                }
                            },
                            failure: function (response) {
                                sweetAlert('Lỗi','Xóa user thất bại, vui lòng xem lại','error');
                            }
                        });
                    }
                });
        }

        function submitForm(){
            if( $("#user_fullname").val() == "" ||  $("#user_birthday").val() == "" ||  $("#user_email").val() == "" || $("#user_phone").val() == "" ||  $("#user_username").val() == "" || $("#user_password").val() == "" || $("#permission_id").val() == ""){
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
                            url: "/api/adduser",
                            data: {
                                user_fullname: $("#user_fullname").val(),
                                user_email: $("#user_email").val(),
                                user_phone: $("#user_phone").val(),
                                user_username: $("#user_username").val(),
                                user_password: $("#user_password").val(),
                                permission_id: $("#permission_id").val(),
                                user_birthday: moment($("#user_birthday").val(), "DD/MM/YYYY").format("YYYY-MM-DD"),
                                _token: $('#_token').val(),
                            },
                            success: function (data) {
                                if(data.success){
                                    oTable.draw(false);
                                    $("#ActionModule").modal("hide");
                                    sweetAlert('Thành công','Thêm thông tin user thành công','success');
                                }
                                else {
                                    sweetAlert('Lỗi','Thêm thông tin user thất bại, vui lòng thử lại','info');
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
                    text: "Bạn chắc chắn muốn cập nhật thông tin user!",
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

                                user_fullname: $("#user_fullname").val(),
                                user_email: $("#user_email").val(),
                                user_phone: $("#user_phone").val(),
                                user_username: $("#user_username").val(),
                                user_password: $("#user_password").val(),
                                permission_id: $("#permission_id").val(),

                               
                                user_birthday: moment($("#user_birthday").val(), "DD/MM/YYYY").format("YYYY-MM-DD"),
                                _token: $('#_token').val(),
                            },
                            success: function (data) {
                                if(data.success){
                                    oTable.draw(false);
                                    $("#ActionModule").modal("hide");
                                    sweetAlert('Thành công','Cập nhật thông tin user thành công','success');
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