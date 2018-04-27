<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 
        $this->call('ForumTableSeeder');
        $this->call('APIHelperTableSeeder');
        $this->call('CaseTypeTableSeeder');
    }
}

class ForumTableSeeder extends Seeder
{
    public function run(){
        App\Models\Forum::create(['forum'=>'Supreme Court','abbr'=>'SC','base_url'=>'http://www.supremecourtofindia.nic.in/']);
        App\Models\Forum::create(['forum'=>'Delhi High Court','abbr'=>'DL HC','base_url'=>'http://delhihighcourt.nic.in/']);
        App\Models\Forum::create(['forum'=>'Punjab & Haryana High Court','abbr'=>'P&H HC','base_url'=>'https://phhc.gov.in/']);
    }
}


class APIHelperTableSeeder extends Seeder
{
    public function run(){
        App\Models\APIHelper::create(['forumId'=>'1','helper_type'=>'case_details','url'=>'http://www.supremecourtofindia.nic.in/php/case_status/case_status_process.php','params'=>'ct:case_type;cn:case_number;cy:case_year']);
        App\Models\APIHelper::create(['forumId'=>'1','helper_type'=>'case_listing','url'=>'http://www.supremecourtofindia.nic.in/php/case_status/get_listings.php','params'=>'diaryno:diary no without character of gap']);
        App\Models\APIHelper::create(['forumId'=>'1','helper_type'=>'case_orders','url'=>'http://www.supremecourtofindia.nic.in/php/case_status/get_judgement_order.php','params'=>'diaryno:diary no without character of gap']);
        App\Models\APIHelper::create(['forumId'=>'1','helper_type'=>'case_documents','url'=>'http://www.supremecourtofindia.nic.in/php/case_status/get_office_report.php','params'=>'diaryno:diary no without character of gap']);
        App\Models\APIHelper::create(['forumId'=>'1','helper_type'=>'causelist_fetch','url'=>'http://www.supremecourtofindia.nic.in/php/getCLCNData.php','params'=>'courtno:court no[number or null];msb:type[0=both,1=Main,2=Supplementry];stagecn:stage[F=regular,M=Miscellaneous];from_date_cn:date[d-m-Y]']);
        App\Models\APIHelper::create(['forumId'=>'1','helper_type'=>'display_board','url'=>'http://www.supremecourtofindia.nic.in/php/display/get_board.php','params'=>'']);
    }
}

class CaseTypeTableSeeder extends Seeder
{
    public function run(){
        App\Models\CaseType::create(['caseType'=>'SPECIAL LEAVE PETITION (CIVIL)','abbr'=>'1','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SPECIAL LEAVE PETITION (CRIMINAL)','abbr'=>'2','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'CIVIL APPEAL','abbr'=>'3','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'CRIMINAL APPEAL','abbr'=>'4','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'WRIT PETITION (CIVIL)','abbr'=>'5','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'WRIT PETITION(CRIMINAL)','abbr'=>'6','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'TRANSFER PETITION (CIVIL)','abbr'=>'7','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'TRANSFER PETITION (CRIMINAL)','abbr'=>'8','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'REVIEW PETITION (CIVIL)','abbr'=>'9','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'REVIEW PETITION (CRIMINAL)','abbr'=>'10','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'TRANSFERRED CASE (CIVIL)','abbr'=>'11','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'TRANSFERRED CASE (CRIMINAL)','abbr'=>'12','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SPECIAL LEAVE TO PETITION (CIVIL)','abbr'=>'13','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SPECIAL LEAVE TO PETITION (CRIMINAL)','abbr'=>'14','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'WRIT TO PETITION (CIVIL)','abbr'=>'15','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'WRIT TO PETITION (CRIMINAL)','abbr'=>'16','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'ORIGINAL SUIT','abbr'=>'17','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'DEATH REFERENCE CASE','abbr'=>'18','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'CONTEMPT PETITION (CIVIL)','abbr'=>'19','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'CONTEMPT PETITION (CRIMINAL)','abbr'=>'20','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'TAX REFERENCE CASE','abbr'=>'21','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SPECIAL REFERENCE CASE','abbr'=>'22','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'ELECTION PETITION (CIVIL)','abbr'=>'23','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'ARBITRATION PETITION','abbr'=>'24','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'CURATIVE PETITION(CIVIL)','abbr'=>'25','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'CURATIVE PETITION(CRL)','abbr'=>'26','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'REF. U/A 317(1)','abbr'=>'27','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'MOTION(CRL)','abbr'=>'28','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'DIARY NO.','abbr'=>'29','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'FILE NUMBER','abbr'=>'30','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'DIARY NO AND DIARY YR','abbr'=>'31','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SUO MOTO WRIT PETITION(CIVIL)','abbr'=>'32','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SUO MOTO WRIT PETITION(CRIMINAL)','abbr'=>'33','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SUO MOTO CONTEMPT PETITION(CIVIL)','abbr'=>'34','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SUO MOTO CONTEMPT PETITION(CRIMINAL)','abbr'=>'35','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'REF. U/S 143','abbr'=>'36','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'REF. U/S 14 RTI','abbr'=>'37','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'REF. U/S 17 RTI','abbr'=>'38','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'MISCELLANEOUS APPLICATION','abbr'=>'39','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SUO MOTO TRANSFER PETITION(CIVIL)','abbr'=>'40','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'SUO MOTO TRANSFER PETITION(CRIMINAL)','abbr'=>'41','forumId'=>1]);
        App\Models\CaseType::create(['caseType'=>'Unknown','abbr'=>'9999','forumId'=>1]);
        
    }
}