<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserCaseData extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'userCaseDataId';
    protected $table = 'user_case_data';
    protected $fillable = array('userCaseId','title','data_type','data_value');
    
    protected $hidden = [];
}

?>