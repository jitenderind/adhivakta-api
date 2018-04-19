<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\AppealAlert;
use Illuminate\Http\Request;

class AppealAlertController extends Controller
{
    public function showUserAppealAlert($id)
    {
        $r=AppealAlert::where('userId',$id)->get();
        return response()->json($r);
    }
    
    public function showOneAppealAlert($id)
    {
        return response()->json(AppealAlert::find($id));
    }
    
    public function showSearchAppealAlert($key,$value){
        if($key && $value){
        $result = AppealAlert::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = AppealAlert::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = AppealAlert::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        AppealAlert::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>