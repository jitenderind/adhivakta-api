<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'staffId';
    protected $table = 'staff';
    protected $fillable = array('first_name','parentUserId','last_name','user_type');
    
    protected $hidden = [];
}

?>