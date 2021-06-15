<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\QueryHelper;
use App\Models\OrderItem;
use App\Helpers\CalculationHelper;
use App\Models\ReturnedProduct;
use App\Models\Order;
use DB;

class ReturnItemController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:admin');
    }

    public function index()
    {
        $items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('users.username', 'users.mobile', 'order_items.order_id', 'order_items.quantity', 'order_items.id', 'products.title', 'products.regular_price', 'orders.id as order_id')
            ->where(['order_items.is_return'=>1])
            ->get();
            
        $total = 0;
        foreach($items as $item){
            $total += ($item->quantity * $item->price);
        }
        
    	return view('backend.pages.return_item.index', compact('items', 'total'));
    }

    public function view($id)
    {
        $order = DB::table('order_items')
            ->where('order_id', $id);
            // ->where('admin_id', Auth()->user()->id);

        $order_item = $order->first();
        $order = Order::find($id);
        if (!$order) {
            return view('errors.404');
        }
        if ($order_item->order_status >= 3) {
            return view('backend.pages.order.view', compact('order', 'order_item'));
        } else {
            return redirect()->route('admin.order.pending-view',$id);
        }
    }

    public function received($id){
        $items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('order_items.product_id', 'order_items.quantity', 'order_items.price', 'order_items.user_id', 'order_items.order_id')
            ->where(['order_items.is_return'=>1])
            ->where(['order_items.id'=>$id])
            ->first();

        ReturnedProduct::create((array)$items);
        OrderItem::where(['id'=>$id])->delete();

        $order      = Order::where('id', $items->order_id);
        $itemSearch = OrderItem::where('order_id', $items->order_id);
        if(!$itemSearch->get()->isEmpty()){
            $data = [];
            $total = 0;

            foreach ($itemSearch->get() as $key => $value) {
                $total += ($value->price * $value->quantity);
            }

            $data['total_price'] = $data['grand_total'] = $total;

            $itemSearchR = $itemSearch->where('is_return', 1)->get();
            if(!$itemSearchR->isEmpty()){
                $data['is_return'] = 1;
            }else{
                $data['is_return'] = 0;
            }
            $order->update($data);
        }else{
           $order->delete(); 
        }

        session()->flash('success', 'This Product Successfully Returned!');
        return redirect()->back();
    }

    public function returnedItem()
    {
        $items = DB::table('returned_products')
                ->join('products', 'products.id', '=', 'returned_products.product_id')
                ->join('users', 'users.id', '=', 'returned_products.user_id')
                ->select('users.username', 'users.mobile', 'returned_products.order_id', 'returned_products.quantity', 'products.title', 'returned_products.price', 'returned_products.order_id')
                ->get();
        $total = 0;
        foreach($items as $item){
            $total += ($item->quantity * $item->price);
        }
            
        return view('backend.pages.return_item.all_returned', compact('items', 'total'));
    }
}