<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
        }
        return response()->json(['status' => true]);
    }
    public function deleteCompany(Request $request){
        $id = $request->id;
        User::where('parent_id', $id)->delete();
        User::where('id', $id)->delete();
        return response()->json(['status' => true]);
    }

    public function manageAccount(){
        return view('account-manage');
    }
    public function tableAccount(Request $request){
        $status = $request->status;
        $contact = $request->contact;
        $type = $request->type;
        $user_id = Auth::user()->id;
        if (isset($status)){
            if(isset($type)){
                $data = Account::where('user_id', $user_id)->where('status', $status)->where('type', $type)->where('contact', 'like', '%' . $contact . '%')->orderBy('created_at', 'desc')->get();
            }
            else{
                $data = Account::where('user_id', $user_id)->where('status', $status)->where('contact', 'like', '%' . $contact . '%')->orderBy('created_at', 'desc')->get();
            }
        }
        else{
            if(isset($type)){
                $data = Account::where('user_id', $user_id)->where('type', $type)->where('contact', 'like', '%' . $contact . '%')->orderBy('created_at', 'desc')->get();
            }
            else{
                $data = Account::where('user_id', $user_id)->where('contact', 'like', '%' . $contact . '%')->orderBy('created_at', 'desc')->get();
            }
        }

        return view('account-table', compact('data'));
    }
    public function addAccount(){
        return view('account-add');
    }
    public function editAccount($id){
        $account = Account::find($id);
        return view('account-add', compact('account'));
    }
    public function saveAccount(Request $request){
        $id = $request->id;
        if(!isset($id)){
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'post_code' => $request->post_code,
                'address' => $request->address,
                'contact' => $request->contact,
                'charge' => $request->charge,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'type' => $request->type,
                'represent' => $request->represent,
                'user_id' => Auth::user()->id
            ];
            Account::create($data);
        }
        else{
            if(isset($request->password)){
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'contact' => $request->contact,
                    'charge' => $request->charge,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'type' => $request->type,
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
                    'type' => $request->type,
                    'represent' => $request->represent
                ];
            }
            Account::find($id)->update($data);
        }
        return response()->json(['status' => true]);
    }
    public function deleteAccount(Request $request){
        $id = $request->id;
        Account::where('id', $id)->delete();
        return response()->json(['status' => true]);
    }
}
