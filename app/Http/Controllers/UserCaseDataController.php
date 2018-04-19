<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\UserCaseData;
use Illuminate\Http\Request;

class UserCaseDataController extends Controller
{
    public function showUserCaseData($id)
    {
        $r=UserCaseData::where('userCaseId',$id)->get();
        return response()->json($r);
    }
    
    public function showOneUserCaseData($id)
    {
        return response()->json(UserCaseData::find($id));
    }
    
    public function showUserCaseTypeData($id,$type){
        if($id && $type){
            $result = UserCaseData::where('userCaseId',$id)->where('data_type',$type)->get();
            return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    public function showSearchUserCaseData($key,$value){
        if($key && $value){
        $result = UserCaseData::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = UserCaseData::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = UserCaseData::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        UserCaseData::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>