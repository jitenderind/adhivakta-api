<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\CaseData;
use Illuminate\Http\Request;

class CaseDataController extends Controller
{
    public function showSpecificCaseData($id)
    {
        return response()->json(CaseData::where('caseId',$id)->get());
    }
    
    public function showOneCaseData($id)
    {
        return response()->json(CaseData::find($id));
    }
    
    public function showCaseTypeData($id,$type){
        if($id && $type){
            $result = CaseData::where('caseId',$id)
                                ->where('data_type',$type)->orderBy('data_date','desc')->get()->toArray();
            foreach ($result as $k=>$value){
                //get value
                $vals=explode(";", $value['data_value']);
                foreach($vals as $v){
                    $n=explode(":", $v);
                    if(isset($n[1])){
                    $result[$k][str_replace(' ','_',$n[0])]=$n[1];
                    }
                }
            }
            return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function showSearchCaseData($key,$value){
        if($key && $value){
        $result = CaseData::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = CaseData::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = CaseData::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        CaseData::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>