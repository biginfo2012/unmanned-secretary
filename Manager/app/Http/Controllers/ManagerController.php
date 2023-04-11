<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
        return view('account-manage');
    }
    public function tableAccount(Request $request){
        $subject = $request->subject;
        $code = $request->code;
        $keyword = $request->keyword;
        $user_id = Auth::user()->id;
        if(isset($subject)){
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('subject', 'like', '%' . $subject . '%')
                        ->where('keyword', 'like', '%' . $keyword . '%')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('subject', 'like', '%' . $subject . '%')
                        ->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax')->where('subject', 'like', '%' . $subject . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('subject', 'like', '%' . $subject . '%')
                        ->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
                }
            }
        }
        else{
            if(isset($code)){
                if(isset($keyword)){
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('keyword', 'like', '%' . $keyword . '%')
                        ->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('code', 'like', '%' . $code . '%')->where('user_id', $user_id)
                        ->orderBy('created_at', 'desc')->get();
                }
            }
            else{
                if(isset($keyword)){
                    $data = Account::with('tax')->where('keyword', 'like', '%' . $keyword . '%')->where('user_id', $user_id)
                        ->orderBy('created_at', 'desc')->get();
                }
                else{
                    $data = Account::with('tax')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
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
}
