{{-- https://www.positronx.io/laravel-datatables-example/ --}}

@extends('layouts.app')
@section('action')
@endsection
@section('content')
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-search">
            <h4 class="card-title text-primary"><i class='{{ $icon }}' data-toggle='tooltip' data-placement='bottom'
                    title='Data {{ $subtitle }}'></i> {{ strtoupper($subtitle) }}</h4>
        </div>
    </div>
    <div class="row gy-3 d-none" id="loaderspin">
        <div class="col-md-12">
            <div class="col-md-12" align="center">
                &nbsp;
            </div>
            <div class="d-flex align-items-center">
                <div class="col-md-12" align="center">
                    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                </div>
            </div>
            <div class="col-md-12" align="center">
                <strong>Loading...</strong>
            </div>
        </div>
    </div>
    <div class="card d-none" id="filterrow">
        <div class="card-body" style="background:#f7f9fd">
            <div class="row gy-3">

            </div>
        </div>
    </div>

    <!-- <div class="nk-fmg-body-content"> -->
    <div class="nk-fmg-quick-list nk-block">
        <div class="card">
            <div class="card-body">
                <div>
                    <div>Silahkan masukkan username dan password pegawai dengan benar.</div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <div class="col-7 border border-primary rounded">
                        <div class="row mb-3 mt-3 ">
                            <label for="username" class="col-sm-4 col-lg-2 col-form-label">Username</label>
                            <div class="col-sm-8 col-lg-10">
                                <input name="username" type="text" class="form-control" id="username">
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <label for="sso_user_id" class="col-sm-4 col-lg-2 col-form-label">Password</label>
                            <div class="col-sm-8 col-lg-10">
                                <input name="sso_user_id" type="text" class="form-control" id="sso_user_id">
                            </div>
                        </div>
                        <button type="button" onclick="checkLogin()" class="btn btn-primary mt-1 mb-3" id="sendButton" value="Login">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
@endsection
@push('script')
<script>
function checkLogin(){
    $.ajax({
        url: "/login",
        type:"POST",
        data: {
            username: $('#username').val(),
            sso_user_id: $('#sso_user_id').val(),
            _token: "{{csrf_token()}}",
        },
        success:function(data){
            if(data.success == 1){
                window.location.href = "pegawai/list";
            }else{
                CustomSwal.fire('Gagal', data.msg, 'error');
            }
        },
        error:function(error){
            CustomSwal.fire('Gagal', 'terjadi kesalahan sistem', 'error');
            console.log(error.XMLHttpRequest);
        }
    });
}

$(document).ready(function(){
    var checkField;

    //checking the length of the value of message and assigning to a variable(checkField) on load
    checkField1 = $("input#username").val().length;  
    checkField2 = $("input#sso_user_id").val().length;  

    var enableDisableButton = function(){         
        if(checkField1 > 0 && checkField2 > 0){
            $('#sendButton').removeAttr("disabled");
        } 
        else {
            $('#sendButton').attr("disabled","disabled");
        }
    }        

    //calling enableDisableButton() function on load
    enableDisableButton();            

    $('input#username').keyup(function(){ 
        //checking the length of the value of message and assigning to the variable(checkField) on keyup
        checkField1 = $("input#username").val().length;
        //calling enableDisableButton() function on keyup
        enableDisableButton();
    });

    $('input#sso_user_id').keyup(function(){ 
        //checking the length of the value of message and assigning to the variable(checkField) on keyup
        checkField2 = $("input#sso_user_id").val().length;
        //calling enableDisableButton() function on keyup
        enableDisableButton();
    });
});
</script>
@endpush