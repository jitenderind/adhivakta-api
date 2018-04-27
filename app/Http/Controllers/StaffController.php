<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function showAllUserStaff($id)
    {
        $r=Staff::where('parentUserId',$id)->where('userId','!=','0')->orderBy('user_type','asc')->orderBy('first_name','asc')->get();
        return response()->json($r);
    }
    
    
    public function showOneStaff($id)
    {
        return response()->json(Staff::find($id));
    }
    
    public function showSearchStaff($key,$value){
        if($key && $value){
        $result = Staff::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = Staff::create($request->all());
       //var_dump($author);
    
        return response()->json($author);
    }
    
    public function update($id, Request $request)
    {
        $author = Staff::findOrFail($id);
        $author->update($request->all());
        var_dump($id);
        var_dump($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        Staff::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>