<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, App\Models\Supplier;
use App\Models\Transaction;

class SupplierPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
    	$where = [['trash', '=', 0]];
    	if($request->isMethod('POST')){
    		$where[] = ['date', '>=', $request->from_date];
    		$where[] = ['date', '<=', $request->to_date];
    	}
    	else
    		$where[] = ['date', '=', date('Y-m-d')];


    	$transactions = Transaction::where($where)->with(['supplier'])->get();
    	// dd($transactions->toArray());
    	return view('backend.pages.supplier_payment.index', compact('transactions'));
    }

    public function create(Request $request)
    {
    	if($request->isMethod('POST')){
    		$data = $request->except(['_token']);
    		$data['balance'] = ($request->type=="Receivable" ? $request->balance : (0-$request->balance));
    		Transaction::create($data);
    		session()->flash('add_message', 'Successfully Submited');
    		return redirect()->back();
    	}
    	$suppliers = Supplier::where('trash', 0)->get();
    	return view('backend.pages.supplier_payment.add', compact('suppliers'));
    }

    public function update(Request $request, $id)
    {
    	if($request->isMethod('POST')){
    		$data = $request->except(['_token']);
    		$data['balance'] = ($request->type=="Receivable" ? $request->balance : (0-$request->balance));
    		Transaction::where('id', $id)->update($data);
    		session()->flash('update_message', 'Successfully Updated');
    		return redirect()->back();
    	}
    	
    	$suppliers 		= Supplier::where('trash', 0)->get();
    	$transaction 	= Transaction::where('id', $id)->first();

    	return view('backend.pages.supplier_payment.edit', compact('transaction', 'suppliers'));
    }

    public function delete($id){
    	Transaction::where('id', $id)->delete();
    	session()->flash('delete_message', 'Transaction Successfully Deleted');
    	return redirect()->back();
    }
    
}