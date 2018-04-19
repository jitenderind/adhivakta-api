<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserForum extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'userForumId';
    protected $table = 'user_forums';
    protected $fillable = array('forumId','userId');
    
    protected $hidden = [];
}

?>