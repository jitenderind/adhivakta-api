<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'taskId';
    protected $table = 'tasks';
    protected $fillable = array('task','userId','userCaseId','due_date','parentUserId','assignedTo','is_completed');
    
    protected $hidden = [];
}

?>