<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions=Permission::all();
        return view('master.permission',compact('permissions'));
    }

    public function data(Request $request)
    {
        $permissions = Permission::select(['id', 'name', 'created_at', 'updated_at']);

        (!is_null($request->name)) ? $permissions->where('name','like','%'.$request->name.'%') : '';

        return DataTables::of($permissions)->make(true);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'    =>  'trim|escape',
        ];

        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        try{
            DB::beginTransaction();

            $permission = Permission::create([
                'name' => $attrclean['name'],
                'guard_name' => 'web' 
            ]);
            
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            return response()->json(['status'=>false,'data'=>'Cannot Proccess'], 200);
        }

        return response()->json(['status'=>true,'data'=>$permission], 200);
    }

    public function detail(Permission $permission)
    {
        return response()->json(['status'=>true,'data'=>$permission], 200);
    }

    public function update(Request $request,Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name'=>[
                'required',
                Rule::unique('permissions')->ignore($permission->id)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }
        $filters = [
            'name'    =>  'trim|escape',
        ];

        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        try{
            DB::beginTransaction();

            $permission->name=$attrclean['name'];
            $permission->save();

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            return response()->json(['status'=>false,'data'=>'Cannot Proccess'], 200);
        }
        
        return response()->json(['status'=>true,'data'=>$permission], 200);
    }

    public function delete(Permission $permission)
    {
        try{
            DB::beginTransaction();

            $permission->delete();

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            return response()->json(['status'=>false,'data'=>'Cannot Proccess'], 200);
        }
        return response()->json(['status'=>true,'data'=>'Success'], 200);
    }
}
