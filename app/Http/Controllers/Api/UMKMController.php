<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\umkm;

class UMKMController extends Controller
{
    //untuk show umkm
    public function index()
    {
        $umkm = umkm::all();

        if(count($umkm) > 0)
        {
            return response([
                'message' => 'Retrieve All UMKM Success',
                'data' => $umkm
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function indexByUser($id_user)
    {
        $umkm = umkm::where('id_user' ,$id_user)->get();

        if(!is_null($umkm)) {
            return response([
                'message' => 'Retrieve UMKM Success',
                'data' => $umkm
            ], 200);
        }

        return response([
            'message' => 'UMKM Not Found',
            'data' => null
        ], 404);
    }
    
    //untuk show umkm berdasarkan pencarian
    public function show($id)
    {
        $umkm = umkm::find($id);

        if(!is_null($umkm)) {
            return response([
                'message' => 'Retrieve UMKM Success',
                'data' => $umkm
            ], 200);
        }

        return response([
            'message' => 'UMKM Not Found',
            'data' => null
        ], 404);
    }

    //untuk menambahkan 1 data umkm baru
    public function store(Request $request)
    {
        $umkmData = $request->all();
        $validate = Validator::make($umkmData, [
            'nama_umkm' => 'required|max:60',
            'id_user',
            'profil_url' => 'required',
            'gambar_umkm' => 'required',
            'detail_umkm' => 'required',
            'alamat_umkm' => 'required',
            'motto_umkm' => 'required',
        ]);

        if($validate->fails())
        {
            return response([
                'message' => $validate->errors()
            ],400);
        }

        $umkm = umkm::create($umkmData);
        return response([
            'message' => 'Add UMKM Success',
            'data' => $umkm
        ], 200);
    }

    //untuk menghapus 1 data umkm 
    public function destroy($id)
    {
        $umkm = umkm::find($id);

        if(is_null($umkm)) {
            return response([
                'message' => 'UMKM Not Found',
                'data' => null
            ], 404);
        }

        if($umkm->delete())
        {
            return response ([
                'message' => 'Delete UMKM Success',
                'data' => $umkm
            ], 200);
        }

        return response ([
            'message' => 'Delete UMKM Failed',
            'data' => null,
        ], 400);
    }

    //untuk mengubah 1 data umkm
    public function update(Request $request, $id)
    {
        $umkm = umkm::find($id);
        if(is_null($umkm))
        {
            return response([
                'message' => 'UMKM Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_umkm' => 'required|max:60',
            'profil_url' => 'required',
            'gambar_umkm' => 'required',
            'id_user' => 'required',
            'detail_umkm' => 'required',
            'alamat_umkm' => 'required',
            'motto_umkm' => 'required',
        ]);

        if($validate->fails())
        {
            return response([
                'message' => $validate->errors()
            ], 400);
        }

        $umkm->nama_umkm = $updateData['nama_umkm'];
        $umkm->profil_url = $updateData['profil_url'];
        $umkm->gambar_umkm = $updateData['gambar_umkm'];
        $umkm->id_user = $updateData['id_user'];
        $umkm->detail_umkm = $updateData['detail_umkm'];
        $umkm->alamat_umkm = $updateData['alamat_umkm'];
        $umkm->motto_umkm = $updateData['motto_umkm'];

        if($umkm->save())
        {
            return response([
                'message' => 'Update UMKM Success',
                'data' => $umkm
            ], 200);
        }

        return response([
            'message' => 'Update UMKM Failed',
            'data' => null
        ], 400);
    }
}
