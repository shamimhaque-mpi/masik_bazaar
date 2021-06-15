<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, App\Models\Supplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$suppliers = Supplier::get();
    	return view('backend.pages.supplier.all', compact('suppliers'));
    }

    public function add(Request $request)
    {
    	if($request->isMethod('POST')){

    		$request->validate([
    			'name'=>'required',
    			'mobile'=>'required|unique:suppliers,mobile',
    		]);

    		$data = $request->except(['_token', 'photo']);
    		if($request->photo){
    			$extension = $request->photo->getClientOriginalExtension();
    			$path = "public/images/supplier/";
    			$name = time().'.'.$extension;
    			$data['img'] = $path.$name;
    			$request->photo->move($path, $name);
    		}
    		$data['initial_balance'] = ($request->type == 'payable' ? (0-$request->initial_balance) : $request->initial_balance);
    		Supplier::create($data);

    		session()->flash('add_message', 'Supplier Successfully Saved');
    		return redirect()->back();
    	}
    	return view('backend.pages.supplier.add');
    }

    public function edit(Request $request, $id)
    {
    	$supplier = Supplier::where('id', $id)->first();
    	if($request->isMethod('POST')){
    		if($supplier->mobile != $request->mobile){
	    		$request->validate([
	    			'mobile'=>'required|unique:suppliers,mobile',
	    		]);
	    	}
    		$data = $request->except(['_token', 'photo']);
    		if($request->photo){
    			if(file_exists($supplier->img)){
    				unlink($supplier->img);
    			}
    			$extension = $request->photo->getClientOriginalExtension();
    			$path = "public/images/supplier/";
    			$name = time().'.'.$extension;
    			$data['img'] = $path.$name;
    			$request->photo->move($path, $name);
    		}
    		$data['initial_balance'] = ($request->type == 'payable' ? (0-$request->initial_balance) : $request->initial_balance);
    		Supplier::where('id', $id)->update($data);
    		session()->flash('update_message', 'Supplier Successfully Updated');
    		return redirect()->back();
    	}

    	return view('backend.pages.supplier.edit', compact('supplier'));
    }

    public function trash($id)
    {
    	/*Supplier::where('id', $id)->update(['trash'=>1]);
    	session()->flash('success', 'Supplier Successfully Deleted');
    	return redirect()->back();*/
    }

    public function delete($id)
    {
    	Supplier::where('id', $id)->update(['trash'=>1]);
    	session()->flash('delete_message', 'Supplier Successfully Deleted');
    	return redirect()->back();
    }


    public function trash_list()
    {
    	$suppliers = Supplier::where('trash', 1)->get();
    	return view('backend.pages.supplier.trash_list', compact('suppliers'));
    }

    public function restore($id)
    {
    	Supplier::where('id', $id)->update(['trash'=>0]);
    	session()->flash('update_message', 'Supplier Successfully Restored');
    	return redirect()->back();
    }
    
}