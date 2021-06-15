<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instance;

class InstanceController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
	    $items = Instance::get();
		return view('backend.pages.instance.list', compact('items'));
	}
	
	public function delete($id){
	    session()->flash('success', 'Successfully Deleted');
	    Instance::where(['id'=>$id])->delete();
	    return redirect()->route('admin.instance.order');
	}

}
