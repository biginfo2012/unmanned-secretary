<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountKeyword;
use App\Models\AccountType;
use App\Models\TaxType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function manageCompany(){
        return view('company-manage');
    }
    public function tableCompany(Request $request){
        $status = $request->status;
        $contact = $request->contact;
        if (isset($status)){
            $data = User::where('role', 'company')->where('status', $status)->where('contact', 'like', '%' . $contact . '%')->orderBy('created_at', 'desc')->get();
        }
        else{
            $data = User::where('role', 'company')->where('contact', 'like', '%' . $contact . '%')->orderBy('created_at', 'desc')->get();
        }

        return view('company-table', compact('data'));
    }
    public function addCompany(){
        $ex = true;
        $code = 0;
        while($ex){
            $code = rand(100000, 999999);
            $c_user = User::where('user_code', $code)->first();
            if(!isset($c_user)) {
                $ex = false;
            }
        }
        return view('company-add', compact('code'));
    }
    public function editCompany($id){
        $user = User::find($id);
        return view('company-add', compact('user'));
    }
    public function changeStatusCompany(Request $request)
    {
        $status = $request->status;
        $user_id = $request->user_id;
        User::where('id', $user_id)->update(['status' => $status]);
        return response()->json(['status' => true]);
    }
    public function saveCompany(Request $request){
        $id = $request->id;
        if(!isset($id)){
            $data = [
                'role' => 'company',
                'user_code' => $request->user_code,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'post_code' => $request->post_code,
                'address' => $request->address,
                'contact' => $request->contact,
                'charge' => $request->charge,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'plan_id' => $request->plan,
                'represent' => $request->represent
            ];
            $user = User::create($data);
            $user->givePermissionTo('company');
        }
        else{
            if(isset($request->password)){
                $data = [
                    'user_code' => $request->user_code,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'contact' => $request->contact,
                    'charge' => $request->charge,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'plan_id' => $request->plan,
                    'represent' => $request->represent
                ];
            }
            else{
                $data = [
                    'user_code' => $request->user_code,
                    'name' => $request->name,
                    'email' => $request->email,
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'contact' => $request->contact,
                    'charge' => $request->charge,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'plan_id' => $request->plan,
                    'represent' => $request->represent
                ];
            }
            User::find($id)->update($data);
            User::where('parent_id', $id)->update(['status' => $request->status]);
        }
        return response()->json(['status' => true]);
    }
    public function deleteCompany(Request $request){
        $id = $request->id;
        //User::where('parent_id', $id)->delete();
        User::where('id', $id)->delete();
        return response()->json(['status' => true]);
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
        $type_id = Auth::user()->account_type;
        if(isset($subject)){
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')
                        ->where('subject', 'like', '%' . $subject . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->where('user_id', $user_id)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')
                        ->where('subject', 'like', '%' . $subject . '%')->where('user_id', $user_id)->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('subject', 'like', '%' . $subject . '%')
                        ->where('keyword', 'like', '%' . $keyword . '%')->where('user_id', $user_id)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('subject', 'like', '%' . $subject . '%')
                        ->where('user_id', $user_id)->get();
                }
            }
        }
        else{
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->where('user_id', $user_id)->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('code', 'like', '%' . $code . '%')->where('user_id', $user_id)
                        ->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('keyword', 'like', '%' . $keyword . '%')->where('user_id', $user_id)
                        ->get();
                }
                else{
                    $data = Account::with('tax', 'keyword')->where('type_id', $type_id)->where('user_id', $user_id)->get();
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
}
