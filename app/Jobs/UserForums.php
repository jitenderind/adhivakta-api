<?php

namespace App\Jobs;

class UserForums extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $userId, $forumId;
    public function __construct($userId,$forumId)
    {
        //
        $this->userId=$userId;
        $this->forumId=$forumId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \App\Courts\Courts::addUserForum($this->userId,$this->forumId);
    }
}
