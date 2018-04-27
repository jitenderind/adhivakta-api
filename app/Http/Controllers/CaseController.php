<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Log;
use Illuminate\Support\Facades\DB;
use App\Models\Cases;
use App\Models\CaseData;
use App\Models\UserForum;
use App\Courts\Courts;
use Illuminate\Support\Facades\Queue;
use \App\Jobs\CaseDoc;
use \App\Jobs\CaseListing;
use \App\Jobs\CaseOrders;
use \App\Jobs\UserForums;
use App\Models\UserCases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\SimpleHtmlDOM;
use App\helpers\Helper;

class CaseController extends Controller
{

    public function showAllCases()
    {
        return response()->json(Cases::all());
    }

    public function showAllUserCases($id)
    {
        $r = Cases::all();
        if ($r) {
            return response()->json($r);
        } else {
            return response("No case found");
        }
    }

    public function showOneCase($id)
    {
        return response()->json(Cases::find($id));
    }

    public function create(Request $request)
    {
        // add record to case table
        $case_data = array(
            'forumId' => $request->forumId,
            'caseType' => $request->caseType,
            'caseNo' => $request->caseNo,
            'caseYear' => $request->caseYear
        );
        $case_insert = Cases::firstOrCreate($case_data);
        
        $data=\App\Courts\Courts::fetchCaseDetailFromCourt($request->forumId,array($request->caseType,$request->caseNo,$request->caseYear));
        $case = Cases::find($case_insert->caseId);
        $case->update($data);
        // add record to user case table
        // set file number
        $fileNo = ($request->fileNo) ? $request->fileNo : $request->caseNo . '/' . $request->caseYear;
        $user_case_data = array(
            'userId' => $request->userId,
            'caseId' => $case_insert->caseId,
            'caseTitle'=>$data['caseTitle'],
            'fileNo' => $fileNo,
            'forumId' => $request->forumId,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_address' => $request->client_address,
            'opp_counsel_email' => $request->opp_counsel_email,
            'opp_counsel_phone' => $request->opp_counsel_phone,
            'opp_counsel_address' => $request->opp_counsel_address,
            'opp_counsel_name' => $request->opp_counsel_name
        );
         $insert=UserCases::firstOrCreate($user_case_data);
         
        //start adding listing, orders and office document to case
        //add case orders
        Queue::push(new CaseOrders($case_insert->caseId,array($data['diaryNo']),$request->forumId));
        
        //add case office documents
        Queue::push(new CaseDoc($case_insert->caseId,array($data['diaryNo']),$request->forumId));
        
        Queue::push(new UserForums($request->userId,$request->forumId));
        
        //add case listings
        Queue::push(new CaseListing($case_insert->caseId,array($data['diaryNo']),$request->forumId,$request->caseNo,$request->caseYear));
        
        //run command 
        $case = \DB::table('user_cases')->leftjoin('cases','cases.caseId','=','user_cases.caseId')->where('user_cases.caseId',$case_insert->caseId)->first();
        return response()->json($case, 200);
    }
    public function caseDetail($id){
        $case=\DB::table('user_cases')
        ->select('user_cases.*','cases.*','case_types.caseType','forums.forum')
        ->leftjoin('cases','user_cases.caseId','=','cases.caseId')
        ->leftjoin('case_types','case_types.caseType','=','cases.caseType')
        ->leftjoin('forums','forums.forumId','=','user_cases.forumId')
        ->where('user_cases.userCaseId',$id)->get();
        return response()->json($case);
    }
    
    public function update($id, Request $request)
    {
        $author = Cases::findOrFail($id);
        $author->update($request->all());
        
        return response()->json($author, 200);
    }

    public function delete($id)
    {
        Cases::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
    
    public function setCaseDataFromCourt($id,$forumId,$caseType,$caseNo,$caseYear){
        $data=$this->fetchCaseDataFromCourt($forumId,$caseType,$caseNo,$caseYear);
        $author = Cases::findOrFail($id);
        $author->update($data);
    }
    
    public function setCaseData($id,$data){
        $author = Cases::findOrFail($id);
        $author->update($data);
    }
    
    public function caseUpdateCheck($id){
     $cases = Cases::all();
        foreach ($cases as $c){
            echo '<pre>';
            echo 'case id - '.$c->caseId;
        $docs=Courts::getCaseDocFromCourt($c->caseId, array($c->diaryNo), $c->forumId);
           if($docs){
               foreach ($docs as $record){
                   $caseData = CaseData::where('caseId',$c->caseId)->where('data_date',date("Y-m-d",strtotime($record['date'])))->where('data_type','case_office_report')->first();
                   $dbData['caseId'] = $c->caseId;
                   $dbData['data_type'] = 'case_office_report';
                   $dbData['data_date'] = date("Y-m-d",strtotime($record['date']));
                   $dbData['data_value'] = $record['link'];
                   if($caseData){
                       $caseData->update($dbData);
                   } else {
                       CaseData::create($dbData);
                   }
               }
           }
            
           \DB::enableQueryLog();
           $query    = \DB::getQueryLog();
            
           print_r($query);
        }
        
    }
    
    public function test(){
        
        $data=\App\Courts\Courts::getDisplayBoard(array(array('forumId'=>1)));
        var_dump($data);
        die();
        $userId=1;
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
         echo '<pre>';
         /*
         $user_cases = array_map(function ($value) {
             return (array)$value;
         }, $user_cases);
         */
            //var_dump($cases);
            
            foreach($db_data as $k=>$f){
              foreach ($f['data'] as $l=>$c){
                  $key=array_search($c['courtNo'], array_column($cases, 'nextListingCourtNo'));
                  if($key!==false){
                     $case_item = (array)$cases[$key];
                      $db_data[$k]['data'][$l]['userItem']=$case_item['nextListingItemNo'];
                  } else {
                      $db_data[$k]['data'][$l]['userItem']='NA';
                  }
              } 
            }
            var_dump($db_data);
        //Courts::addCaseListing(1,array('166 - 2018'),1,'486','2018');
        //Courts::addCaseDoc(1,array('166 - 2018'),1);
    }
    
}

?>