<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function showUserInvoice($id)
    {
        $r=Invoice::where('userId',$id)->get();
        return response()->json($r);
    }
    
    public function showOneInvoice($id)
    {
        return response()->json(Invoice::find($id));
    }
    
    public function showSearchInvoice($key,$value){
        if($key && $value){
        $result = Invoice::where($key,'like','%'.$value.'%')->get();
        return response()->json($result);
        } else {
            return response('Bad Request',201);
        }
    }
    
    public function create(Request $request)
    {
         $request->all();
       $author = Invoice::create($request->all());
    
        return response()->json($author, 201);
    }
    
    public function update($id, Request $request)
    {
        $author = Invoice::findOrFail($id);
        $author->update($request->all());
    
        return response()->json($author, 200);
    }
    
    public function delete($id)
    {
        Invoice::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

?>