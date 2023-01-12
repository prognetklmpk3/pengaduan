<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aduan;
use App\Models\Pengadu;
use App\Models\JenisAduan;
use App\Models\AduanRespon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class PengaduController extends Controller
{
    public function index(){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Pengaduan';
        $table_id = 'tb_m_help_pengadu';

        return view('pengaduan',compact('subtitle','table_id','icon'));
    }

    public function create(){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Tambah Data Pengadu';
        $jenis_aduan = JenisAduan::all();
        return view('create',compact('subtitle','icon','jenis_aduan'));
    }
    
    public function checkAduan($id){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Detail Aduan';

        $aduan = Aduan::find($id);

        if($aduan){
            $response = array('success'=>1,'msg'=>'Berhasil menemukan nomor aduan');
        }else{
            $response = array('success'=>2,'msg'=>'Gagal menemukan nomor aduan');
        }
        return $response;
    }

    public function show($id){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Detail Aduan';

        $aduan = Aduan::find($id);

        if (!$aduan) {
            return redirect()->route('pengaduan.welcome');
        }

        $aduan->load('respon', 'pengadu');

        return view('detail-aduan', compact('aduan','icon','subtitle'));
    }

    public function respon(Request $request) {
        $validation = $request->validate([
            'respon' => 'required',
            'aduan_id' => 'required',
            'pengadu_id' => 'required',
            'respon_foto' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ],[
            'respon.required' => "Kolom Respon harus diisi",
            'aduan_id.required' => "Kolom id aduan harus diisi",
            'pengadu_id.required' => "Kolom id pengadu harus diisi",
        ]);

        if($validation){
            $responid = IdGenerator::generate(['table' => 't_help_aduan_respon', 'length' => 6, 'prefix' =>'R']);

            if ($request->respon_foto) {
                $file = $request->file('respon_foto');
                if ($file->isValid()) {
                    $imageName = md5(now() . "_" . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs("public/responfoto/", $imageName);
                    $request->respon_foto = $imageName;
                }
            }

            $respon = AduanRespon::create([
                'id' => $responid,
                'aduan_id' => $request->aduan_id,
                'pengadu_id' => $request->pengadu_id,
                'tanggal' => Carbon::now(),
                'respon' => $request->respon,
                'respon_foto' => $request->respon_foto
            ]);
            
            if($respon){
                $response = array('success'=>1,'msg'=>'Berhasil menyimpan tanggapan');
            }else{
                $response = array('success'=>2,'msg'=>'Gagal menyimpan tanggapan');
            }
            return $response;
        }
    }

    public function thanks($id){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Terima kasih';
        $aduan = Aduan::find($id)->load('pengadu');
        return view('thanks',compact('subtitle','icon','aduan'));
    }

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
                $response = array('success'=>1,'msg'=>'Berhasil tambah data', 'idAduan' => $aduan->id);
                $mail_data = [
                    'recipient'=>$request->email,
                    'fromEmail'=>'christinahartono@student.unud.ac.id',
                    'fromName'=>$request->name,
                    'subject'=>'Cek aduanmu disini!',
                    'id'=>$aduan->id
                ];
                Mail::send('email-template',$mail_data, function ($message) use ($mail_data){
                    $message->to($mail_data['recipient'])
                            ->from($mail_data['fromEmail'], $mail_data ['fromName'])
                            ->subject ($mail_data['subject']);
                });

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