<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Models\OrderItem;
use App\Models\Order;
use DB;

class ProfitLossController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {

    	$products = DB::table('orders')
	    	->join('order_items', 'orders.id', '=', 'order_items.order_id')
	    	->join('products', 'order_items.product_id', '=', 'products.id')
	    	->select('products.title', 'products.purchase_price', 'products.regular_price', DB::raw('count(order_items.quantity) as total_qty'), 'orders.updated_at')
	    	->groupBy('order_items.product_id')
            ->groupBy('orders.updated_at')
	    	->where(['order_items.order_status'=>4]);
            if($request->isMethod('POST') && $request->from_date && $request->to_date){
                $products = $products->where('orders.updated_at', '>=', $request->from_date);
                $products = $products->where('orders.updated_at', '<=', $request->to_date." 23:00:00");
            }
            $products = $products->get();
            

        return view('backend.pages.profit_loss.index', compact('products'));
    }
}
