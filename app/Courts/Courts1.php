<?php
namespace App\Courts;

use Illuminate\Database\Eloquent\Model;
use App\Models\APIHelper;
use App\helpers\Helper;
use App\Models\Cases;
use App\Models\SimpleHtmlDOM;
use App\Models\UserForum;
use Illuminate\Broadcasting\PrivateChannel;

class Courts1 extends Model
{

    public static $forumId = "1";
    public static $forum = "Supreme Court";
    public static $abbr ="SC";

    private static function getHelper($type)
    {
        return APIHelper::where('forumId', self::$forumId)->where('helper_type', $type)->first();
    }

    public static function addCaseOrders($caseId, $p, $add = true, $notify = false)
    {
        $helper = self::getHelper('case_orders');
        $params_raw = explode(";", $helper->params);
        $params = array();
        foreach ($params_raw as $pr) {
            $params[] = substr($pr, 0, strpos($pr, ":"));
        }
        foreach ($params as $k => $pm) {
            $vars[$pm] = trim(str_replace(array(
                '/',
                '-',
                ' '
            ), "", $p[$k]));
        }
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $html = curl_exec($ch);
        curl_close($ch);
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $doc->preserveWhiteSpace = false;
        
        $Header = $doc->getElementsByTagName('a');
        $data = array();
        foreach ($Header as $k => $NodeHeader) {
            $data[$k]['date'] = trim($NodeHeader->textContent);
            if ($NodeHeader->getAttribute("href") != "#") {
                $data[$k]['link'] = trim($NodeHeader->getAttribute("href"));
            } else {
                $link = substr($NodeHeader->getAttribute("onclick"), strpos($NodeHeader->getAttribute("onclick"), "(") + 2, strpos($NodeHeader->getAttribute("onclick"), ")"));
                $link = str_replace(array(
                    "../",
                    "');"
                ), '', $link);
                $data[$k]['link'] = trim($link);
            }
        }
        // add to db
        // get base link from Forums table
        $forumData = \DB::table('forums')->where('forumId', self::$forumId)->first();
        foreach ($data as $record) {
            $dbData['caseId'] = $caseId;
            $dbData['data_type'] = 'case_order';
            $dbData['data_date'] = date("Y-m-d", strtotime($record['date']));
            $dbData['data_value'] = (strpos($record['link'], 'http') != false) ? $record['link'] : $forumData->base_url . '/' . $record['link'];
            \App\Models\CaseData::firstOrCreate($dbData);
        }
    }

    public static function getCaseOrdersFromCourt($caseId, $p, $add = true, $notify = false)
    {
        $helper = self::getHelper('case_orders');
        $params_raw = explode(";", $helper->params);
        $params = array();
        foreach ($params_raw as $pr) {
            $params[] = substr($pr, 0, strpos($pr, ":"));
        }
        foreach ($params as $k => $pm) {
            $vars[$pm] = trim(str_replace(array(
                '/',
                '-',
                ' '
            ), "", $p[$k]));
        }
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $html = curl_exec($ch);
        curl_close($ch);
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $doc->preserveWhiteSpace = false;
        
        $Header = $doc->getElementsByTagName('a');
        $data = array();
        $forumData = \DB::table('forums')->where('forumId', self::$forumId)->first();
        foreach ($Header as $k => $NodeHeader) {
            $data[$k]['date'] = trim($NodeHeader->textContent);
            if ($NodeHeader->getAttribute("href") != "#") {
                $data[$k]['link'] = trim($NodeHeader->getAttribute("href"));
            } else {
                $link = substr($NodeHeader->getAttribute("onclick"), strpos($NodeHeader->getAttribute("onclick"), "(") + 2, strpos($NodeHeader->getAttribute("onclick"), ")"));
                $link = str_replace(array(
                    "../",
                    "');"
                ), '', $link);
                $data[$k]['link'] = trim($link);
            }
            $data[$k]['link'] = (strpos($data[$k]['link'], 'http') != false) ? $data[$k]['link'] : $forumData->base_url . '/' . $data[$k]['link'];
        }
        
        return $data;
    }

    public static function addCaseListing($caseId, $p, $caseNo, $caseYear, $notify = false)
    {
        $helper = self::getHelper('case_listing');
        $params_raw = explode(";", $helper->params);
        $params = array();
        foreach ($params_raw as $pr) {
            $params[] = substr($pr, 0, strpos($pr, ":"));
        }
        foreach ($params as $k => $pm) {
            $vars[$pm] = trim(str_replace(array(
                '/',
                '-',
                ' '
            ), "", $p[$k]));
        }
        
       // var_dump($vars);
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $html = curl_exec($ch);
        //var_dump($html);
        curl_close($ch);
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $doc->preserveWhiteSpace = false;
        
        $Detail = $doc->getElementsByTagName('td');
        $i = 0;
        $j = 0;
        foreach ($Detail as $sNodeDetail) {
            $aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
            $i = $i + 1;
            $j = $i % 9 == 0 ? $j + 1 : $j;
        }
        array_shift($aDataTableDetailHTML);
        $data = array();
        foreach ($aDataTableDetailHTML as $k => $row) {
            if (isset($data[$row[0]]) === false) {
                $data[$row[0]]['date'] = $row[0];
                $data[$row[0]]['type'] = $row[1];
                $data[$row[0]]['stage'] = $row[2];
                $data[$row[0]]['bench'] = $row[5];
                $data[$row[0]]['remarks'] = $row[7];
                $data[$row[0]]['action'] = $row[8];
                $data[$row[0]]['courtNo'] = '';
                $data[$row[0]]['itemNo'] = '';
            }
        }
       // var_dump($data);
        //die();
        // add to db
        foreach ($data as $record) {
            $dbData = array();
            if ($record['bench']) {
                if (trim($record['type']) == "Misc.") {
                    $listing_type = "Miscellaneous Matter";
                } else {
                    $listing_type = "Regular Matter";
                }
                $dbData['updateFlag'] = 1;
            } else {
                $listing_type = 'Advance List';
                $dbData['updateFlag'] = 0;
            }
             //var_dump($record);
             
            // get cause list for listing
            //$causelist = self::getCaseListingFromCauseList($caseNo, $caseYear, $record['date']);
            //var_dump($causelist);
            //die();
            $dbData['caseId'] = $caseId;
            $dbData['data_type'] = 'case_listing';
            $dbData['data_date'] = date("Y-m-d", strtotime($record['date']));
            $dbData['data_value'] = "listing_type:" . $listing_type . ";bench:" . $record['bench'] . ";courtNo:" . $record['courtNo'] . ";itemNo:" . $record['itemNo'] . ";stage:" . $record['stage'] . ";remarks:" . $record['remarks'] . ";action:" . $record['action'];
            $dbData['updateFlag']=1;
            
            \App\Models\CaseData::firstOrCreate($dbData);
        }
    }

    public static function addCaseDoc($caseId, $p, $notify = false)
    {
        $helper = self::getHelper('case_documents');
        $params_raw = explode(";", $helper->params);
        $params = array();
        foreach ($params_raw as $pr) {
            $params[] = substr($pr, 0, strpos($pr, ":"));
        }
        foreach ($params as $k => $pm) {
            $vars[$pm] = trim(str_replace(array(
                '/',
                '-',
                ' '
            ), "", $p[$k]));
        }
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $html = curl_exec($ch);
        curl_close($ch);
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $doc->preserveWhiteSpace = false;
        
        $Header = $doc->getElementsByTagName('a');
        $data = array();
        foreach ($Header as $k => $NodeHeader) {
            $data[$k]['date'] = trim($NodeHeader->textContent);
            if ($NodeHeader->getAttribute("href") != "#") {
                $data[$k]['link'] = trim($NodeHeader->getAttribute("href"));
            } else {
                $link = Helper::subString($NodeHeader->getAttribute("onclick"), "(", ")");
                if ($link) {
                    $link = str_replace(array(
                        "../",
                        "');"
                    ), '', $link);
                }
                $data[$k]['link'] = trim($link);
            }
        }
        
        // add to db
        // get base link from Forums table
        $forumData = \DB::table('forums')->where('forumId', self::$forumId)->first();
        foreach ($data as $record) {
            $dbData['caseId'] = $caseId;
            $dbData['data_type'] = 'case_office_report';
            $dbData['data_date'] = date("Y-m-d", strtotime($record['date']));
            $dbData['data_value'] = (strpos($record['link'], 'hhtp') != false) ? $record['link'] : $forumData->base_url . '/' . $record['link'];
            \App\Models\CaseData::firstOrCreate($dbData);
        }
        
    }

    public static function getCaseDocFromCourt($caseId, $p, $notify = false)
    {
        $helper = self::getHelper('case_documents');
        $params_raw = explode(";", $helper->params);
        $params = array();
        foreach ($params_raw as $pr) {
            $params[] = substr($pr, 0, strpos($pr, ":"));
        }
        foreach ($params as $k => $pm) {
            $vars[$pm] = trim(str_replace(array(
                '/',
                '-',
                ' '
            ), "", $p[$k]));
        }
        
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $html = curl_exec($ch);
        curl_close($ch);
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $doc->preserveWhiteSpace = false;
        
        $Header = $doc->getElementsByTagName('a');
        $forumData = \DB::table('forums')->where('forumId', self::$forumId)->first();
        foreach ($Header as $k => $NodeHeader) {
            $data = array();
            $data[$k]['date'] = trim($NodeHeader->textContent);
            if ($NodeHeader->getAttribute("href") != "#") {
                $data[$k]['link'] = trim($NodeHeader->getAttribute("href"));
            } else {
                $link = Helper::subString($NodeHeader->getAttribute("onclick"), "(", ")");
                if ($link) {
                    $link = str_replace(array(
                        "../",
                        "');"
                    ), '', $link);
                }
                $data[$k]['link'] = trim($link);
            }
            $data[$k]['link'] = (strpos($data[$k]['link'], 'http') != false) ? $data[$k]['link'] : $forumData->base_url . '/' . $data[$k]['link'];
        }
        
        return $data;
    }

    public static function fetchCaseDetailFromCourt($p)
    {
        // get data helper
        $helper = self::getHelper('case_details');
        $params_raw = explode(";", $helper->params);
        $params = array();
        foreach ($params_raw as $pr) {
            $params[] = substr($pr, 0, strpos($pr, ":"));
        }
        foreach ($params as $k => $pm) {
            $vars[$pm] = $p[$k];
        }
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $html = curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
        // libxml_use_internal_errors( true);
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $doc->preserveWhiteSpace = false;
        
        $Header = $doc->getElementsByTagName('h5');
        $aDataTableHeaderHTML = array();
        foreach ($Header as $NodeHeader) {
            $aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
        }
        $tableData['diaryNo'] = str_replace("Diary No.- ", "", $aDataTableHeaderHTML[0]);
        $tableData['caseTitle'] = $aDataTableHeaderHTML[1];
        $rawTableData = $doc->getElementsByTagName('td');
        foreach ($rawTableData as $k => $Node) {
            if ($k % 2 == 0) {
                $key = trim($Node->textContent);
            } else {
                $tableData[$key] = trim($Node->textContent);
            }
        }
        return self::buildServerResult($tableData);
    }

    private static function buildServerResult($tableData)
    {
        $data = array();
        // fetch date from raw data
        if (isset($tableData['Tentatively case may be listed on (likely to be listed on)'])) {
            $t_Date = substr($tableData['Tentatively case may be listed on (likely to be listed on)'], 0, strpos($tableData['Tentatively case may be listed on (likely to be listed on)'], ' '));
            $t_kind = substr($tableData['Tentatively case may be listed on (likely to be listed on)'], strpos($tableData['Tentatively case may be listed on (likely to be listed on)'], ' '));
            $nextListingArray['date'] = $t_Date;
            $nextListingArray['kind'] = $t_kind;
            $data['nextListing'] = date("Y-m-d", strtotime($nextListingArray['date']));
            $data['nextListingKind'] = $nextListingArray['kind'];
        } else {
            $data['nextListing'] = '';
            $data['nextListingKind'] = '';
        }
        
        $data['diaryNo'] = trim($tableData['diaryNo']);
        $data['diaryDetail'] = trim(str_replace('PMPENDING', 'PM', $tableData['Diary No.']));
        $data['caseNoDetail'] = trim($tableData['Case No.']);
        $data['caseTitle'] = trim($tableData['caseTitle']);
        $data['status'] = trim(substr($tableData['Status/Stage'], 0, strpos($tableData['Status/Stage'], ' ')));
        $data['statusDetail'] = trim($tableData['Status/Stage']);
        $data['category'] = trim($tableData['Category']);
        $data['act'] = trim($tableData['Act']);
        $data['petitioner'] = trim($tableData['Petitioner(s)']);
        $data['respondent'] = trim($tableData['Respondent(s)']);
        $data['p_advocate'] = trim($tableData['Pet. Advocate(s)']);
        $data['r_advocate'] = trim($tableData['Resp. Advocate(s)']);
        $data['listing_details'] = $tableData['Present/Last Listed On'];
        
        $data['nextListingType'] = '';
        if (strpos($tableData['Present/Last Listed On'], "HON'BLE") != false || strpos($tableData['Present/Last Listed On'], "REGISTRAR") != false) {
            $nextListingArray['court'] = Helper::subString($tableData['Present/Last Listed On'], '[', ']');
            $nextListingArray['itemNo'] = Helper::subString($tableData['Present/Last Listed On'], ':', ']');
            $data['nextListingCourt'] = ($nextListingArray['court']) ? $nextListingArray['court'] : "";
            $data['nextListingCourtNo'] = '';
            $data['nextListingStatus'] = 'Tentitive';
            $data['nextListingItemNo'] = ($nextListingArray['itemNo']) ? $nextListingArray['itemNo'] : "";
        } else {
            $nextListingArray['court'] = 'NA';
            $nextListingArray['itemNo'] = 'NA';
            $data['nextListingCourt'] = 'NA';
            $data['nextListingCourtNo'] = '';
            $data['nextListingStatus'] = 'NA';
            $data['nextListingItemNo'] = "NA";
        }
        
        return $data;
    }

    public static function fetchCauselist($p, $htmlRaw = null)
    {
        // get data helper
        if ($htmlRaw === null) {
            $helper = self::getHelper('causelist_fetch');
            $params_raw = explode(";", $helper->params);
            $params = array();
            foreach ($params_raw as $pr) {
                $params[] = substr($pr, 0, strpos($pr, ":"));
            }
            foreach ($params as $k => $pm) {
                $vars[$pm] = $p[$k];
            }
            // var_dump($vars);
            $ch = curl_init();
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $helper->url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            
            // grab URL and pass it to the browser
            $htmlRaw = curl_exec($ch);
            
            // close cURL resource, and free up system resources
            curl_close($ch);
        }
        $html = new SimpleHtmlDOM();
        $html->load($htmlRaw);
        
        $baseDiv = $html->find("[id^=prnntcn]");
        $dataArray = array();
        foreach ($baseDiv as $k => $d) {
            // find table header
            foreach ($d->find('table th') as $th) {
                // court NO
                if (strpos($th->innertext, "CHIEF JUSTICE'S COURT") !== false) {
                    $ha['courtNo'] = 1;
                } else 
                    if (strpos($th->innertext, "COURT NO. :") !== false) {
                        $ha['courtNo'] = trim(substr($th->innertext, strpos($th->innertext, ":") + 1, 2));
                    }
                
                // get court
                if (strpos($th->innertext, "HON'BLE") === 0) {
                    $ha['court'] = $th->innertext;
                }
            }
            // asign header
            $dataArray[$k]['header'] = $ha;
            // get data
            foreach ($d->find('table tr') as $i => $dt) {
                if ($dt->find('td')) {
                    foreach ($dt->find('td') as $s => $td) {
                        if ($td->getAttribute('colspan') == 4) {
                            $stage_type = $td->plaintext;
                        }
                        
                        if ($td->getAttribute('style') === false && $td->parent()->children(0)->plaintext != '' && $td->parent()->children(0)->plaintext != 'Versus') {
                            $data[$i]['itemNo'] = $td->parent()->children(0)->plaintext;
                            $data[$i]['case'] = $td->parent()->children(1)->plaintext;
                            $data[$i]['stage'] = $stage_type;
                            // var_dump($td->parent()->children(0)->plaintext);
                        }
                    }
                }
            }
            $dataArray[$k]['data'] = $data;
        }
        return $dataArray;
    }

    public static function getCaseListingFromCauseList($caseNo, $caseYear, $date, $courtNo = '')
    {
        $causeList = self::fetchCauselist(array(
            $courtNo,
            '1',
            'M',
            date('d-m-Y', strtotime($date))
        ));
        if ($causeList) {
            $result = self::caseDetailsFromCauseList($caseNo, $caseYear, $causeList);
            if ($result) {
                // return result
                $result['listing_type'] = 'Miscellaneous Matter';
                $result['listing_type_full'] = 'Miscellaneous/main';
                return $result;
            } else {
                // else move to next list
                $causeList = self::fetchCauselist(array(
                    $courtNo,
                    '2',
                    'M',
                    date('d-m-Y', strtotime($date))
                ));
                if ($causeList) {
                    $result = self::caseDetailsFromCauseList($caseNo, $caseYear, $causeList);
                    if ($result) {
                        $result['listing_type'] = 'Miscellaneous Matter';
                        $result['listing_type_full'] = 'Miscellaneous/Supplementry';
                        return $result;
                    } else {
                        // /if more cause list
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    private static function caseDetailsFromCauseList($caseNo, $caseYear, $stack)
    {
        $results = array();
        // var_dump($stack);
        foreach ($stack as $k => $item) {
            foreach ($item['data'] as $l => $r) {
                // var_dump($r);
                if ((strpos($r['case'], $caseNo . "/" . $caseYear) !== false) || ((strpos($r['case'], $caseNo . "-") !== false && (strpos($r['case'], $caseYear) !== false)))) {
                    // build array
                    $results['courtNo'] = $item['header']['courtNo'];
                    $results['itemNo'] = $r['itemNo'];
                    $results['court'] = $item['header']['court'];
                    $results['caseNo'] = $r['case'];
                    $results['stage'] = $r['stage'];
                    return $results;
                }
            }
        }
        
        return $results;
    }

    public static function fetchDisplayBoard()
    {
        $helper = self::getHelper('display_board');
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $helper->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        // grab URL and pass it to the browser
        $htmlRaw = curl_exec($ch);
        $html = new SimpleHtmlDOM();
        $html->load($htmlRaw);
        $baseElement = $html->find("td");
        $result_array=array('forum'=>self::$forum,'abbr'=>self::$abbr);
        $court = 0;
        foreach ($baseElement as $k=>$el){
        
            if($k%7===0){
                $result_array['data'][$court]['courtNo']=$el->plaintext;
            }
            if($k%7===3){
                $result_array['data'][$court]['currentItemNo']=$el->plaintext;
            }
            if($k%7===6){
                $court++;
            }
        }
        return $result_array;
    }
}

?>