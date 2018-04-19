<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //public $timestamps = false;
    protected $primaryKey = 'invoiceId';
    protected $table = 'invoices';
    protected $fillable = array('userId','invoice_no','invoiceDdate','userCaseId','caseTitle','invoice_amount','invoice_details','paid_status','note','paymentDetails');
    
    protected $hidden = [];
}

?>