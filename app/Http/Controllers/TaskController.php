<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function showAllUserTask($id)
    {
        $type=$_GET['type'];
        $mine = $_GET['mine'];
        $r=\DB::table('tasks')
        ->select('tasks.*','user_cases.caseTitle',DB::raw('CONCAT(staff.first_name," ",staff.last_name) as assignedUser'))
        ->leftJoin('user_cases','user_cases.caseId','=','tasks.userCaseId')
        ->leftJoin('staff','staff.userId','=','tasks.assignedTo')
        ->where('tasks.userId',$id)
        ->orderBy('tasks.is_completed','asc')
        ->orderBy('tasks.due_date','asc');
        
        if($type=='open'){
            $r->where('tasks.is_completed',0);
        } else if($type=='complete'){
            $r->where('tasks.is_completed',1);
        }
        
        if($mine!="all"){
            $r->where('tasks.assignedTo',$mine);
        }
        $result=$r->paginate(10);
        
        return response()->json($result);
    }
    
    public function showAllCaseTask($id)
    {
         $type=$_GET['type'];
        $r=\DB::table('tasks')
        ->select('tasks.*','user_cases.caseTitle',DB::raw('CONCAT(staff.first_name," ",staff.last_name) as assignedUser'))
        ->leftJoin('user_cases','user_cases.caseId','=','tasks.userCaseId')
        ->leftJoin('staff','staff.userId','=','tasks.assignedTo')
        ->where('tasks.userCaseId',$id)
        ->orderBy('tasks.is_completed','asc')
        ->orderBy('tasks.due_date','asc');
        
        if($type=='open'){
            $r->where('tasks.is_completed',0);
        } else if($type=='complete'){
            $r->where('tasks.is_completed',1);
        }
        
        $result=$r->get();
        
        return response()->json($result);
    }
    
    public function showOneTask($id)
    {
        return response()->json(Task::find($id));
    }
    
    public function showSearchTask($id,$key){
        if($key){
        $type=$_GET['type'];
        $mine = $_GET['mine'];
        $r=\DB::table('tasks')
        ->select('tasks.*','user_cases.caseTitle',DB::raw('CONCAT(staff.first_name," ",staff.last_name) as assignedUser'))
        ->leftJoin('user_cases','user_cases.caseId','=','tasks.userCaseId')
        ->leftJoin('staff','staff.userId','=','tasks.assignedTo')
        ->where('tasks.userId',$id)
        ->where(function ($query) use ($key) {
                $query->where('tasks.task','like','%'.$key.'%')->orWhere('staff.first_name','like','%'.$key.'%')->orWhere('staff.last_name','like','%'.$key.'%')->orWhere('tasks.due_date','like','%'.$key.'%');
            })
        ->orderBy('tasks.is_completed','asc')
        ->orderBy('tasks.due_date','asc');
        
        if($type=='open'){
            $r->where('tasks.is_completed',0);
        } else if($type=='complete'){
            $r->where('tasks.is_completed',1);
        }
        
        if($mine!="all"){
            $r->where('tasks.assignedTo',$mine);
        }
        $result=$r->paginate(10);
        
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = Task::create($request->all());
       //var_dump($author);
    
        return response()->json($author);
    }
    
    public function update($id, Request $request)
    {
        $author = Task::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        Task::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>