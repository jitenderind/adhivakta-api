<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cases;
use App\Courts\Courts;
use App\Models\CaseData;
use App\Models\Notification;
use App\Models\UserCases;

class UpdateCaseListing extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "case:cron-update-old-listing";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "update case old listing based on causelist to case record in database";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //get all cases 
    $cases = Cases::where('updateFlag',1)->where('status','pending')->orWhere('status','Pending')->orWhere('status','PENDING')->get();
        foreach ($cases as $c){
             //check for case data change 
            /*
             * check if next date updaed 
             * if changed fetch cause list and get court no and set same 
             * add to notification table 
             */
            //get cuase list 
            $causelist = Courts::getCaseListingFromCauseList($c->caseNo,$c->caseYear,$c->forumId,$c->nextListing);
            //var_dump($causelist);
            if($causelist){
                $data=array();
                //update record 
                $data['nextListingType']=$causelist['listing_type'];
                $data['nextListingKind']='cause list';
                $data['nextListingCourt']=str_replace("<br/>", ", ", $causelist['court']);
                $data['nextListingCourtNo']=$causelist['courtNo'];
                $data['nextListingItemNo']=$causelist['itemNo'];
                //set updateFlag to false 
                $data['updateFlag']=0;
                \DB::table('cases')->where('caseId',$c->caseId)->update($data);
                
                $caseData = CaseData::where('caseId',$c->caseId)->where('data_date',$c->nextListing)->where('data_type','case_listing')->first();
                $caseDataRecord['caseId']=$c->caseId;
                $caseDataRecord['data_date']=$c->nextListing;
                $caseDataRecord['data_type']="case_listing";
                $caseDataRecord['data_value']="listing_type:" . $data['nextListingType'] . ";bench:" . $data['nextListingCourt'] . ";courtNo:" . $data['nextListingCourtNo'] . ";itemNo:" . $data['nextListingItemNo'] . ";stage:" . $causelist['stage'] . ";remarks:NA;action:NA;";
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
                    $notificationData['notification']="Case No. ".$c->caseNo."/".$c->caseYear." has been listed under ".$data['nextListingType']." on ".date("M d, Y",strtotime($c->nextListing))." in the court of ".$data['nextListingCourt']." [court #".$data['nextListingCourtNo']." | Item No: ".$data['nextListingItemNo']."]";
                    Notification::firstOrCreate($notificationData);
                }
            }
                
        }
    }
}

?>