<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Account;
use App\Models\AccountKeyword;
use App\Models\AccountType;
use App\Models\Cost;
use App\Models\CostReport;
use App\Models\Shop;
use App\Models\TaxType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
//use niklasravnsborg\LaravelPdf\Facades\Pdf;
use PDF;
use function Ramsey\Uuid\v1;

class UserController extends Controller
{
    public function costManage(Request $request)
    {
        $user = Auth::user();
        $type_id = Auth::user()->account_type;
        $account_type = AccountType::find($type_id)->name;
        $accounts = Account::where('type_id', $type_id)->get();
        return view('client-cost-manage', compact('user', 'account_type', 'accounts'));
    }

    public function tableCost(Request $request)
    {
        $user_id = Auth::user()->id;
        $type_id = Auth::user()->account_type;
        $account_keyword = $request->account_keyword;
        $keyword = $request->keyword;
        $down = $request->down;
        if($down == 'true'){
            if(isset($keyword)){
                if(isset($account_keyword)){
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND s.shop_name like '%" . $keyword . "%' AND ak.keyword_id = " . $account_keyword . " ORDER BY c.created_at DESC";
                }
                else{
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND s.shop_name like '%" . $keyword . "%' ORDER BY c.created_at DESC";
                }
            }
            else{
                if(isset($account_keyword)){
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND ak.keyword_id = " . $account_keyword . " ORDER BY c.created_at DESC";
                }
                else{
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " ORDER BY c.created_at DESC";
                }
            }
        }
        else{
            if(isset($keyword)){
                if(isset($account_keyword)){
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND s.shop_name like '%" . $keyword . "%' AND ak.keyword_id = " . $account_keyword . " AND c.export != 1 ORDER BY c.created_at DESC";
                }
                else{
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND s.shop_name like '%" . $keyword . "%' AND c.export != 1 ORDER BY c.created_at DESC";
                }
            }
            else{
                if(isset($account_keyword)){
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND ak.keyword_id = " . $account_keyword . " AND c.export != 1 ORDER BY c.created_at DESC";
                }
                else{
                    $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND c.export != 1 ORDER BY c.created_at DESC";
                }
            }
        }

        $data = DB::select($sql);
        $data = json_decode(json_encode($data, true), true);
        return view('client-cost-table', compact('data'));
    }

    public function editCost($id)
    {
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $users = [1, $parent_id, $user_id];
        $type_id = Auth::user()->account_type;
        $accounts = Account::with('tax')->where('type_id', $type_id)->whereIn('user_id', $users)->get();
        $data = Cost::with('user', 'shop')->find($id);
        $myaccount = null;
        if(!empty($data->account_id)){
            $keyword_id = $data->account_id;
            $myaccount = Account::where('type_id', $type_id)->where('keyword_id', $keyword_id)->first();
        }

        Cost::find($id)->update(['status' => 1]);
        return view('client-cost-edit', compact('data', 'accounts', 'myaccount'));
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
    public function costExportCSV(Request $request)
    {
        $user_id = Auth::user()->id;
        $type_id = Auth::user()->account_type;
        $account_type = trim(AccountType::find($type_id)->name);
        $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.note, s.shop_name, ak.`subject`, ak.keyword_id, ak.`code`, ak.tax_type FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id, a.`code`, tt.tax_type FROM accounts as a LEFT JOIN tax_types AS tt ON tt.id = a.type
WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id WHERE c.user_id = " . $user_id . " ORDER BY c.created_at DESC";
        $data = DB::select($sql);
        $data = json_decode(json_encode($data, true), true);

        $fileName = '経費一覧.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($data, $account_type) {
            $file = fopen('php://output', 'w');
            //fputcsv($file, $columns);

            foreach ($data as $index => $task) {
                if($account_type == "会計王"){
                    $row[] = "*";
                    $row[] = $index + 1;
                    $row[]  = !empty($task['pay_date']) ? date('Y/m/d', strtotime($task['pay_date'])) : "";
                    $row[]  = mb_convert_encoding($task['code'], "SJIS-win", "UTF-8");
                    $row[]  = mb_convert_encoding($task['subject'], "SJIS-win", "UTF-8");
                    $row[]  = 0;
                    $row[]  = "";
                    $row[]  = 0;
                    $row[]  = "";
                    $row[]  = 21;
                    $row[]  = 0;
                    $row[]  = 3;
                    $row[]  = !empty($task['percent']) ? $task['percent'] . "%" : "";
                    $row[] = $task['total'];
                    $row[]  = "";
                    $row[]  = 100;
                    $row[]  = mb_convert_encoding("現金", "SJIS-win", "UTF-8");
                    $row[]  = 0;
                    $row[]  = "";
                    $row[]  = 0;
                    $row[]  = "";
                    $row[]  = 0;
                    $row[]  = 0;
                    $row[]  = 3;
                    $row[]  = "0%";
                    $row[] = $task['total'];
                    $row[]  = "";
                    $row[]  = mb_convert_encoding($task['shop_name'], "SJIS-win", "UTF-8");
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = 0;
                    $row[]  = 0;
                    $row[]  = 0;
                    $row[]  = "";
                }
                else if($account_type == "弥生会計"){
                    $row[] = "2111";
                    $row[] = $index + 1;
                    $row[]  = "";
                    $row[]  = !empty($task['pay_date']) ? date('Y/m/d', strtotime($task['pay_date'])) : "";
                    $row[]  = mb_convert_encoding($task['subject'], "SJIS-win", "UTF-8");
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = mb_convert_encoding($task['tax_type'], "SJIS-win", "UTF-8");
                    $row[] = $task['total'];
                    $row[] = !empty($task['percent']) ? (int)($task['total'] * $task['percent'] / 100) : "";
                    $row[]  = mb_convert_encoding("現金", "SJIS-win", "UTF-8");
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = mb_convert_encoding("対象外", "SJIS-win", "UTF-8");
                    $row[] = $task['total'];
                    $row[]  = 0;
                    $row[]  = mb_convert_encoding($task['shop_name'], "SJIS-win", "UTF-8");
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = 3;
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = "";
                    $row[]  = "NO";
                }
                else{
                    $row[]  = !empty($task['pay_date']) ? date('Y/m/d', strtotime($task['pay_date'])) : "";
                    $row[]  = mb_convert_encoding($task['shop_name'], "SJIS-win", "UTF-8");
                    $row[]  = mb_convert_encoding($task['subject'], "SJIS-win", "UTF-8");
                    $row[]  = !empty($task['percent']) ? $task['percent'] . "%" : "";
                    $row[] = $task['total'];
                    $row[] = mb_convert_encoding($task['note'], "SJIS-win", "UTF-8");
                }

                fputcsv($file, $row);
                $row = [];
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function costExportPDF($id)
    {
        $data = Cost::with('user', 'shop')->where('id', $id)->get()->toArray();
        $type_id = Auth::user()->account_type;
        if(!empty($data[0]['account_id'])){
            $keyword_id = $data[0]['account_id'];
            $myaccount = Account::where('type_id', $type_id)->where('keyword_id', $keyword_id)->first();
            $data[0]['subject'] = $myaccount->subject;
        }
        $data = [
            'data' => $data
        ];

//        $pdf = PDF::loadView('cost-table-pdf', $data);
//        return $pdf->stream('document.pdf');

        $pdf = PDF::loadView('cost-table-pdf', $data);
        return $pdf->download('領収書詳細' . date('YmdHis') . '.pdf');
    }

    public function manageAccount(){
        $account_type_id = Auth::user()->account_type;
        $account_type = AccountType::find($account_type_id)->name;
        $account_types = AccountType::all();
        return view('account-manage', compact('account_type', 'account_types'));
    }
    public function tableAccount(Request $request){
        $subject = $request->subject;
        $code = $request->code;
        $keyword = $request->keyword;
        $user_id = Auth::user()->id;
        $parent_id = Auth::user()->parent_id;
        $users = [1, $parent_id, $user_id];
        $type_id = Auth::user()->account_type;
        if(isset($subject)){
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')
                        ->where('subject', 'like', '%' . $subject . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->whereIn('user_id', $users)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')
                        ->where('subject', 'like', '%' . $subject . '%')->whereIn('user_id', $users)->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('subject', 'like', '%' . $subject . '%')
                        ->where('keyword', 'like', '%' . $keyword . '%')->whereIn('user_id', $users)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('subject', 'like', '%' . $subject . '%')
                        ->whereIn('user_id', $users)->get();
                }
            }
        }
        else{
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')
                        ->where('keyword', 'like', '%' . $keyword . '%')->whereIn('user_id', $users)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')->whereIn('user_id', $users)->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('keyword', 'like', '%' . $keyword . '%')->whereIn('user_id', $users)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->whereIn('user_id', $users)->get();
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
        $keyword = $request->keyword;
        $subject = $request->subject;
        $type_id = Auth::user()->account_type;
        if(!isset($id)){
            $account = Account::where('subject', $subject)->first();
            if(!isset($account)){
                $ak = AccountKeyword::where('keyword', $keyword)->first();
                if(!isset($ak)){
                    $nk = AccountKeyword::create([
                        'keyword' => $keyword
                    ]);
                    $keyword_id = $nk->id;
                }
                else{
                    $keyword_id = $ak->id;
                }
                $data = [
                    'subject' => $subject,
                    'code' => $request->code,
                    'assistant' => $request->assistant,
                    'keyword_id' => $keyword_id,
                    'type' => $request->type,
                    'user_id' => Auth::user()->id,
                    'type_id' => $type_id
                ];
                Account::create($data);
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false, 'result' => 'subject_already_exist']);
        }
        else{
            $account = Account::where('subject', $subject)->first();
            if(isset($account)){
                if($id == $account->id){
                    $ak = AccountKeyword::where('keyword', $keyword)->first();
                    if(!isset($ak)){
                        $nk = AccountKeyword::create([
                            'keyword' => $keyword
                        ]);
                        $keyword_id = $nk->id;
                    }
                    else{
                        $keyword_id = $ak->id;
                    }
                    $data = [
                        'subject' => $subject,
                        'code' => $request->code,
                        'assistant' => $request->assistant,
                        'keyword_id' => $keyword_id,
                        'type' => $request->type,
                        'type_id' => $type_id
                    ];
                    Account::find($id)->update($data);
                    return response()->json(['status' => true]);
                }
                else{
                    return response()->json(['status' => false, 'result' => 'subject_already_exist']);
                }
            }
            else{
                $ak = AccountKeyword::where('keyword', $keyword)->first();
                if(!isset($ak)){
                    $nk = AccountKeyword::create([
                        'keyword' => $keyword
                    ]);
                    $keyword_id = $nk->id;
                }
                else{
                    $keyword_id = $ak->id;
                }
                $data = [
                    'subject' => $subject,
                    'code' => $request->code,
                    'assistant' => $request->assistant,
                    'keyword_id' => $keyword_id,
                    'type' => $request->type,
                    'type_id' => $type_id
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
    public function changeAccountType(Request $request){
        $account_type = $request->account_type;
        $user_id = Auth::user()->id;
        User::find($user_id)->update(['account_type' => $account_type]);
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
                'prefecture' => $request->prefecture,
                'city' => $request->city,
                'town' => $request->town,
                'after' => $request->after,
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
                'prefecture' => $request->prefecture,
                'city' => $request->city,
                'town' => $request->town,
                'after' => $request->after,
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

    public function addSoftware(){
        $account_type_id = Auth::user()->account_type;
        $account_type = AccountType::find($account_type_id)->name;
        $account_types = AccountType::all();

        $user_id = Auth::user()->id;
        $type_id = Auth::user()->account_type;
        $user_code = Auth::user()->user_code;
        $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND c.export != 1 AND c.url IS NOT NULL AND c.pay_date IS NOT NULL AND s.shop_name IS NOT NULL AND ak.subject IS NOT NULL AND c.total IS NOT NULL AND c.percent IS NOT NULL ORDER BY c.pay_date DESC";
        $data = DB::select($sql);
        $data = json_decode(json_encode($data, true), true);
        return view('software-add', compact('account_types', 'account_type', 'data', 'user_code'));
    }
    public function costExportCSVSoftware(Request $request){
        $account_type_id = Auth::user()->account_type;
        $account_type = AccountType::find($account_type_id)->name;
        $user_id = Auth::user()->id;
        $type_id = Auth::user()->account_type;
        $ids = $request->ids;
        if(isset($ids)){
            $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, c.export, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND c.export != 1 AND c.url IS NOT NULL AND c.pay_date IS NOT NULL AND s.shop_name IS NOT NULL
AND ak.subject IS NOT NULL AND c.total IS NOT NULL AND c.percent IS NOT NULL AND c.id IN (" . $ids . ") ORDER BY c.pay_date DESC";
            $data = DB::select($sql);
            $data = json_decode(json_encode($data, true), true);
            $ids = explode(',', $ids);
            Cost::whereIn('id', $ids)->update(['export' => 1]);
            $fileName = '経費一覧.csv';

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $callback = function() use($data, $account_type) {
                $file = fopen('php://output', 'w');
                //fputcsv($file, $columns);

                foreach ($data as $index => $task) {
                    if($account_type == "会計王"){
                        $row[] = "*";
                        $row[] = $index + 1;
                        $row[]  = !empty($task['pay_date']) ? date('Y/m/d', strtotime($task['pay_date'])) : "";
                        $row[]  = mb_convert_encoding($task['code'], "SJIS-win", "UTF-8");
                        $row[]  = mb_convert_encoding($task['subject'], "SJIS-win", "UTF-8");
                        $row[]  = 0;
                        $row[]  = "";
                        $row[]  = 0;
                        $row[]  = "";
                        $row[]  = 21;
                        $row[]  = 0;
                        $row[]  = 3;
                        $row[]  = !empty($task['percent']) ? $task['percent'] . "%" : "";
                        $row[] = $task['total'];
                        $row[]  = "";
                        $row[]  = 100;
                        $row[]  = mb_convert_encoding("現金", "SJIS-win", "UTF-8");
                        $row[]  = 0;
                        $row[]  = "";
                        $row[]  = 0;
                        $row[]  = "";
                        $row[]  = 0;
                        $row[]  = 0;
                        $row[]  = 3;
                        $row[]  = "0%";
                        $row[] = $task['total'];
                        $row[]  = "";
                        $row[]  = mb_convert_encoding($task['shop_name'], "SJIS-win", "UTF-8");
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = 0;
                        $row[]  = 0;
                        $row[]  = 0;
                        $row[]  = "";
                    }
                    else if($account_type == "弥生会計"){
                        $row[] = "2111";
                        $row[] = $index + 1;
                        $row[]  = "";
                        $row[]  = !empty($task['pay_date']) ? date('Y/m/d', strtotime($task['pay_date'])) : "";
                        $row[]  = mb_convert_encoding($task['subject'], "SJIS-win", "UTF-8");
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = mb_convert_encoding($task['tax_type'], "SJIS-win", "UTF-8");
                        $row[] = $task['total'];
                        $row[] = !empty($task['percent']) ? (int)($task['total'] * $task['percent'] / 100) : "";
                        $row[]  = mb_convert_encoding("現金", "SJIS-win", "UTF-8");
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = mb_convert_encoding("対象外", "SJIS-win", "UTF-8");
                        $row[] = $task['total'];
                        $row[]  = 0;
                        $row[]  = mb_convert_encoding($task['shop_name'], "SJIS-win", "UTF-8");
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = 3;
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = "";
                        $row[]  = "NO";
                    }
                    else{
                        $row[]  = !empty($task['pay_date']) ? date('Y/m/d', strtotime($task['pay_date'])) : "";
                        $row[]  = mb_convert_encoding($task['shop_name'], "SJIS-win", "UTF-8");
                        $row[]  = mb_convert_encoding($task['subject'], "SJIS-win", "UTF-8");
                        $row[]  = !empty($task['percent']) ? $task['percent'] . "%" : "";
                        $row[] = $task['total'];
                        $row[] = mb_convert_encoding($task['note'], "SJIS-win", "UTF-8");
                    }

                    fputcsv($file, $row);
                    $row = [];
                }

                fclose($file);
            };
            CostReport::create(['report_date' => date('Y-m-d'), 'report_count' => count($ids)]);
            return response()->stream($callback, 200, $headers);
        }
        else{
            return response()->json(['status' => false]);
        }

    }
    public function historySoftware(){
        return view('software-history');
    }
    public function historySoftwareTable(){
        $data = CostReport::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        $user_code = Auth::user()->user_code;
        return view('software-history-table', compact('data', 'user_code'));
    }
    public function historySoftwareDelete(Request $request){
        $ids = $request->ids;
        $ids = explode(',', $ids);
        CostReport::whereIn('id', $ids)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return response()->json(['status' => true]);
    }
}
