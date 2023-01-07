{{-- https://www.positronx.io/laravel-datatables-example/ --}}

@extends('layouts.app')
@section('action')

@endsection
@section('content')
<div class="mb-3">

<div class="nk-fmg-body-head d-none d-lg-flex">
    <div class="nk-fmg-search">
        <!-- <em class="icon ni ni-search"></em> -->
        <!-- <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search files, folders"> -->
        <h4 class="card-title text-primary"><i class='{{$icon}}' data-toggle='tooltip' data-placement='bottom' title='{{$subtitle}}'></i>  {{strtoupper($subtitle)}}</h4>
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
                Silahkan masukan biodata Anda dengan benar.
            </div>
        </div>
    </div>

<form action="{{ route('pengaduan.store') }}" method="POST" id="formmhs">
    @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Masukan Nama" aria-describedby="nama">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input name="alamat" type="text" class="form-control  @error('alamat') is-invalid @enderror" id="alamat" placeholder="Masukan Alamat" aria-describedby="alamat">
            @error('alamat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Nomor Telepon</label>
            <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" placeholder="Masukan Nomor Telepon" aria-describedby="telepon">
            @error('telepon')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukan Email" aria-describedby="email">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jenis_aduan" class="form-label">Jenis Aduan</label>
            <select name="jenis_aduan_id" id="jenis_aduan" class="form-control">
                <option disabled selected>Pilih Jenis Aduan</option>
                @foreach ($jenis_aduan as $j_aduan)
                <option value=" {{ $j_aduan->id }}"> {{ $j_aduan->jenis_aduan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Kejadian</label>
            <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" aria-describedby="tanggal">
            @error('tanggal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="aduan" class="form-label">Isi Aduan</label>
            <textarea name="aduan" type="text" class="form-control @error('aduan') is-invalid @enderror" id="aduan" placeholder="Masukan Isi Aduan" aria-describedby="aduan"></textarea>
            @error('aduan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="aduan_foto">Bukti Foto Aduan<span class="text-danger">*</span></label>

            <div class="custom-file">
                <input type="file" name="aduan_foto" id="aduan_foto" class="custom-file-input @error('aduan_foto') is-invalid @enderror" required>
                <label class="custom-file-label" for="aduan_foto">Pilih Gambar</label>
                @error('aduan_foto')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <a href="javascript:void(0)" onclick="submitdata(this)"  class="btn btn-primary">Simpan</a>
<!-- </div> -->
</form>
@endsection

@push('script')
<script>
function submitdata(elm){
    buttonsmdisable(elm);
    CustomSwal.fire({
        icon:'question',
        text: 'Simpan Pengaduan Anda?',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {            
            let nama = $('#nama').val();
            let alamat = $('#alamat').val();
            let telepon = $('#telepon').val();
            let email = $('#email').val();
            let jenis_aduan_id = $('#jenis_aduan').val();  
            let tanggal = $('#tanggal').val();
            let aduan = $('#aduan').val();
            let aduan_foto = $('#aduan_foto')[0].files[0];

            var data = new FormData();
            data.append('nama',nama);
            data.append('alamat',alamat);
            data.append('telepon',telepon);
            data.append('email',email);
            data.append('jenis_aduan_id',jenis_aduan_id);
            data.append('tanggal',tanggal);
            data.append('aduan',aduan);
            data.append('aduan_foto',aduan_foto);
            data.append("_token","{{csrf_token()}}");

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                url:"{{ url('pengaduan') }}" + "?_token={{ csrf_token() }}",
                data:data,
                type:"POST",
                success:function(data){
                    if(data.success == 1){
                        CustomSwal.fire('Sukses', data.msg, 'success');
                        window.location.href = "pengaduan/thanks/" + data.idPengaduan;
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
