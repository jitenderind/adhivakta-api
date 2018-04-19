<?php
namespace App\Jobs;

class CaseOrders extends Job
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $caseId, $param, $forumId;

    public function __construct($caseId, $param, $forumId)
    {
        //
        $this->caseId = $caseId;
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
        \App\Courts\Courts::addCaseOrders($this->caseId, $this->param, $this->forumId);
    }
}
