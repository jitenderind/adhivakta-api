<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    // public $timestamps = false;
    protected $primaryKey = 'caseId';

    protected $table = 'cases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'forumId',
        'caseType',
        'caseNo',
        'caseYear',
        'diaryNo',
        'diaryDetail',
        'caseNoDetail',
        'caseTitle',
        'status',
        'listing_details',
        'nextListing',
        'nextListingType',
        'nextListingKind',
        'nextListingCourt',
        'nextListingCourtNo',
        'nextListingItemNo',
        'statusDetail',
        'category',
        'act',
        'petitioner',
        'respondent',
        'p_advocate',
        'r_advocate',
        'courtNo'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}

?>