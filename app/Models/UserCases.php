<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserCases extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'userCaseId';
    protected $table = 'user_cases';
    protected $fillable = array('userId','caseId','fileNo','caseTitle','forumId','courtOf','courtNo','client_name','client_email','client_phone','client_address','opp_counsel_name','opp_counsel_email','opp_counsel_phone','opp_counsel_address','is_archived');
    
    protected $hidden = [];
}

?>