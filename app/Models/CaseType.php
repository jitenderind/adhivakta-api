<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'caseTypeId';
    protected $table = 'case_types';
    protected $fillable = array('forum','caseType','abbr');
    
    protected $hidden = [];
}

?>