<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aduan;
use App\Models\AduanRespon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ResponController extends Controller
{
    public function index() {
        $icon = 'ni ni-dashlite';
        $subtitle = 'List Aduan';
        $table_id = 'tb_t_help_aduan';
        
        return view('list-aduan',compact('subtitle','table_id','icon'));
    }

    public function listAduan() {
        // $data = Aduan::with('pengadu')->get();
        $data = DB::table('t_help_aduan')
            ->join('m_help_pengadu', 't_help_aduan.pengadu_id', '=', 'm_help_pengadu.id')
            ->select('t_help_aduan.*', 'm_help_pengadu.nama')
            ->get();

        $datatables = DataTables::of($data);
        return $datatables
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $aksi = "";
                $aksi .= "<a title='Lihat' href='/admin/aduan/".$data->id."' class='btn btn-md btn-primary' data-toggle='tooltip' data-placement='bottom' onclick='buttonsmdisable(this)'><i class='ti-eye'></i></a>";
                if (!$data->status_close) {
                    $aksi .= "<a title='Tutup Aduan' href='javascript:void(0)' onclick='updateData(\"{$data->id}\")' class='btn btn-md btn-danger ml-2'><i class='ti-close' data-toggle='tooltip' data-placement='bottom'></i></a> ";
                }
                return $aksi;
            })
            ->addColumn('status', function($data){
                $status = "<span class='badge badge-primary'>open</span>";
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
        $aduan = Aduan::with('respon', 'pengadu')->where('id', $id)->first();

        return view('detail-aduan', compact('aduan','icon','subtitle'));
    }

    public function store(Request $request) {
        $validation = $request->validate([
            'respon' => 'required',
            'aduan_id' => 'required',
        ],[
            'respon.required' => "Kolom Respon harus diisi",
            'aduan_id.required' => "Kolom id aduan harus diisi"
        ]);

        if($validation){
            $responid = IdGenerator::generate(['table' => 't_help_aduan_respon', 'length' => 6, 'prefix' =>'R']);
            $respon = AduanRespon::create([
                'id' => $responid,
                'aduan_id' => $request->aduan_id,
                'pegawai_id' => '1',
                'tanggal' => Carbon::now(),
                'respon' => $request->respon
            ]);

            // if ($request->aduan_foto) {
            //     $file = $request->file('aduan_foto');
            //     if ($file->isValid()) {
            //         $imageName = md5(now() . "_" . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            //         $file->storeAs("public/aduanfoto/", $imageName);
            //         $request->aduan_foto = $imageName;
            //     }
            // }
            
            if($respon){
                $response = array('success'=>1,'msg'=>'Berhasil menyimpan tanggapan');
            }else{
                $response = array('success'=>2,'msg'=>'Gagal menyimpan tanggapan');
            }
            return $response;
        }
    }

    public function update($id) {
        $data = Aduan::find($id);
        $data->status_close ='1';
        $data->save();

        return redirect()->route('admin.index');
    }
}
