<?php

namespace App\Http\Controllers;

use App\Models\OrderStatusUpdate;
use App\Models\PurchaseStatus;
use App\Models\TicketPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function index(){

        $val = TicketPurchase::where('ticket_purchase.purchase_status','<>',3)
        ->where('ticket_purchase.purchase_status','<>',6)
        ->leftjoin('countries','countries.id','shipping_country')
        ->leftjoin('event','event.id','ticket_purchase.event_id')
        ->leftjoin('event_tickets','event_tickets.id','ticket_purchase.event_ticket_id')
       ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
       ->leftjoin('purchase_status','purchase_status.id','ticket_purchase.purchase_status')
       ->leftjoin('users','users.id','ticket_purchase.user_id')
       ->orderBy('ticket_purchase.created_at','DESC')
        ->select('*','ticket_purchase.id as id','currency.name as currency_name','users.name as user_name');

        if(Auth::user()->user_type == 'superadmin'){

            $data = $val->get();
        }else{

        $data = $val->where('event_tickets.created_by',Auth::user()->id)->get();
        }

        return view('admin.order.list',compact('data'));
    }

    public function old_list(){

        $val = TicketPurchase::where('ticket_purchase.purchase_status',3)
        ->orWhere('ticket_purchase.purchase_status',6)
        ->leftjoin('countries','countries.id','shipping_country')
        ->leftjoin('event','event.id','ticket_purchase.event_id')
        ->leftjoin('event_tickets','event_tickets.id','ticket_purchase.event_ticket_id')
       ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
       ->leftjoin('purchase_status','purchase_status.id','ticket_purchase.purchase_status')
       ->leftjoin('users','users.id','ticket_purchase.user_id')
       ->orderBy('ticket_purchase.created_at','DESC')
        ->select('*','ticket_purchase.id as id','currency.name as currency_name','users.name as user_name');

        if(Auth::user()->user_type == 'superadmin'){

            $data = $val->get();
        }else{

        $data = $val->where('event_ticket_id.created_by',Auth::user()->id)->get();
        }

        return view('admin.order.list',compact('data'));
    }


    public function update_order_status($id){

        $data = TicketPurchase::where('ticket_purchase.id',$id)

        ->leftjoin('countries','countries.id','shipping_country')
        ->leftjoin('event','event.id','ticket_purchase.event_id')
       ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
       ->leftjoin('purchase_status','purchase_status.id','ticket_purchase.purchase_status')
       ->leftjoin('users','users.id','ticket_purchase.user_id')
        ->select('*','ticket_purchase.id as id','currency.name as currency_name','users.name as user_name')->first();

        $status = PurchaseStatus::get();

        $log = OrderStatusUpdate::where('order_status_log.purchase_id',$id)
       ->leftjoin('purchase_status','purchase_status.id','order_status_log.status_id')
       ->leftjoin('users','users.id','order_status_log.created_by')
       ->select('*','order_status_log.id as id')
       ->get();

        return view('admin.order.change_status',compact('data','status','log'));
    }


    public function order_status_change(Request $request){

        $data = new OrderStatusUpdate();
        $data->purchase_id = $request->purchase_id;
        $data->status_id = $request->status_id;
        $data->remark = $request->remark;
        $data->created_by = Auth::user()->id;
        if($request->hasFile('document')){
            $imageName = time().'.'.$request->document->extension();
            $request->document->move(storage_path('uploads/purchase_status_document'), $imageName);
            $data->document =  $imageName;
        }
        $data->save();


        $purchase = TicketPurchase::find($request->purchase_id);
        $purchase->purchase_status = $request->status_id;
        $purchase->save();




        // return redirect('customer_order/list');
        return back();

    }

    public function delete_status_log($id){

        $data =  OrderStatusUpdate::find($id);
        $data->delete();
        return back();
    }


}
