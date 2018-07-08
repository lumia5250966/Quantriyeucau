@extends('backend.home')

@section('css')

@endsection

@section('content')
    <label>Nội dung trang dashboard</label>
@endsection

@section('javascript')
    <script>
        //Active thanh sidebar
        $("#li_dashboard").addClass("active");
    </script>
@endsection