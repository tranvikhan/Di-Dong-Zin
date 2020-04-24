@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="caidat" class="tabcontent">
        <h2>CÀI ĐẶT</h2>
        <img src="DiDongZin/assets/img/undraw_personal_settings_kihd.svg">
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/_caidat.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('caiDatMenu').classList.add('active');
        }
    </script>
@endsection