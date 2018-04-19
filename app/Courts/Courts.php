<?php
namespace App\Courts;

use Illuminate\Database\Eloquent\Model;
use App\Models\APIHelper;
use App\helpers\Helper;
use App\Models\Cases;
use App\Models\SimpleHtmlDOM;
use App\Models\UserForum;
use App\Courts\Courts1;

class Courts extends Model
{

    private static function getHelper($forumId, $type)
    {
        return APIHelper::where('forumId', $forumId)->where('helper_type', $type)->first();
    }
    
    public static function addUserForum($userId,$forumId){
        $data=array();
        $data['userId']=$userId;
        $data['forumId']=$forumId;
        UserForum::firstOrCreate($data);
    }

    public static function addCaseOrders($caseId, $p, $forumId,$add=true,$notify=false)
    {
        $class=__NAMESPACE__."\Courts".$forumId;
        $class::addCaseOrders($caseId, $p,$add,$notify);
    }
    
    public static function getCaseOrdersFromCourt($caseId, $p, $forumId,$add=true,$notify=false)
    {
        $class=__NAMESPACE__."\Courts".$forumId;
        return $class::getCaseOrdersFromCourt($caseId, $p,$add,$notify);
         
    }

    public static function addCaseListing($caseId, $p, $forumId,$caseNo,$caseYear,$notify=false)
    {
        $class=__NAMESPACE__."\Courts".$forumId;
        $class::addCaseListing($caseId, $p, $caseNo,$caseYear,$notify);
    }

    public static function addCaseDoc($caseId, $p, $forumId,$notify=false)
    {
       $class=__NAMESPACE__."\Courts".$forumId;
       $class::addCaseDoc($caseId, $p,$notify);
    }
    
    public static function getCaseDocFromCourt($caseId, $p, $forumId,$notify=false)
    {
        $class=__NAMESPACE__."\Courts".$forumId;
        return $class::getCaseDocFromCourt($caseId, $p,$notify);
    }

    public static function fetchCaseDetailFromCourt($forumId, $p)
    {
        $class=__NAMESPACE__."\Courts".$forumId;
        return $class::fetchCaseDetailFromCourt($p);
    }
    
    /*
    public static function fetchCauselist($forumId,$p,$htmlRaw=null){
        $class=__NAMESPACE__."\Courts".$forumId;
        return $class::fetchCauselist($forumId,$p,$htmlRaw);
    }
    */
    
    public static function getCaseListingFromCauseList($caseNo,$caseYear,$forumId,$date,$courtNo=''){
        $class=__NAMESPACE__."\Courts".$forumId;
        return $class::getCaseListingFromCauseList($caseNo,$caseYear,$date,$courtNo);
        
    }
    
    public static function checkIfCaseUpdated($caseId){
        // get case details 
            $case = Cases::find($caseId);
            if($case){
                $class =__NAMESPACE__."\Courts".$case->forumId;
                $caseDataFromServer=$class::fetchCaseDetailFromCourt(array($case->caseType,$case->caseNo,$case->caseYear));
            if($caseDataFromServer['nextListing']!=$case->nextListing) {
                $updatedArray['listing_details']  = $caseDataFromServer['listing_details']; 
                $updatedArray['nextListing'] = $caseDataFromServer['nextListing'];
                $updatedArray['nextListingKind']=$caseDataFromServer['nextListingKind'];
                $updatedArray['nextListingCourt']=$caseDataFromServer['nextListingCourt'];
                $updatedArray['nextListingCourtNo']=$caseDataFromServer['nextListingCourtNo'];
                $updatedArray['nextListingItemNo']=$caseDataFromServer['nextListingItemNo'];
                $updatedArray['nextListingStatus']=$caseDataFromServer['nextListingStatus'];
                $updatedArray['status']=$caseDataFromServer['status'];
                $updatedArray['statusDetail']=$caseDataFromServer['statusDetail'];
                return $updatedArray;
            } else {
                return false;
            }
            } else {
                return false;
            }
    }
    
    
    public static function getDisplayBoard($forums){
        $displayBoard=array();
        foreach($forums as $f){
            $class=__NAMESPACE__."\Courts".$f['forumId'];
            $displayBoard[]=$class::fetchDisplayBoard();
        }
        return $displayBoard;
    }
    
}

?>
