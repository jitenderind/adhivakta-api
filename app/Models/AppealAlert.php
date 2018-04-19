<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AppealAlert extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'appealAlertId';
    protected $table = 'appeal_alert';
    protected $fillable = array('forumId','userId','court','state','case_no','case_year','date_of_judgement');
    
    protected $hidden = [];
}

?>