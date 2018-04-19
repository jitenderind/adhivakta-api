<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\UserCases;
use Illuminate\Http\Request;
use App\Models\UserForum;
use App\Courts\Courts;

class UserCasesController extends Controller
{
    public function showUserCases($id)
    {
       $cases=\DB::table('user_cases')
        ->select('user_cases.caseTitle','user_cases.userCaseId','user_cases.caseId','user_cases.fileNo','user_cases.client_name','user_cases.client_phone','user_cases.client_email','cases.nextListingKind','cases.caseNo','cases.caseYear','cases.diaryNo','cases.nextListing','cases.nextListingCourt','cases.nextListingCourtNo','cases.nextListingItemNo','cases.status','case_types.caseType','forums.forum')
        ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
        ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
        ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
        ->where('user_cases.userId',$id)->where('user_cases.is_archived',0)->orderBy('cases.status','desc')->orderBy('cases.nextListing','desc')->paginate(10);
        return response()->json($cases);
    }
    
    public function showUserArchivedCases($id)
    {
        $cases=\DB::table('user_cases')
        ->select('user_cases.caseTitle','user_cases.userCaseId','user_cases.caseId','user_cases.fileNo','user_cases.client_name','user_cases.client_phone','user_cases.client_email','cases.nextListingKind','cases.caseNo','cases.caseYear','cases.diaryNo','cases.nextListing','cases.nextListingCourt','cases.nextListingCourtNo','cases.nextListingItemNo','cases.status','case_types.caseType','forums.forum')
        ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
        ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
        ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
        ->where('user_cases.userId',$id)->where('user_cases.is_archived',1)->orderBy('cases.status','desc')->orderBy('cases.nextListing','desc')->paginate(10);
        return response()->json($cases);
    }
    
    public function showOneUserCase($userId,$id)
    {
        $case=\DB::table('user_cases')
        ->select('user_cases.*','cases.*','case_types.caseType as forumCaseType','forums.forum')
        ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
        ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
        ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
        ->where('user_cases.userCaseId',$id)->where('user_cases.userId',$userId)->get();
        if(count($case)){
            return response()->json($case);
        } else {
            return response()->json(['caseTitle'=>'Bad Request','caseError'=>'Request case details are not available']);
        }
    }
    
    public function showSearchUserCases($id,$key){
            $cases=\DB::table('user_cases')
            ->select('user_cases.caseTitle','user_cases.userCaseId','user_cases.caseId','user_cases.fileNo','user_cases.client_name','user_cases.client_phone','user_cases.client_email','cases.nextListingKind','cases.caseNo','cases.caseYear','cases.diaryNo','cases.nextListing','cases.nextListingCourt','cases.nextListingCourtNo','cases.nextListingItemNo','cases.status','case_types.caseType','forums.forum')
            ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
            ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
            ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
            ->where('user_cases.userId',$id)->where('user_cases.is_archived',0)
            ->where(function ($query) use ($key) {
                $query->where('cases.caseYear','like','%'.$key.'%')->orWhere('cases.caseNo','like','%'.$key.'%')->orWhere('cases.caseTitle','like','%'.$key.'%')->orWhere('cases.diaryNo','like','%'.$key.'%')
            ->orWhere('user_cases.client_name','like','%'.$key.'%')->orWhere('user_cases.client_email','like','%'.$key.'%')->orWhere('user_cases.client_phone','like','%'.$key.'%')->orWhere('user_cases.client_address','like','%'.$key.'%');
            })
            ->orderBy('cases.status','desc')->orderBy('cases.nextListing','desc')->paginate(10);
        return response()->json($cases);
    }
    
    public function showSearchUserArchivedCases($id,$key){
        $cases=\DB::table('user_cases')
        ->select('user_cases.caseTitle','user_cases.userCaseId','user_cases.caseId','user_cases.fileNo','user_cases.client_name','user_cases.client_phone','user_cases.client_email','cases.nextListingKind','cases.caseNo','cases.caseYear','cases.diaryNo','cases.nextListing','cases.nextListingCourt','cases.nextListingCourtNo','cases.nextListingItemNo','cases.status','case_types.caseType','forums.forum')
        ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
        ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
        ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
        ->where('user_cases.userId',$id)->where('user_cases.is_archived',1)
        ->where(function ($query) use ($key) {
            $query->where('cases.caseYear','like','%'.$key.'%')->orWhere('cases.caseNo','like','%'.$key.'%')->orWhere('cases.caseTitle','like','%'.$key.'%')->orWhere('cases.diaryNo','like','%'.$key.'%')
            ->orWhere('user_cases.client_name','like','%'.$key.'%')->orWhere('user_cases.client_email','like','%'.$key.'%')->orWhere('user_cases.client_phone','like','%'.$key.'%')->orWhere('user_cases.client_address','like','%'.$key.'%');
        })
        ->orderBy('cases.status','desc')->orderBy('cases.nextListing','desc')->paginate(10);
        return response()->json($cases);
    }
    
    public function showUserCauselist($id,$date=""){
        $cases=\DB::table('user_cases')
        ->select('user_cases.caseTitle','user_cases.userCaseId','user_cases.caseId','cases.caseNo','cases.caseYear','cases.diaryNo','cases.nextListing','cases.nextListingCourt','cases.nextListingCourtNo','cases.nextListingItemNo','cases.status','case_types.caseType','forums.forum')
        ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
        ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
        ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
        ->where('user_cases.userId',$id)->where('nextListing','>=',date("Y-m-d"))->orderBy('cases.status','desc')->orderBy('cases.nextListing','desc')->get();
        return response()->json($cases);
    }
    
    public function showUserDisplayBoard($userId){
        $type=$_GET['type'];
    $forums = \App\Models\UserForum::select('forumId')->where('userId',$userId)->get()->toArray();
        $forums = array_map(function ($value) {
            return (array)$value;
        }, $forums);
            $db_data=Courts::getDisplayBoard($forums);
         $cases=\DB::table('user_cases')
            ->select('user_cases.caseTitle','user_cases.userCaseId','user_cases.caseId','cases.caseNo','cases.caseYear','cases.diaryNo','cases.nextListing','cases.nextListingCourt','cases.nextListingCourtNo','cases.nextListingItemNo','cases.status','case_types.caseType','forums.forum')
            ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
            ->leftjoin('case_types','case_types.abbr','=','cases.caseType')
            ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
            ->where('user_cases.userId',$userId)->where('nextListing','=',date("Y-m-d"))->orderBy('cases.nextListing','desc')->get()->toArray();
            
            foreach($db_data as $k=>$f){
              foreach ($f['data'] as $l=>$c){
                  $key=array_search($c['courtNo'], array_column($cases, 'nextListingCourtNo'));
                  if($key!==false){
                     $case_item = (array)$cases[$key];
                     if($case_item['nextListingItemNo']>$c['currentItemNo']){
                         $db_data[$k]['data'][$l]['userItem']=$case_item['nextListingItemNo'];
                     } else if($case_item['nextListingItemNo']==$c['currentItemNo']){
                         $db_data[$k]['data'][$l]['userItem']='Current Item in Court';
                     } else {
                         $db_data[$k]['data'][$l]['userItem']='Already Listed';
                     }
                      
                  } else {
                      if($type==='mine'){
                          unset($db_data[$k]['data'][$l]);
                      } else {
                          $db_data[$k]['data'][$l]['userItem']='NA';
                      }
                  }
              } 
            }
            
        return response()->json($db_data);
    }
    public function create(Request $request)
    {
         $request->all();
       $author = UserCases::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = UserCases::findOrFail($id);
        if($request->post('pk')){
            $data[$request->post('name')]=$request->post('value');
            $author->update($data);
        } else {
            $author->update($request->all());
        }
        return response()->json($request->all(), 200);
    }
    
    public function delete($id)
    {
        UserCases::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>