<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\CaseType;
use Illuminate\Http\Request;

class CaseTypeController extends Controller
{
    public function forumCaseTypes($id)
    {
        return response()->json(CaseType::where('forumId',$id)->get());
    }
    
    public function showOneCaseType($id)
    {
        return response()->json(CaseType::find($id));
    }
    
    public function showSearchCaseType($key,$value){
        if($key && $value){
        $result = CaseType::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = CaseType::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = CaseType::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        CaseType::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>