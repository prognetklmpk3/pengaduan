<?php

namespace App\Http\Controllers;

use App\Models\Pengadu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;




class CrudController extends Controller
{
    public function index(){
        $icon = 'ni ni-dashlite';
        $subtitle = 'Pengaduan';
        $table_id = 'tb_m_help_pengadu';
        return view('pengaduan',compact('subtitle','table_id','icon'));
    }

    public function listData(Request $request){
        $data = Pengadu::all();
        $datatables = DataTables::of($data);
        return $datatables
                ->addIndexColumn()
                ->addColumn('aksi', function($data){
                    $aksi = "";
                    $aksi .= "<a title='Edit Data' href='/pengaduan/".$data->id."/edit' class='btn btn-md btn-primary' data-toggle='tooltip' data-placement='bottom' onclick='buttonsmdisable(this)'><i class='ti-pencil' ></i></a>";
                    $aksi .= "<a title='Delete Data' href='javascript:void(0)' onclick='deleteData(\"{$data->id}\",\"{$data->nim}\",this)' class='btn btn-md btn-danger' data-id='{$data->id}' data-nim='{$data->nim}'><i class='ti-trash' data-toggle='tooltip' data-placement='bottom' ></i></a> ";
                    return $aksi;
                })
                ->rawColumns(['aksi'])
                ->make(true);
    }

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
        return view('create',compact('subtitle','icon'));
    }

    public function edit($id){
        $data = Pengadu::find($id);
        return view('edit', [
            'data' => $data
        ]);

    }

    public function store(Request $request)
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
            $create = Pengadu::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
            ]);

            if($create){
                $response = array('success'=>1,'msg'=>'Berhasil tambah data');
            }else{
                $response = array('success'=>2,'msg'=>'Gagal tambah data');
            }
            return $response;
        }
    }

    public function update(Request $request, $id)
    {

        // return $data;
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
            // $data->save();

            // $update = Pengadu::put([
            //     'nim' => $request->nim,
            //     'nama' => $request->nama,
            //     'alamat' => $request->alamat,
            // ]);

            if($data->save()){
                $response = array('success'=>1,'msg'=>'Berhasil Menyimpan Perubahan');
            }else{
                $response = array('success'=>2,'msg'=>'Gagal Menyimpan Perubahan');
            }
            return $response;
        }
    //     if($data){
    //         return redirect()->route('crud.list');
    //     }
    }

}