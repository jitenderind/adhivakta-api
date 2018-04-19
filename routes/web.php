<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It is a breeze. Simply tell Lumen the URIs it should respond to
 * | and give it the Closure to call when that URI is requested.
 * |
 */
$router->get('/', function () use($router)
{
    return $router->app->version();
});

// $router->get('fetchDataFromCourt/{forumId}/{caseType}/{caseNo}/{caseYear}', ['middleware'=>['auth','cors'],'uses' => 'CaseController@fetchCaseDataFromCourt']);

$router->group([
    'prefix' => 'v1'
], 
    function () use($router)
    {
        // cases
        $router->post('case/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseController@create'
        ]);
        // $router->get('check-case-update/{$id}', ['middleware'=>['auth','cors'],'uses' => 'CaseController@caseUpdateCheck']);
        $router->get('check-case-update/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseController@caseUpdateCheck'
        ]);
        $router->get('case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseController@caseDetail'
        ]);
        $router->options('case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // forum
        $router->get('forums', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'ForumController@showAllForums'
        ]);
        $router->options('forums', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-forums/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'ForumController@showUserForums'
        ]);
        $router->options('user-forums/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('forums/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'ForumController@showOneForum'
        ]);
        $router->options('forums/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('forums/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'ForumController@showSearchForum'
        ]);
        $router->options('forums/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // $router->post('forums', ['middleware'=>['auth','cors'],'uses' => 'ForumController@create']);
        
        // $router->delete('forums/{id}', ['middleware'=>['auth','cors'],'uses' => 'ForumController@delete']);
        
        // $router->put('forums/{id}', ['middleware'=>['auth','cors'],'uses' => 'ForumController@update']);
        
        // case type
        $router->get('case-types/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseTypeController@forumCaseTypes'
        ]);
        $router->options('case-types/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('case-type/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseTypeController@showOneCaseType'
        ]);
        $router->options('case-type/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('case-type/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseTypeController@showSearchCaseType'
        ]);
        $router->options('case-type/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // $router->post('case-type', ['middleware'=>['auth','cors'],'uses' => 'CaseTypeController@create']);
        
        // $router->delete('case-type/{id}', ['middleware'=>['auth','cors'],'uses' => 'CaseTypeController@delete']);
        
        // $router->put('case-type/{id}', ['middleware'=>['auth','cors'],'uses' => 'CaseTypeController@update']);
        
        // case data
        $router->get('case-data/case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseDataController@showSpecificCaseData'
        ]);
        $router->options('case-data/case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('case-data/case/{id}/{type}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseDataController@showCaseTypeData'
        ]);
        $router->options('case-data/case/{id}/{type}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseDataController@showOneCaseData'
        ]);
        $router->options('case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('case-data/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseDataController@showSearchCaseData'
        ]);
        $router->options('case-data/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // $router->post('case-data', ['middleware'=>['auth','cors'],'uses' => 'CaseDataController@create']);
        
        // $router->delete('case-data/{id}', ['middleware'=>['auth','cors'],'uses' => 'CaseDataController@delete']);
        
        $router->get('test', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'CaseController@test'
        ]);
        
        // user cases
        $router->get('user-cases/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showUserCases'
        ]);
        $router->options('user-cases/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-cause-list/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showUserCauselist'
        ]);
        $router->options('user-cause-list/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-display-board/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showUserDisplayBoard'
        ]);
        $router->options('user-display-board/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-display-board/{id}/{mine}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showUserCauselist'
        ]);
        $router->options('user-display-board/{id}/{mine}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('user-case/{userId}/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showOneUserCase'
        ]);
        $router->options('user-case/{userId}/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('user-archived-cases/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showUserArchivedCases'
        ]);
        $router->options('user-archived-cases/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-archived-cases/{id}/search/{key}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@showSearchUserArchivedCases'
        ]);
        $router->options('user-archived-cases/{id}/search/{key}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->post('user-case/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@create'
        ]);
        
        $router->delete('user-case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@delete'
        ]);
        $router->options('user-case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->put('user-case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@update'
        ]);
        $router->post('user-case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCasesController@update'
        ]);
        $router->options('user-case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // user case data
        $router->get('user-case-data/case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@showUserCaseData'
        ]);
        $router->options('user-case-data/case/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-case-data/case/{id}/type/{type}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@showUserCaseTypeData'
        ]);
        $router->options('user-case-data/case/{id}/type/{type}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('user-case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@showOneUserCaseData'
        ]);
        $router->options('user-case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('user-case-data/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@showSearchUserCaseData'
        ]);
        $router->options('user-case-data/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->post('user-case-data/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@create'
        ]);
        
        $router->delete('user-case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@delete'
        ]);
        $router->options('user-case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->put('user-case-data/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'UserCaseDataController@update'
        ]);
        $router->options('user-cases/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // appeal alert
        $router->get('appeal-alerts/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'AppealAlertController@showUserAppealAlert'
        ]);
        $router->options('appeal-alerts/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('appeal-alert/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'AppealAlertController@showOneAppealAlert'
        ]);
        $router->options('appeal-alert/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('appeal-alert/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'AppealAlertController@showSearchAppealAlert'
        ]);
        $router->options('appeal-alert/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->post('appeal-alert/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'AppealAlertController@create'
        ]);
        
        $router->delete('appeal-alert/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'AppealAlertController@delete'
        ]);
        $router->options('appeal-alert/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->put('appeal-alert/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'AppealAlertController@update'
        ]);
        $router->options('appeal-alert/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // task
        $router->get('tasks/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@showAllUserTask'
        ]);
        $router->options('tasks/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('case-tasks/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@showAllCaseTask'
        ]);
        $router->options('case-tasks/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('task/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@showOneTask'
        ]);
        $router->options('task/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('tasks/{id}/search/{key}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@showSearchTask'
        ]);
        $router->options('tasks/{id}/search/{key}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->post('task/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@create'
        ]);
        
        $router->delete('task/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@delete'
        ]);
        $router->options('task/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->put('task/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'TaskController@update'
        ]);
        $router->options('task/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // staff
        $router->get('allstaff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'StaffController@showAllUserStaff'
        ]);
        $router->options('allstaff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('staff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'StaffController@showOneStaff'
        ]);
        $router->options('staff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('staff/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'StaffController@showSearchStaff'
        ]);
        $router->options('staff/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->post('staff/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'StaffController@create'
        ]);
        
        $router->delete('delete-staff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'StaffController@delete'
        ]);
        $router->options('delete-staff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->put('edit-staff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'StaffController@update'
        ]);
        $router->options('edit-staff/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        // Invoice
        $router->get('invoices/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'InvoiceController@showUserInvoice'
        ]);
        $router->options('invoices/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->get('invoice/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'InvoiceController@showOneInvoice'
        ]);
        $router->options('invoice/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        $router->get('invoice/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'InvoiceController@showSearchInvoice'
        ]);
        $router->options('invoice/search/{key}/{value}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->post('invoice/add', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'InvoiceController@create'
        ]);
        
        $router->delete('invoice/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'InvoiceController@delete'
        ]);
        $router->options('invoice/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
        
        $router->put('invoice/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            'uses' => 'InvoiceController@update'
        ]);
        $router->options('invoice/{id}', [
            'middleware' => [
                'auth',
                'cors'
            ],
            function ()
            {
                return 1;
            }
        ]);
    });