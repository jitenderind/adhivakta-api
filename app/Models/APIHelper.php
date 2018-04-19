<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class APIHelper extends Model
{
    //public $timestamps = false;
   // protected $primaryKey = 'taskId';
    protected $table = 'api_helper';
    protected $fillable = array('forumId','helper_type','url','params');
    
    protected $hidden = [];
}

?>