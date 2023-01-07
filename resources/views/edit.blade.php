{{-- https://www.positronx.io/laravel-datatables-example/ --}}

@extends('layouts.app')
@section('action')

@endsection
@section('content')
<div class="nk-fmg-body-head d-none d-lg-flex">
    <div class="nk-fmg-search">
        <!-- <em class="icon ni ni-search"></em> -->
        <!-- <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search files, folders"> -->
        <h4 class="card-title text-primary"><i class='ni ni-dashlite' data-toggle='tooltip' data-placement='bottom' title='Edit Data Mahasiswa'></i>  {{strtoupper('Edit Data Mahasiswa')}}</h4>
    </div>
    <div class="nk-fmg-actions">
        <div class="btn-group">
            <!-- <a href="#" target="_blank" class="btn btn-sm btn-success"><em class="icon ti-files"></em> <span>Export Data</span></a> -->
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDefault">Modal Default</button> -->
            <!-- <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalDefault"><em class="icon ti-file"></em> <span>Filter Data</span></a> -->
            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="filtershow()"><em class="icon ti-file"></em> <span>Filter Data</span></a> -->
            <a href="{{ route('pengaduan.welcome') }}" class="btn btn-sm btn-primary" onclick="buttondisable(this)"><em class="icon fas fa-arrow-left"></em> <span>Kembali</span></a>
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
        <div class="row gy-3" >

        </div>
    </div>
    <!-- <div class="card-footer" style="background:#fff" align="right"> -->
    <div class="card-footer" style="background:#f7f9fd; padding-top:0px !important;">
        <div class="btn-group">
            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-dark" onclick="filterclear()"><em class="icon ti-eraser"></em> <span>Clear Filter</span></a> -->
            <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="filterdata()"><em class="icon ti-reload"></em> <span>Submit Filter</span></a>
        </div>
    </div>
</div>

<!-- <div class="nk-fmg-body-content"> -->
    <div class="nk-fmg-quick-list nk-block">
        <div class="card">
            <div class="card-body">
                Elemen form edit data mahasiswa "{{ $data->nama }}"
            </div>
        </div>
    </div>
<!-- </div> -->
<div>
    <form action="{{ route('crud.update', $data->id) }}" method="post">
        @method('PATCH')
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <input name="nama" type="text" value="{{ $data->nama }}"class="form-control" id="nama" aria-describedby="nama">
        </div>
        <div class="mb-3">
            <label for="nim" class="form-label">Nim Mahasiswa</label>
            <input name="nim" type="text" value="{{ $data->nim }}" class="form-control" id="nim" aria-describedby="nim">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input name="alamat" type="text" value="{{ $data->alamat }}"class="form-control" id="alamat" aria-describedby="alamat">
        </div>

        <a href="javascript:void(0)" onclick="submitdata(this)"  class="btn btn-primary">Simpan</a>
    </form>
</div>
@endsection


@push('script')
<script>
function submitdata(elm){
    buttonsmdisable(elm);
    CustomSwal.fire({
        icon:'question',
        text: 'Simpan Perubahan Data?',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let nim = $('#nim').val();
            let nama = $('#nama').val();
            let alamat = $('#alamat').val();
            $.ajax({
                url:"{{url('crud')}}",
                data:{
                    _method:"POST",
                    _token:"{{csrf_token()}}",
                    nim: nim,
                    nama: nama,
                    alamat: alamat
                },
                type:"POST",
                dataType:"JSON",
                success:function(data){
                    if(data.success == 1){
                        CustomSwal.fire('Sukses', data.msg, 'success');
                        window.location.href = "{{ route('crud.list')}}";
                    }else{
                        CustomSwal.fire('Gagal', data.msg, 'error');
                        buttonsmenable(elm);
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

</script>
@endpush