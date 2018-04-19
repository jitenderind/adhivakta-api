<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'notificationId';
    protected $table = 'notifications';
    protected $fillable = array('notification','userId','web_sent','app_sent','push_sent','web_notified','app_notified','push_notified');
    
    protected $hidden = [];
}

?>