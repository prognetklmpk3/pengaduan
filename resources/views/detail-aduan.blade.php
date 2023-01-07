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
            <div class="card-body">
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <p for="nama" class="form-label">Nama : {{ $aduan->nama }}</p>
                        <p for="nama" class="form-label">Nomor Aduan : {{ $aduan->id }}</p>
                        <p for="nama" class="form-label">Respon Admin</p>

                        @foreach($aduan->respon as $item)
                        <div class="card w-100" style="background-color: #fcfcfc;">
                            <div class="card-header d-flex justify-content-between p-3">
                                @if ($item->pengadu)
                                <p class="fw-bold mb-0">{{ $item->pengadu->nama }}</p>
                                @else
                                <p class="fw-bold mb-0">{{ $item->pegawai->nama }} (Admin)</p>
                                @endif

                                <p class="text-muted small mb-0"><i class="far fa-clock mr-1"></i> {{ date('j F, Y', strtotime($item->tanggal)) }}</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                {{ $item->respon }}
                                </p>
                            </div>
                        </div>
                        @endforeach 
                        
                        <input type="hidden" value="{{ $aduan->id }}" name="aduan_id">
                        <textarea name="respon" class="form-control mt-4" id="exampleFormControlTextarea1" rows="3" placeholder="Masukkan Respon Anda"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="sendButton" value="Send">Kirim</button>
                </form>
            </div>
        </div>
    </div>
<!-- </div> -->
@endsection