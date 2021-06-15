<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserHistory;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductRating;
use App\Models\Review;
use Auth;
use DB;

class OrderController extends Controller
{
	public function index($order_id)
	{
		$user_order = Order::where('id', $order_id)->first()->toArray();
		return response()->json($user_order);
	}
	public function returnItem($item_id=null)
	{	
		$item = OrderItem::where('id', $item_id)->first()->toArray();
		if(date("Y-m-d h:i:s", strtotime($item['created_at']." +7day")) >= date("Y-m-d h:i:s")){
			OrderItem::where('id', $item_id)->update(['is_return'=>1]);
			$item = OrderItem::where('id', $item_id)->first()->toArray();

			/*
			* order
			*/
			$order = Order::where('id', $item['order_id']);
			$order->update(['is_return'=>1]);
			$order = $order->first()->toArray();
		}
		else{
			$order = "error";
		}
		return $order;
	}
	public function cancelItem($item_id=null)
	{	
		$item = OrderItem::where('id', $item_id)->first();
		$order_id = $item->order_id;

		$item->delete();

		$order = Order::where('id', $order_id);
		$searchItems = OrderItem::where('order_id', $order_id)->get();
		if(!$searchItems->isEmpty()){
			$total = 0;
            foreach ($searchItems as $key => $value) {
                $total += ($value->price * $value->quantity);
            }
            $order->update(['total_price'=>$total, 'grand_total'=>$total]);
		}
		else{
			$order->delete();
			return 0;
		}

		$order = Order::where('id', $order_id);
		return $order->first()->toArray();
	}
}