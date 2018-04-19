<?php
namespace App\Jobs;

class CaseListing extends Job
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $caseId, $param, $forumId, $caseNo, $caseYear;

    public function __construct($caseId, $param, $forumId,$caseNo,$caseYear)
    {
        //
        $this->caseId = $caseId;
        $this->caseNo = $caseNo;
        $this->caseYear=$caseYear;
        $this->param = $param;
        $this->forumId = $forumId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \App\Courts\Courts::addCaseListing($this->caseId, $this->param, $this->forumId,$this->caseNo,$this->caseYear);
    }
}
