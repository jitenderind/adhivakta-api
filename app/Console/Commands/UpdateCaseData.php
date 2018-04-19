<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cases;
use App\Courts\Courts;
use App\Models\CaseData;
use App\Models\Notification;
use App\Models\UserCases;

class UpdateCaseData extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "case:cron-update-data";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "update case data to case record in database";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //get all cases 
    $cases = Cases::where('status','pending')->orWhere('status','Pending')->orWhere('status','PENDING')->get();
        foreach ($cases as $c){
             //check for case data change 
            /*
             * check if next date updaed 
             * if changed fetch cause list and get court no and set same 
             * add to notification table 
             */
           // echo 'case ID - '. $c->caseId;
           $data=Courts::checkIfCaseUpdated($c->caseId);
            if($data){
                //feteh details from causelist
                //check if case is disposed off
                if(strtoupper($data['status'])!="DISPOSED"){
                    //only update case data and case listinf
                    $causelist = Courts::getCaseListingFromCauseList($c->caseNo,$c->caseYear,$c->forumId,$data['nextListing']);
                    if($causelist){
                        $data['nextListingCourtNo']=$causelist['courtNo'];
                        $data['nextListingItemNo']=$causelist['itemNo'];
                        $data['nextListingCourt']=$causelist['court'];
                        $data['nextListingType']=$causelist['listing_type'];
                        $data['nextListingKind']='cause list';
                        $data['updateFlag']=0;
                        $listing_type=$causelist['listing_type'];
                        $stage=$causelist['stage'];
                    } else {
                        $data['updateFlag']=1;
                        $data['nextListingKind']=$listing_type='Tentitive';
                        $stage='';
                    }
                } 
                //update cases table 
                \DB::table('cases')->where('caseId',$c->caseId)->update($data);
                
                // update listing in case data table
                //find if listing exists
                $caseData = CaseData::where('caseId',$c->caseId)->where('data_date',$data['nextListing'])->where('data_type','case_listing')->first();
                $caseDataRecord['caseId']=$c->caseId;
                $caseDataRecord['data_date']=$data['nextListing'];
                $caseDataRecord['data_type']="case_listing";
                $caseDataRecord['data_value']="listing_type:" . $listing_type . ";bench:" . $data['nextListingCourt'] . ";courtNo:" . $data['nextListingCourtNo'] . ";itemNo:" . $data['nextListingItemNo'] . ";stage:" . $stage . ";remarks:NA;action:NA;";
                $caseDataRecord['updateFlag']=$data['updateFlag'];
                if($caseData){
                    $caseData->update($caseDataRecord);
                } else {
                    //add listing 
                    CaseData::create($caseDataRecord);
                }
                
                //add record to notification table
                //get user id 
                $userCase = UserCases::select('userId','userCaseId')->where('caseId',$c->caseId)->get(); 
                foreach ($userCase as $ud){
                    $notificationData['userId'] =$ud->userId;
                    $notificationData['notificationDate']=date('Y-m-d H:i:s');
                    $notificationData['notification']="Case No. ".$c->caseNo."/".$c->caseYear." has been listed under ".$listing_type." on ".date("M d, Y",strtotime($data['nextListing']))." in the court of ".$data['nextListingCourt']." [court #".$data['nextListingCourtNo']." | Item No: ".$data['nextListingItemNo']."]";
                    Notification::firstOrCreate($notificationData);
                }
                
           }
            
           
            
            /*
             * check if new order or office report added 
             * if yes, fetch and add to database
             * add to notification table  
             */
           
           $orders=Courts::getCaseOrdersFromCourt($c->caseId, array($c->diaryNo), $c->forumId);
           if($orders){
               foreach ($orders as $record){
                   $caseData = CaseData::where('caseId',$c->caseId)->where('data_date',date("Y-m-d",strtotime($record['date'])))->where('data_type','case_order')->first();
                   $dbData['caseId'] = $c->caseId;
                   $dbData['data_type'] = 'case_order';
                   $dbData['data_date'] = date("Y-m-d",strtotime($record['date']));
                   $dbData['data_value'] = $record['link'];
                   if($caseData){
                       $caseData->update($dbData);
                   } else {
                       CaseData::create($dbData);
                   }
               }
           }
           
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
        }
    }
}

?>