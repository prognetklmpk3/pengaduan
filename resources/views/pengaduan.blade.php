{{-- https://www.positronx.io/laravel-datatables-example/ --}}

@extends('layouts.app')
@section('action')
@endsection
@section('content')
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-search">
            <h4 class="card-title text-primary"><i class='{{ $icon }}' data-toggle='tooltip' data-placement='bottom'
                    title='Data {{ $subtitle }}'></i> {{ strtoupper('Data ' . $subtitle) }}</h4>
        </div>
        <div class="nk-fmg-actions">
            <div class="btn-group">
                <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary" onclick="buttondisable(this)"><em
                        class="icon fas fa-plus"></em> <span>Ajukan Aduan</span></a>
            </div>
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
                    <div class="mb-4 fw-bold" style="font-size:25px">Selamat Datang di Situs Pengaduan Pelayanan Rumah Sakit</div>
                    <div>Sampaikan laporan, kritik maupun saran perbaikan Anda dengan klik tombol <b>Ajukan Aduan</b> di
                        kanan atas untuk membuat laporan pengaduan Anda</div>
                    <div></div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <div class="col-4 border border-primary rounded">
                        <div class="my-3">
                            <label for="exampleInputPassword1" class="form-label">Cek Pengaduan</label>
                            <input name="id" type="text" class="form-control" id="id" value="" placeholder="Ex: A00123">
                            <button type="button" onclick="checkPengaduan()" class="btn btn-primary mt-3" id="sendButton" value="Send">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
@endsection
@push('script')
<script>
function checkPengaduan(){
    CustomSwal.fire({
        icon:'question',
        text: 'Yakin kode aduan sudah tepat?',
        showCancelButton: true,
        confirmButtonText: 'yakin',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let aduanId = $('#id').val();
            $.ajax({
                url: "pengaduan/aduan/" + aduanId + "/check",
                type:"GET",
                success:function(data){
                    if(data.success == 1){
                        window.location.href = "pengaduan/aduan/" + aduanId;
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
    checkField = $("input#id").val().length;  

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

    $('input#id').keyup(function(){ 
        //checking the length of the value of message and assigning to the variable(checkField) on keyup
        checkField = $("input#id").val().length;
        //calling enableDisableButton() function on keyup
        enableDisableButton();
    });
});
</script>
@endpush