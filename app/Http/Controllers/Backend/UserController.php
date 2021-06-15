<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(Request $request)
    {   
        $condition = [['status', '!=', 9]];     
        $users = User::orderBy('id', 'asc');

        if($request->isMethod('post')){
            if(isset($request->from_date) && !empty($request->from_date)){
                $from_date = date_format(date_create_from_format('m/d/Y H:i:s', $request->from_date.' 00:00:00'), 'Y-m-d H:i:s');
                $condition[] = ['created_at', '>=', $from_date ];
            }
            
            if(isset($request->to_date) && !empty($request->from_date)){
                $to_date = date_format(date_create_from_format('m/d/Y H:i:s', $request->to_date.' 00:00:00'), 'Y-m-d H:i:s');
                $condition[] = ['created_at', '<=', $to_date ];
            }

        }
        $users = $users->where($condition)->get();

        return view('backend.pages.user.index', compact('users'));
    }


    public function trash(Request $request)
    {   
        $condition = [['status', '=', 9]];     
        $users = User::orderBy('id', 'asc');

        if($request->isMethod('post')){
            if(isset($request->from_date) && !empty($request->from_date)){
                $from_date = date_format(date_create_from_format('m/d/Y H:i:s', $request->from_date.' 00:00:00'), 'Y-m-d H:i:s');
                $condition[] = ['created_at', '>=', $from_date ];
            }
            
            if(isset($request->to_date) && !empty($request->from_date)){
                $to_date = date_format(date_create_from_format('m/d/Y H:i:s', $request->to_date.' 00:00:00'), 'Y-m-d H:i:s');
                $condition[] = ['created_at', '<=', $to_date ];
            }

        }
        $users = $users->where($condition)->get();

        return view('backend.pages.user.trash', compact('users'));
    }


    public function banUnban($id)
    {
        $user = User::where('id', $id)->first();
        if($user){
            if($user->status == 1){
                $user->status = 0;
            }
            else{
                $user->status = 1;
            }

            $user->save();

            session()->flash('update_message', 'Updated');
            return redirect()->route('admin.user.index');
        }
        else{
            return back();
        }
    }


    public function toTrash($id)
    {
        User::where('id', $id)->update(['status' => 9]);

        session()->flash('delete_message', 'Updated');
        return redirect()->route('admin.user.index');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        Order::where('user_id', $id)->limit(100)->delete();
        OrderItem::where('user_id', $id)->limit(100)->delete();

        session()->flash('delete_message', 'Successfully User Permanently Deleted');
        return redirect()->back();
    }

    public function restore($id)
    {
        User::where('id', $id)->update(['status' => 1]);

        session()->flash('update_message', 'This user Restore successful');
        return redirect()->route('admin.user.trash');
    }
    
    public function maxAmount()
    {
        $maxusers = DB::table('users')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->select('users.*', DB::raw('SUM(orders.grand_total) as total_amount_tk'))
            ->orderBy('total_amount_tk', 'DESC')
            ->limit(8)->get();
        
        return view('backend.pages.user.maxamount', compact('maxusers'));
    }
    
    public function maxOrder()
    {
        $maxusers = DB::table('users')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->select('users.*', DB::raw('COUNT(orders.id) as total_order'))
            ->orderBy('total_order', 'DESC')
            ->limit(8)->get();
            
        return view('backend.pages.user.maxorder', compact('maxusers'));
    }
    
    // User Report
    public function report(Request $request)
    {
        $where = [];
        if($request->isMethod('POST')){
            if($request->from!='')
                $where[] = ['orders.created_at', '>=', $request->from.' 12:00:00'];
            if($request->to!='')
                $where[] = ['orders.created_at', '<=', $request->to.' 23:59:00'];
            if($request->user_id!='')
                $where[] = ['users.id', '=', $request->user_id];
        }else{
            $where[] = ['orders.created_at', '>=', date('Y-m-d').' 12:00:00'];
            $where[] = ['orders.created_at', '<=', date('Y-m-d').' 23:59:00'];
        }
        
        $result = DB::table('users')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->leftjoin('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                "users.*", 
                "orders.grand_total",
                "orders.created_at as date",
                DB::raw("COUNT(order_items.id) as total_items"),
                DB::raw("SUM(order_items.quantity) as total_qty")
            )
            ->where($where)
            ->groupBy('orders.id')
            ->orderBy('orders.id', 'DESC')->get();
        
        
        $users = DB::table('users')->get();
        return view('backend.pages.user.report', compact('result', 'users'));
    }
}
