{{-- https://www.positronx.io/laravel-datatables-example/ --}}

@extends('layouts.app')
@section('action')

@endsection
@section('content')
<div class="nk-fmg-body-head d-none d-lg-flex">
    <div class="nk-fmg-search">
        <h4 class="card-title text-primary"><i class='{{$icon}}' data-toggle='tooltip' data-placement='bottom' title='Data {{$subtitle}}'></i>  {{strtoupper("Data ".$subtitle)}}</h4>
    </div>
    <div class="nk-fmg-actions">
        <div class="btn-group">
            {{-- <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary" onclick="buttondisable(this)"><em class="icon fas fa-plus"></em> <span>Ajukan Aduan</span></a> --}}
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
</div>

<!-- <div class="nk-fmg-body-content"> -->
    <div class="nk-fmg-quick-list nk-block">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p for="nama" class="form-label">Pengadu : {{ $aduan->pengadu->nama }}</p>
                        <h4 for="nama" class="form-label">{{ $aduan->aduan }}</h4>
                    </div>
                    <div class="d-flex flex-column">
                        <p class="text-muted small mb-0"><i class="far fa-clock mr-1"></i> {{ date('j F, Y', strtotime($aduan->tanggal)) }}</p>
                        @if ($aduan->status_close)
                        <span class='badge badge-secondary ml-auto mt-1'>closed</span>
                        @else
                        <span class='badge badge-primary ml-auto mt-1'>open</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @foreach($aduan->respon as $item)
                <div class="card w-100" style="background-color: #fcfcfc;">
                    <div class="card-header d-flex justify-content-between p-3">
                        @if ($item->pengadu)
                        <p class="fw-medium mb-0">{{ $item->pengadu->nama }}</p>
                        @else
                        <p class="fw-medium mb-0">{{ $item->pegawai->nama }} (Admin)</p>
                        @endif

                        <p class="text-muted small mb-0"><i class="far fa-clock mr-1"></i> {{ date('j M, Y H:i', strtotime($item->tanggal)) }}</p>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                        {{ $item->respon }}
                        </p>
                    </div>
                </div>
                @endforeach 
                
                @if (!$aduan->status_close)
                <textarea name="respon" class="form-control mt-4" id="respon" rows="3" placeholder="Masukkan Respon Anda" required></textarea>
                <button type="button" onclick="submitdata()" class="btn btn-primary mt-3" value="Send">Kirim</button>
                @endif
            </div>
        </div>
    </div>
<!-- </div> -->
@endsection

@push('script')
<script>
function submitdata(){
    CustomSwal.fire({
        icon:'question',
        text: 'Kirim tanggapan?',
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url:"{{url('admin/respon')}}",
                data:{
                    _method:"POST",
                    _token:"{{csrf_token()}}",
                    aduan_id: "{{ $aduan->id }}",
                    respon: $('#respon').val()
                },
                type:"POST",
                dataType:"JSON",
                success:function(data){
                    if(data.success == 1){
                        CustomSwal.fire('Sukses', data.msg, 'success');
                        window.location.reload();
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
</script>
@endpush