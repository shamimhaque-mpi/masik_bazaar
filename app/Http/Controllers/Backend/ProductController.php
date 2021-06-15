<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Helpers\NumberHelper;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->initalItems = 50;
        $this->middleware('auth:admin');
    }
    /**
     * return all products
     */
    public function index(Request $request)
    {
        $condi = [];
        if($request->isMethod('post')){
            if($request->status != ""){
                $condi['status'] = $request->status;
            }
            if($request->category_id != ""){
                $condi['category_id'] = $request->category_id;
            }
            if($request->product_title != ""){
                $condi[] = ['title' ,'like', $request->product_title];
            }
        }
        if (request()->filled('items')) {

            $items = request()->items;
        }else{

            $items = $this->initalItems;
        }

        if(Auth::guard('admin')->user()->is_merchant){
            $products = Product::orderBy('id', 'desc')
            // ->where('status', 1)
            ->where('status', '!=', 9)
            ->where('admin_id', Auth::guard('admin')->user()->id)
            // ->get();
            ->paginate($items);
            
        }
        else{
            $products = Product::orderBy('status','desc')
            ->orderBy('id','desc')
            ->where($condi)
            ->where('status', '!=', 9)
            ->paginate($items);

        }

        $total = $products->total();
        $productTitles = Product::select('title')->where([['status', '!=', 9]])->get()->toArray();
        $categories = Category::get();

        return view('backend.pages.product.index', compact('products', 'items', 'total', 'productTitles', 'categories'));
    }


    /**
     * return single product object
     */
    public function view($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return view('errors.404');
        }
        return view('backend.pages.product.view', compact('product'));
    }


    /**
     * return to product add view with all dependencies related to product
     */
    public function create()
    {
        $sizes = QueryHelper::complexRead('Size');
        $colors = QueryHelper::complexRead('Color');
        $units = QueryHelper::complexRead('Unit', [], 1, 'id', 'ASC');

        if(Auth::guard('admin')->user()->is_merchant){
            $categories = Category::where('status', 1)/*->where('admin_id', Auth::guard('admin')->user()->id)*/->get();
            $subcategories = SubCategory::where('status', 1)/*->where('admin_id', Auth::guard('admin')->user()->id)*/->get();
            $brands = Brand::where('status', 1)/*->where('admin_id', Auth::guard('admin')->user()->id)*/->get();
        }
        else{
            $categories = QueryHelper::complexRead('Category');
            $subcategories = QueryHelper::complexRead('SubCategory');
            $brands = QueryHelper::complexRead('Brand');
        }
        
        $suppliers = Supplier::where('status', 1)->get();
        
        return view('backend.pages.product.create', compact('categories', 'subcategories', 'brands', 'sizes', 'colors', 'units', 'suppliers'));
    }


    /**
     * save product into database
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'feature_photo' => 'required',
            'purchase_price' => 'required',
            'regular_price' => 'required',
            'description' => 'required',
            'quantity' => 'required'
        ]);
        
        // upload image as json array
        $product_image = [];
        $original_image = [];
        $i = 0;
        $name = time();
        if($request->image){
            foreach($request->image as $key => $value){
                if($value){
                    $name = time().$i;
                    // uploading image
                    $image = ImageUploadHelper::uploadWithResize('image', $request->file('image')[$i], $name, 'public/images/products', 400);
        
                    $original_image_name = ImageUploadHelper::uploadWithOriginalSize('image', $request->file('image')[$i], $name, 'public/images/products/original', 600);
        
                    $product_image[] = 'public/images/products/'.$image; // push to image array 
                    $original_image[] = 'public/images/products/original/'.$original_image_name; // push to image array 
                    $i++;
                }
            }
        }

        $product_image  = json_encode($product_image); // encoding all images
        $original_image = json_encode($original_image); // encoding all original_images

        $data = $request->except(['_token', 'image', 'size_id', 'color_id', 'save_menu']); // this fields are not received
        
        $data['product_area']       = 'others';
        $data['is_feature_product'] = 0;

        $code = rand(0000, 9999);
        while(Product::where('code', $code)->first()){
            $code = rand(0000, 9999);
        }
        $data['code'] = $code;

        if($request->size_id){
            $data['size_id'] = json_encode($request->size_id);
        }

        if($request->color_id){
            $data['color_id'] = json_encode($request->color_id);
        }

        //if(Auth::guard('admin')->user()->is_merchant){
            $data['admin_id'] = Auth::guard('admin')->user()->id;
        //}
        if(Auth::guard('admin')->user()->admin_role == 2){
            $data['status'] = 0;
        }


        $data['image'] = $product_image;
        $data['original_image'] = $original_image;
        $data['feature_photo']  = 'public/images/products/feature_photo/'.ImageUploadHelper::uploadWithResize('feature_photo', $request->file('feature_photo'), $name, 'public/images/products/feature_photo', 600);
        
        
        $data['discount'] = NumberHelper::simpleMod(NumberHelper::simpleDryString($request->discount), 100);

        $data['slug'] = StringHelper::createSlug($request->title, 'Product', 'slug'); // create slug (url)

        QueryHelper::simpleInsert('Product', $data); // insert into table

        session()->flash('add_message', 'Added');
        return redirect()->route('admin.product.index');
    }


    public function edit($slug)
    {
        $product = QueryHelper::getDbSingleResults('products', array('slug' => $slug));
        if($product){
            $sizes = QueryHelper::complexRead('Size');
            $colors = QueryHelper::complexRead('Color');
            $units = QueryHelper::complexRead('Unit');
            if(Auth::guard('admin')->user()->is_merchant){
                $categories = Category::where('status', 1)->where('admin_id', Auth::guard('admin')->user()->id)->get();
                $subcategories = SubCategory::where('status', 1)->where('admin_id', Auth::guard('admin')->user()->id)->get();
                $brands = Brand::where('status', 1)->where('admin_id', Auth::guard('admin')->user()->id)->get();
            }
            else{
                $categories = QueryHelper::complexRead('Category');
                $subcategories = QueryHelper::complexRead('SubCategory');
                $brands = QueryHelper::complexRead('Brand');
            }
            
            $suppliers = Supplier::where('status', 1)->get();
            
            return view('backend.pages.product.edit', compact('categories', 'subcategories', 'brands', 'sizes', 'colors', 'units', 'product', 'suppliers'));
        }
        else{
            return back();
        }
    }


    public function update(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        $this->validate($request, [
            'title' => 'required',
            'purchase_price' => 'required',
            'regular_price' => 'required',
            'description' => 'required',
            'quantity' => 'required'
        ]);

        // upload image as json array
        if($request->image){
            $product_image = [];
            $original_image = [];
            $i = 0;
            foreach($request->image as $key => $value){
                if($value){
                    $name = time().$i;
                    // uploading image
                    $image = ImageUploadHelper::uploadWithResize('image', $request->file('image')[$i], $name, 'public/images/products', 400, 534);
    
                    $original_image_name = ImageUploadHelper::uploadWithOriginalSize('image', $request->file('image')[$i], $name, 'public/images/products/original', 600, 800);
    
                    $product_image[] = 'public/images/products/'.$image; 
                    $original_image[] = 'public/images/products/original/'.$original_image_name;
                    $i++;
                }
            }

            if($product->image){
                $old_images = $product->image;
                $old_original_images = $product->original_image;
                foreach($old_images as $key => $value){
                    $product_image[] = $value;
                    $original_image[] = $old_original_images[$key];
                }
            }

            $product_image  = json_encode($product_image); // encoding all images
            $original_image = json_encode($original_image); // encoding all images
        }
        else{
            $product_image  = json_encode($product->image);
            $original_image = json_encode($product->original_image);
        }

        $data = $request->except(['_token', 'image', 'size', 'color']); 

        if($request->feature_photo){
            if(file_exists($product->feature_photo))
                unlink($product->feature_photo);
            $data['feature_photo'] = 'public/images/products/feature_photo/'.ImageUploadHelper::uploadWithResize('feature_photo', $request->file('feature_photo'), time(), 'public/images/products/feature_photo', 600);
        }

        $data['product_area']       = 'others';
        $data['is_feature_product'] = 0;

        if($request->size_id){
           $data['size_id'] = json_encode($request->size_id);
       }

       if($request->color_id){
           $data['color_id'] = json_encode($request->color_id);
       }

       if(Auth::guard('admin')->user()->is_merchant){
        $data['admin_id'] = Auth::guard('admin')->user()->id;
    }

    $data['image'] = $product_image;
    $data['original_image'] = $original_image;
    $data['discount'] = NumberHelper::simpleMod(NumberHelper::simpleDryString($request->discount), 100);
        $data['slug'] = StringHelper::createSlug($request->title, 'Product', 'slug'); // create slug (url)

        $product->update($data);

        session()->flash('update_message', 'Added');
        return redirect()->route('admin.product.index');
    }


    public function delete($slug)
    {
        QueryHelper::dbRemove('products', array('slug' => $slug));

        session()->flash('delete_message', 'Deleted');
        return redirect()->route('admin.product.index');
    }


    public function recovery()
    {
        if (request()->filled('items')) {

            $items = request()->items;
        }else{

            $items = $this->initalItems;
        }

        if(Auth::guard('admin')->user()->is_merchant){
            $products = Product::orderBy('id', 'desc')
            ->where('status', 9)
            ->where('admin_id', Auth::guard('admin')->user()->id)
            // ->get();
            ->paginate($items);
            
        }
        else{
            $products = Product::orderBy('status','desc')
            ->orderBy('id','desc')
            ->where('status', 9)
            // ->get();
            ->paginate($items);

        }

        $total = $products->total();
        return view('backend.pages.product.recovery', compact('products', 'items', 'total'));
    }
    public function recover($slug)
    {
        $product = Product::where('slug', $slug);
        $product_fetch = $product->first();
        Brand::where('id', $product_fetch->brand_id)->update(['status' => 1]);
        Brand::where('id', $product_fetch->category_id)->update(['status' => 1]);
        Brand::where('id', $product_fetch->sub_category_id)->update(['status' => 1]);
        $product->update(['status' => 1]);


        session()->flash('recover_success', 'Recover Successfully...');
        return redirect()->route('admin.product.recovery');
    }

    public function permanentDelete($id)
    {
        // get product
        $product = Product::where('id', $id);
        //get product image
        $product_img = $product->first()->image;
        $product_orginial_img = $product->first()->original_image;
        // get single image
        foreach ($product_img as $key => $single_img) {
            if(file_exists($single_img)){
                unlink($single_img);
            }
        }
        // get single original image
        foreach ($product_orginial_img as $key => $p_s_or_img) {
            if(file_exists($p_s_or_img)){
                unlink($p_s_or_img);
            }
        }
        //delete product
        $product->delete();

        $order_items = DB::table('order_items')->where('product_id', $id);
        $product_rating = DB::table('product_ratings')->where('product_id', $id);
        
        if($order_items->get()){
            foreach ($order_items->get() as $key => $order_item) {
                DB::table('orders')->where('id', $order_item->order_id)->delete();
            }
            $order_items->delete();
        }

        if($product_rating){
            $product_rating->delete();
        }
        
        session()->flash('parment_delete_message', 'Product Deleted Successfully');
        return redirect(route('admin.product.recovery'));
    }
}
