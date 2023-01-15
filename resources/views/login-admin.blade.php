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
                    <div>Silahkan nama dan password admin dengan benar</div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <div class="col-7 border border-primary rounded">
                        {{-- <div class="row mb-3 mt-3 ">
                            <label for="inputSSOid" class="col-sm-2 col-form-label">Nama Admin</label>
                            <div class="col-sm-5">
                                <input name="nama_admin" type="text" class="form-control" id="nama_admin">
                            </div>
                        </div> --}}
                        <div class="row mb-3 mb-3 mt-3">
                            <label for="sso_user_id" class="col-sm-2 col-form-label">SSO</label>
                            <div class="col-sm-5">
                                <input name="sso_user_id" type="text" class="form-control" id="sso_user_id">
                            </div>
                        </div>
                        <button type="button" onclick="checkLogin()" class="btn btn-primary mt-3 mb-3" id="sendButton" value="Login">Login</button>
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
    CustomSwal.fire({
        icon:'question',
        text: 'Yakin nama dan password Anda sudah benar?',
        showCancelButton: true,
        confirmButtonText: 'yakin',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let namaAdmin = $('#nama_admin').val();
            let passAdmin = $('#pass_admin').val();
            $.ajax({
                url: "actionlogin",
                type:"GET",
                success:function(data){
                    if(data.success == 1){
                        window.location.href = "admin/list-aduan";
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
    });
}

$(document).ready(function(){
    var checkField;

    //checking the length of the value of message and assigning to a variable(checkField) on load
    checkField = $("input#admin").val().length;  

    var enableDisableButton = function(){         
        if(checkField > 0){
            $('#sendButton').removeAttr("disabled");
        } 
        else {
            $('#sendButton').attr("disabled","disabled");
        }
    }        

    //calling enableDisableButton() function on load
    enableDisableButton();            

    $('input#admin').keyup(function(){ 
        //checking the length of the value of message and assigning to the variable(checkField) on keyup
        checkField = $("input#admin").val().length;
        //calling enableDisableButton() function on keyup
        enableDisableButton();
    });
});
</script>
@endpush