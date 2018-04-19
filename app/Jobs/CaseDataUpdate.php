<?php

namespace App\Jobs;
use App\Models\Cases;
use App\Models\UserCases;

class CaseDataUpdate extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $caseId, $param, $forumId, $userCaseId;
    public function __construct($caseId,$param,$forumId,$userCaseId)
    {
        //
        $this->caseId=$caseId;
        $this->param=$param;
        $this->forumId=$forumId;
        $this->userCaseId=$userCaseId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data=\App\Courts\Courts::fetchCaseDetailFromCourt($this->forumId,$this->param);
        $case = Cases::find($this->caseId);
        $case->update($data);
        
        //update user case 
        $userdata['caseTitle']=$data['caseTitle'];
        $user_case = UserCases::find($this->userCaseId);
        $user_case->update($userdata);
    }
}
