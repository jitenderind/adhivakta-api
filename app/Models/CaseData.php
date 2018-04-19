<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CaseData extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'caseDataId';
    protected $table = 'case_data';
    protected $fillable = array('caseId','data_date','data_type','data_value');
    
    protected $hidden = [];
}

?>