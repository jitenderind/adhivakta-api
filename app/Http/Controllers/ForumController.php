<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller;
use App\Models\Forum;
use App\Models\UserForum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function showAllForums()
    {
        return response()->json(Forum::all());
    }
    
    public function showUserForums($userId)
    {
        $result=array();
        $k=0;
        $userForums=\DB::table('user_forums')->select('user_forums.*','forums.forum')
        ->leftjoin('forums','forums.forumId','=','user_forums.forumId')->where('userId',$userId)->get();
        foreach($userForums as $uf){
            $result[$k]['forum']=$uf->forum;
            $result[$k]['forumId']=$uf->forumId;
            $result[$k]['category']="Recent";
            $k++;
        }
        $resultRaw=Forum::all();
        foreach ($resultRaw as $i=>$r){
            $result[$k]['forum']=$r->forum;
            $result[$k]['forumId']=$r->forumId;
            $result[$k]['category']="All";
            $k++;
        }
        return response()->json($result);
    }
    
    public function showOneForum($id)
    {
        return response()->json(Forum::find($id));
    }
    
    public function showSearchForum($key,$value){
        if($key && $value){
        $result = Forum::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = Forum::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = Forum::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        Forum::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>