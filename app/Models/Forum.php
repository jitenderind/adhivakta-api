<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'forumId';
    protected $fillable = array('forum','abbr');
    
    protected $hidden = [];
}

?>