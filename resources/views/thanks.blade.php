{{-- https://www.positronx.io/laravel-datatables-example/ --}}

@extends('layouts.app')
@section('action')

@endsection
@section('content')
<div class="nk-fmg-body-head d-none d-lg-flex">
    <div class="nk-fmg-search">
        <h4 class="card-title text-primary"><i class='{{$icon}}' data-toggle='tooltip' data-placement='bottom' title='Data {{$subtitle}}'></i>  {{strtoupper($subtitle)}}</h4>
    </div>
    <div class="nk-fmg-actions">
        <div class="btn-group">
            <a href="{{ route('pengaduan.welcome') }}" class="btn btn-sm btn-primary" onclick="buttondisable(this)"><em class="icon fas fa-arrow-left"></em> <span>Halaman Utama</span></a>
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
            <div class="card-body">
                <div>
                    <div class="mb-4 fw-bold" style="font-size:20px">Terima kasih {{ $pengadu->nama }} telah menyampaikan laporan, kritik maupun saran perbaikan Anda kepada kami.</div>
                    <div class="mb-4 fw-bold" style="font-size:20px">Masukan Anda akan segera kami tanggapi</div>
                    <div class="mb-4 fw-bold" style="font-size:20px">Berikut nomor pengaduan Anda : {{ $id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->

@endsection
