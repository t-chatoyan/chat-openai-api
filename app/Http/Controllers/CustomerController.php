<?php

namespace App\Http\Controllers;

use App\Exports\ExportMessages;
use App\Models\Chat;
use App\Models\Customer;
use App\Models\Messages;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $customers = Customer::paginate(15);
        return view('customer.index',compact('customers'));
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function getChat($id)
    {
        $chats = Chat::with('customer')->where('customer_id',$id)->paginate(5);

        return view('customer.chats',compact('chats'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Factory|View
     */
    public function getChatMessages($id)
    {
        $messages = Messages::where('chat_id', $id)->orderBy('id', 'asc')->paginate(15);
        $chat_id = $id;
        return view('customer.messages',compact('messages', 'chat_id'));
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function exportMessages($id)
    {
        return \Excel::download((new ExportMessages($id)), 'messages.xlsx');
    }
}
