<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aduan;
use App\Models\Pegawai;
use App\Models\AduanRespon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function formLogin() {
        $icon = 'ni ni-dashlite';
        $subtitle = 'Login Pegawai';
        
        return view('login-pegawai',compact('subtitle','icon'));
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'sso_user_id' => 'required|string',
        ]);

        $credentials = request(['username', 'sso_user_id']);
        
        if(!Auth::guard('pegawai')->attempt($credentials))
            return array('success'=>2,'msg'=>'username atau password salah');

        return array('success'=>1,'msg'=>'Berhasil login');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        return redirect('/');
    }

    public function index() {
        $icon = 'ni ni-dashlite';
        $subtitle = 'List Aduan';
        $table_id = 'tb_t_help_aduan';
        
        return view('list-aduan',compact('subtitle','table_id','icon'));
    }

    public function listAduan() {
        $listAduan = Aduan::with('respon', 'pengadu')->get();
        // $emptyResponAduan = collect();
        $unresponedAduan = collect();
        $respondedAduan = collect();
        foreach ($listAduan as $aduan) {
            if ($aduan->respon->count() < 1) {
                $aduan["status_respon"] = "kosong";
                $unresponedAduan->push($aduan);
            } else if($aduan->respon->last()->pengadu_id != null) {
                $aduan["status_respon"] = "belum dibalas";
                $unresponedAduan->push($aduan);
            } else {
                $aduan["status_respon"] = "sudah dibalas";
                $respondedAduan->push($aduan);
            }
        }

        //bubble sort
        for($i = 0; $i < $unresponedAduan->count(); $i++)
        {
            // Last i elements are already in place
            for ($j = 0; $j < $unresponedAduan->count() - $i - 1; $j++)
            {
                // traverse the array from 0 to n-i-1
                // Swap if the element found is greater
                // than the next element
                $nilai1 = $unresponedAduan[$j]->date_create_aduan;
                if ($unresponedAduan[$j]->respon->count() > 0) {
                    $nilai1 = $unresponedAduan[$j]->respon->last()->tanggal;
                }
                
                $nilai2 = $unresponedAduan[$j+1]->date_create_aduan;
                if ($unresponedAduan[$j+1]->respon->count() > 0) {
                    $nilai2 = $unresponedAduan[$j+1]->respon->last()->tanggal;
                }

                if ($nilai1 < $nilai2) {
                    $t = $unresponedAduan[$j];
                    $unresponedAduan[$j] = $unresponedAduan[$j+1];
                    $unresponedAduan[$j+1] = $t;
                }
            }
        }

        // sorting responded by last respon
        $respondedAduan = $respondedAduan->sortBy(function ($aduan) { 
            return $aduan->respon->last()->tanggal; 
       }, null, true); 

        $sortedAduan = $unresponedAduan->merge($respondedAduan);
        $datatables = DataTables::of($sortedAduan);
        return $datatables
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $aksi = "";
                $aksi .= "<a title='Lihat' href='/pegawai/aduan/".$data->id."' class='btn btn-md btn-primary' data-toggle='tooltip' data-placement='bottom' onclick='buttonsmdisable(this)'><i class='ti-eye'></i></a>";
                if (!$data->status_close) {
                    $aksi .= "<a title='Tutup Aduan' href='javascript:void(0)' onclick='updateData(\"{$data->id}\")' class='btn btn-md btn-danger ml-2'><i class='ti-close' data-toggle='tooltip' data-placement='bottom'></i></a> ";
                }
                return $aksi;
            })
            ->addColumn('status', function($data){
                $status = "<span class='badge badge-primary'>aktif</span>";
                if($data->status_close){
                    $status = "<span class='badge badge-secondary'>closed</span>";
                }
                return $status;
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function show($id) {
        $icon = 'ni ni-dashlite';
        $subtitle = 'Detail Aduan';
        $pegawai = Auth::guard('pegawai')->user();
        $aduan = Aduan::with('respon', 'pengadu')->where('id', $id)->first();

        return view('detail-aduan', compact('aduan','icon','subtitle','pegawai'));
    }

    public function store(Request $request) {
        $validation = $request->validate([
            'respon' => 'required',
            'aduan_id' => 'required',
            'respon_foto' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'pegawai_id' => 'required',
        ],[
            'respon.required' => "Kolom Respon harus diisi",
            'aduan_id.required' => "Kolom id aduan harus diisi",
            'pegawai_id.required' => "Kolom id pegawai harus diisi"
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
                'pegawai_id' => $request->pegawai_id,
                'tanggal' => Carbon::now(),
                'respon' => $request->respon,
                'respon_foto' => $request->respon_foto,
            ]);
            
            if($respon){
                $response = array('success'=>1,'msg'=>'Berhasil menyimpan tanggapan');
            }else{
                $response = array('success'=>2,'msg'=>'Gagal menyimpan tanggapan');
            }
            return $response;
        }
    }

    public function close($id) {
        $data = Aduan::find($id);
        $data->status_close ='1';

        if($data->save()){
            $response = array('success'=>1,'msg'=>'Berhasil menutup aduan');
        }else{
            $response = array('success'=>2,'msg'=>'Gagal menutup aduan');
        }
        return $response;
    }
}
