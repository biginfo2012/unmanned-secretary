<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Account;
use App\Models\Cost;
use App\Models\Shop;
use App\Models\TaxType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UserController extends Controller
{
    public function costManage(Request $request)
    {
        $user = Auth::user();
        return view('client-cost-manage', compact('user'));
    }

    public function tableCost(Request $request)
    {
        $user_id = $request->id;
        $data = Cost::with('user', 'shop', 'account')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('client-cost-table', compact('data'));
    }

    public function editCost($id)
    {
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $users = [1, $parent_id, $user_id];
        $accounts = Account::with('tax')->whereIn('user_id', $users)->orderBy('created_at', 'desc')->get();
        $data = Cost::with('user', 'shop')->find($id);
        Cost::find($id)->update(['status' => 1]);
        return view('client-cost-edit', compact('data', 'accounts'));
    }
    public function saveCost(Request $request)
    {
        $id = $request->id;
        $shop_name = $request->shop_name;
        $shop_id = null;
        if(!empty($shop_name)){
            $shop = Shop::where('shop_name', $shop_name)->first();
            if(isset($shop)){
                $shop_id = $shop->id;
            }
            else{
                $shop_data = [
                    'shop_name' => $shop_name
                ];
                $shop = Shop::create($shop_data);
                $shop_id = $shop->id;
            }
        }
        $data = [
            'shop_id' => $shop_id,
            'pay_date' => $request->pay_date,
            'total' => $request->total,
            'percent' => $request->percent,
            'content' => $request->contents,
            'note' => $request->note,
            'account_id' => $request->account_id
        ];
        Cost::find($id)->update($data);
        return response()->json(['status' => true]);
    }
    public function deleteCost(Request $request)
    {
        $id = $request->id;
        Cost::where('id', $id)->delete();
        return response()->json(['status' => true]);
    }

    public function costExportExcel(Request $request)
    {
        $user_id = $request->id;
        $data = Cost::with('user', 'shop')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        $arr = array();
        foreach ($data as $index => $datum) {
            $tmp = [];
            $tmp['shop_name'] = !empty($datum->shop_id) ? $datum->shop->shop_name : "";
            $tmp['account'] = !empty($datum->account) ? $datum->account->subject : "";
            $tmp['total'] = $datum->total;
            $tmp['percent'] = $datum->percent;
            $tmp['pay_date'] = $datum->pay_date;
            $tmp['content'] = $datum->content;
            $tmp['note'] = $datum->note;
            $tmp['created_at'] = $datum->created_at;
            array_push($arr, $tmp);
        }
        $data = $arr;

        $array[] = array('NO', __('pay-date'), __('summary'), __('account-item'),
            __('total'), __('tax'), __('import-date'), __('content'), __('note'));
        foreach ($data as $index => $item) {
            $array[] = array(
                'NO' => $index + 1,
                __('pay-date') => date('Y/m/d', strtotime($item['pay_date'])),
                __('summary') => $item['shop_name'],
                __('account-item') =>  $item['account'],
                __('total') => number_format($item['total']) . "円",
                __('tax') => $item['percent'] . "%",
                __('import-date') => date('Y/m/d', strtotime($item['created_at'])),
                __('content') => $item['content'],
                __('note') => $item['note']
            );
        }
        $export = new InvoicesExport([
            $array
        ]);

        return Excel::download($export, '経費一覧.xlsx');
    }

    public function costExportPDF($id)
    {
        // retreive all records from db
        $user_id = $id;
        $data = Cost::with('user', 'shop')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get()->toArray();
        // share data to view
        //view()->share('employee',$data);
        $data = [
            'data' => $data
        ];
        $pdf = PDF::loadView('cost-table-pdf', $data);
        // download PDF file with download method
        return $pdf->download('経費一覧.pdf');
    }

    public function manageAccount(){
        return view('account-manage');
    }
    public function tableAccount(Request $request){
        $subject = $request->subject;
        $code = $request->code;
        $keyword = $request->keyword;
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $users = [1, $parent_id, $user_id];
        if(isset($subject)){
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('subject', 'like', '%' . $subject . '%')
                        ->where('keyword', 'like', '%' . $keyword . '%')->whereIn('user_id', $users)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('subject', 'like', '%' . $subject . '%')
                        ->whereIn('user_id', $users)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax')->where('subject', 'like', '%' . $subject . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->whereIn('user_id', $users)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('subject', 'like', '%' . $subject . '%')
                        ->whereIn('user_id', $users)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
            }
        }
        else{
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->whereIn('user_id', $users)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->whereIn('user_id', $users)
                        ->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax')->where('keyword', 'like', '%' . $keyword . '%')->whereIn('user_id', $users)
                        ->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->whereIn('user_id', $users)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                }
            }
        }

//        print_r($data);
//        die();
        return view('account-table', compact('data'));
    }
    public function addAccount(){
        $types = TaxType::all();
        return view('account-add', compact('types'));
    }
    public function editAccount($id){
        $account = Account::find($id);
        $types = TaxType::all();
        return view('account-add', compact('account', 'types'));
    }
    public function saveAccount(Request $request){
        $id = $request->id;
        if(!isset($id)){
            $subject = $request->subject;
            $account = Account::where('subject', $subject)->first();
            if(!isset($account)){
                $data = [
                    'subject' => $request->subject,
                    'code' => $request->code,
                    'assistant' => $request->assistant,
                    'keyword' => $request->keyword,
                    'type' => $request->type,
                    'user_id' => Auth::user()->id
                ];
                Account::create($data);
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false, 'result' => 'subject_already_exist']);
        }
        else{
            $subject = $request->subject;
            $account = Account::where('subject', $subject)->first();
            if(isset($account)){
                if($id == $account->id){
                    $data = [
                        'subject' => $request->subject,
                        'code' => $request->code,
                        'assistant' => $request->assistant,
                        'keyword' => $request->keyword,
                        'type' => $request->type
                    ];
                    Account::find($id)->update($data);
                    return response()->json(['status' => true]);
                }
                else{
                    return response()->json(['status' => false, 'result' => 'subject_already_exist']);
                }
            }
            else{
                $data = [
                    'subject' => $request->subject,
                    'code' => $request->code,
                    'assistant' => $request->assistant,
                    'keyword' => $request->keyword,
                    'type' => $request->type
                ];
                Account::find($id)->update($data);
                return response()->json(['status' => true]);
            }
        }
    }
    public function deleteAccount(Request $request){
        $id = $request->id;
        Account::where('id', $id)->delete();
        return response()->json(['status' => true]);
    }

    public function myPage()
    {
        $user = Auth::user();
        return view('my-page', compact('user'));
    }

    public function editInfo(Request $request)
    {
        $id = Auth::user()->id;
        if (isset($request->password)) {
            $data = [
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'post_code' => $request->post_code,
                'address' => $request->address,
                'contact' => $request->contact,
                'charge' => $request->charge,
                'remarks' => $request->remarks,
                'plan_id' => $request->plan,
                'represent' => $request->represent,
                'type' => $request->type
            ];
        } else {
            $data = [
                'name' => $request->name,
                'post_code' => $request->post_code,
                'address' => $request->address,
                'contact' => $request->contact,
                'charge' => $request->charge,
                'remarks' => $request->remarks,
                'plan_id' => $request->plan,
                'represent' => $request->represent,
                'type' => $request->type
            ];
        }
        User::find($id)->update($data);

        return response()->json(['status' => true]);
    }
}
