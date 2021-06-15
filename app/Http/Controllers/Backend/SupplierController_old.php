<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Supplier;
use Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->except(['_token', 'image']);
            if($request->image){
                $path = "public/images/supplier/";
                $name = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move($path, $name);
                $data['image'] = $path.$name;
            }
            
            Supplier::create($data);
            session()->flash('add_message', 'Supplier Successfully Saved!');
            return redirect()->route('admin.supplier.all');
        }
        return view('backend.pages.supplier.add');
    }
    
    public function all()
    {
        $suppliers = Supplier::where('status', 1)->get();
        return view('backend.pages.supplier.index', compact(['suppliers']));
    }
    
    public function edit(Request $request, $id){
        if($request->isMethod('post')){
            $data = $request->except(['_token', 'image']);
            if($request->image){
                $old_image = Supplier::where('id', $id)->first()->image;
                if(file_exists($old_image)){
                    unlink($old_image);
                }
                $path = "public/images/supplier/";
                $name = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move($path, $name);
                $data['image'] = $path.$name;
            }
            
            Supplier::where('id', $id)->update($data);
            session()->flash('update_message', 'Supplier Successfully Updated!');
            return redirect()->route('admin.supplier.all');
        }
        $supplier = Supplier::where('id', $id)->first();
        return view('backend.pages.supplier.edit', compact(['supplier']));
    }
    
    public function delete($id){
        $old_image = Supplier::where('id', $id)->first()->image;
        if(file_exists($old_image)){
            unlink($old_image);
        }
        Supplier::where('id', $id)->delete();
        session()->flash('delete_message', 'Record Successfully deleted');
        return redirect()->back();
    }
}
