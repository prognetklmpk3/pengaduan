<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Pengadu;
use App\Models\JenisAduan;
use App\Models\AduanRespon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class PengaduController extends Controller
{
    public function index(){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Pengaduan';
        $table_id = 'tb_m_help_pengadu';
        return view('pengaduan',compact('subtitle','table_id','icon'));
    }

    // public function listData(Request $request){
    //     $data = Pengadu::all();
    //     $datatables = DataTables::of($data);
    //     return $datatables
    //             ->addIndexColumn()
    //             ->addColumn('aksi', function($data){
    //                 $aksi = "";
    //                 $aksi .= "<a title='Edit Data' href='/Pengadu/".$data->id."/edit' class='btn btn-md btn-primary' data-toggle='tooltip' data-placement='bottom' onclick='buttonsmdisable(this)'><i class='ti-pencil' ></i></a>";
    //                 $aksi .= "<a title='Delete Data' href='javascript:void(0)' onclick='deleteData(\"{$data->id}\",\"{$data->nim}\",this)' class='btn btn-md btn-danger' data-id='{$data->id}' data-nim='{$data->nim}'><i class='ti-trash' data-toggle='tooltip' data-placement='bottom' ></i></a> ";
    //                 return $aksi;
    //             })
    //             ->rawColumns(['aksi'])
    //             ->make(true);
    // }

    public function deleteData(Request $request){
        if(Pengadu::destroy($request->id)){
            $response = array('success'=>1,'msg'=>'Berhasil hapus data');
        }else{
            $response = array('success'=>2,'msg'=>'Gagal menghapus data');
        }
        return $response;
    }

    public function create(){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Tambah Data Pengadu';
        $jenis_aduan = JenisAduan::all();
        return view('create',compact('subtitle','icon','jenis_aduan'));
    }

    public function status(Request $request){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Status Pengaduan';

        $aduan = Aduan::find($request->id);
        $statusbalas = 'Pengaduan Anda belum dibalas';
        if ($aduan!=null) {
            $aduan->load('respon');
            // dd($aduan);
            if ($aduan->respon->count() > 0) {
                $statusbalas = 'Pengaduan Anda sudah dibalas';
            }
        }else {
            $statusbalas = 'Nomor pengaduan Anda tidak ditemukan';
        }
        // dd($aduan->respon);
        return view('status',compact('subtitle','icon','statusbalas','aduan'));
    }

    public function thanks($id){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Terima kasih';
        $pengadu = Pengadu::find($id);
        return view('thanks',compact('subtitle','icon','pengadu', 'id'));
    }


    // public function edit($id){
    //     $data = Pengadu::find($id);
    //     return view('edit', [
    //         'data' => $data
    //     ]);

    // }

    public function store(Request $request)
    {

        $validation = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'jenis_aduan_id' => 'required',
            'tanggal' => 'required',
            'aduan' => 'required',
            'aduan_foto' => 'required|file|mimes:jpg,png,jpeg|max:2048'
        ],[
            'nama.required' => "Kolom Nama harus diisi",
            'alamat.required' => "Kolom Alamat harus diisi",
            'telepon.required' => "Kolom Telepon harus diisi",
            'email.required' => "Kolom Email harus diisi",
            'jenis_aduan_id.required' => "Kolom Jenis Aduan harus diisi",
            'tanggal.required' => "Kolom Tanggal Kejadian harus diisi",
            'aduan.required' => "Kolom Aduan harus diisi",
            'aduan_foto.required' => "Kolom Foto Aduan harus diisi"
        ]);

        if($validation){
            $pengaduid = IdGenerator::generate(['table' => 'm_help_pengadu', 'length' => 6, 'prefix' =>'P']);
            $pengadu = Pengadu::create([
                'id' => $pengaduid,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                //nama field => $request->name view
            ]);


            if ($request->aduan_foto) {
                $file = $request->file('aduan_foto');
                if ($file->isValid()) {
                    $imageName = md5(now() . "_" . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs("public/aduanfoto/", $imageName);
                    $request->aduan_foto = $imageName;
                }
            }

            $aduan = Aduan::create([
                'pengadu_id' => $pengaduid,
                'jenis_aduan_id' => $request->jenis_aduan_id,
                'tanggal' => $request->tanggal,
                'aduan' => $request->aduan,
                'aduan_foto' => $request->aduan_foto,
            ]);

            if($pengadu && $aduan){
                $response = array('success'=>1,'msg'=>'Berhasil tambah data', 'idPengaduan' => $pengaduid);
            }else{
                $response = array('success'=>2,'msg'=>'Gagal tambah data');
            }
            return $response;
        }
    }
    
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'telepon',
            'email' => 'email'
        ],[
            'nama.required' => "Kolom Nama harus diisi",
            'alamat.required' => "Kolom Alamat harus diisi",
            'telepon.required' => "Kolom Telepon harus diisi",
            'email.required' => "Kolom Email harus diisi"
        ]);

        if($validation){
            $data = Pengadu::find($request->id);
            $data->nama = $request->nama;
            $data->alamat = $request->alamat;
            $data->telepon = $request->telepon;
            $data->email = $request->email;

            if($data->save()){
                $response = array('success'=>1,'msg'=>'Berhasil Menyimpan Perubahan');
            }else{
                $response = array('success'=>2,'msg'=>'Gagal Menyimpan Perubahan');
            }
            return $response;
        }
    }

}