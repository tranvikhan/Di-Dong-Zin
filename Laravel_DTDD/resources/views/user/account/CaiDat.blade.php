@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Cài đặt</h3>
            <div class="row user-thongtin">
                  <div class="col-12">
                      Hiện tại chưa phát triển chức năng này!  
                  </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/user_manage.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('caiDatMenu').classList.add('active');
        }
    </script>
@endsection