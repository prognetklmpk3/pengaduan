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
</div>

<!-- <div class="nk-fmg-body-content"> -->
    <div class="nk-fmg-quick-list nk-block">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p for="nama" class="form-label">Pengadu : {{ $aduan->pengadu->nama }}</p>
                        <p for="nama" class="form-label">Email : {{ $aduan->pengadu->email }}</p>
                        <p for="nama" class="form-label">Tanggal kejadian : {{ date('j F Y', strtotime($aduan->tanggal)) }}</p>
                    </div>
                    <div class="d-flex flex-column">
                        <p class="text-muted small mb-0"><i class="far fa-clock mr-1"></i> {{ date('j M, Y H:i', strtotime($aduan->date_create_aduan)) }}</p>
                        @if ($aduan->status_close)
                        <span class='badge badge-secondary ml-auto mt-1'>closed</span>
                        @else
                        <span class='badge badge-primary ml-auto mt-1'>aktif</span>
                        @endif
                    </div>
                </div>

                <h4 for="nama" class="form-label mt-3">{{ $aduan->aduan }}</h4>
                @if ($aduan->aduan_foto)
                <a class="mt-2 d-inline-block" target="_blank" href="{{ url('/storage/aduanfoto/' . $aduan->aduan_foto) }}">
                    <img class="img-thumbnail rounded d-inline-block" style="height:70px" src="{{ url('/storage/aduanfoto/' . $aduan->aduan_foto) }}" alt="Attachment Image">
                </a>
                @endif
            </div>
            <div class="card-body">
                @forelse ($aduan->respon as $item)
                <div class="card w-100" style="background-color: #fcfcfc;">
                    {{-- <div class="card-header d-flex justify-content-between p-3"> --}}
                    <div>
                        @if ($item->pengadu)
                        <div class="card-header px-3" style="background-color:#fff1ca;">
                            <div class="d-flex justify-content-between"> 
                                <p class="mb-0 fw-bold">{{ $item->pengadu->nama }}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock mr-1"></i> {{ date('j M, Y H:i', strtotime($item->tanggal)) }}</p>
                            </div>
                            <div>
                                <p>{{ $aduan->pengadu->email }}</p>
                            </div>
                        </div>
                        @else
                            <div class="card-header d-flex justify-content-between px-3" style="background-color: #d6eadf">
                                <p class="mb-0 fw-bold">Admin {{ $item->pegawai->nama }}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock mr-1"></i> {{ date('j M, Y H:i', strtotime($item->tanggal)) }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                        {{ $item->respon }}
                        </p>
                        @if ($item->respon_foto)
                        <a class="mt-2 d-inline-block" target="_blank" href="{{ url('/storage/responfoto/' . $item->respon_foto) }}">
                            <img class="img-thumbnail rounded d-inline-block" style="height:70px" src="{{ url('/storage/responfoto/' . $item->respon_foto) }}" alt="Attachment Image">
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center">
                    Belum ada tanggapan
                </div>
                @endforelse
            </div>
            @if (!$aduan->status_close)
            <div class="card-footer pt-4">
                @if (isset($pegawai))
                <p class="fw-bold mb-2">Admin {{ $pegawai->nama }}</p>
                <input id="responden" type="hidden" name="pegawai_id" value="{{ $pegawai->id }}" data-tipe="pegawai">
                @else
                <p class="fw-bold mb-1">{{ $aduan->pengadu->nama }}</p>
                <p>{{ $aduan->pengadu->email }}</p>
                <input id="responden" type="hidden" name="pengadu_id" value="{{ $aduan->pengadu_id }}" data-tipe="pengadu">
                @endif
                <textarea name="respon" class="form-control" id="respon" rows="3" placeholder="Masukkan tanggapan Anda" required></textarea>

                <div class="form-group mt-2">
                    <label for="respon_foto" class="mb-1">Respon foto</label>
        
                    <div class="custom-file">
                        <input type="file" name="respon_foto" id="respon_foto" class="custom-file-input @error('respon_foto') is-invalid @enderror">
                        <label class="custom-file-label" for="respon_foto">Pilih Gambar</label>
                        @error('respon_foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <button type="button" onclick="submitdata()" class="btn btn-primary mt-0" id="sendButton" value="Send">Kirim</button>
            </div>
            @endif
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
            let respondenInput = $('#responden');
            let nameId = respondenInput.attr('name');
            let respon_foto = $('#respon_foto')[0].files[0];

            let url = "{{url('pengaduan/respon')}}";
            if (respondenInput.data('tipe') === "pegawai") {
                url = "{{url('pegawai/respon')}}";
            }
                 
            var data = new FormData();
            data.append('_method', "POST");
            data.append('_token', "{{csrf_token()}}");
            data.append('aduan_id', "{{ $aduan->id }}");
            data.append(nameId, respondenInput.val());
            data.append('respon', $('#respon').val());
            if (respon_foto) {
                data.append('respon_foto', respon_foto);
            }

            // for (var i = 0; i < files.length; i++) {
            //         data.append("respon_foto", files[i]);
            // }


            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                data: data,
                type: "POST",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
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

$(document).ready(function(){
    var checkField;

    //checking the length of the value of message and assigning to a variable(checkField) on load
    checkField = $("textarea#respon").val().length;  

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

    $('textarea#respon').keyup(function(){ 
        //checking the length of the value of message and assigning to the variable(checkField) on keyup
        checkField = $("textarea#respon").val().length;
        //calling enableDisableButton() function on keyup
        enableDisableButton();
    });
});

</script>
@endpush