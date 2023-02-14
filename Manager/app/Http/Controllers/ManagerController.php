<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            $data = User::where('role', 'company')->where('status', $status)->where(function ($query) use ($contact) {
                $query->where('contact', 'like', '%' . $contact . '%')->orWhere('name', 'like', '%' . $contact . '%');
            })->get();
        }
        else{
            $data = User::where('role', 'company')->where(function ($query) use ($contact) {
                $query->where('contact', 'like', '%' . $contact . '%')->orWhere('name', 'like', '%' . $contact . '%');
            })->get();
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

    public function manageClient(){
        return view('client-manage');
    }
    public function tableClient(Request $request){
        $status = $request->status;
        $contact = $request->contact;
        $type = $request->type;
        if (isset($status)){
            if(isset($type)){
                $data = User::where('role', 'client')->where('status', $status)->where('type', $type)->where(function ($query) use ($contact) {
                    $query->where('contact', 'like', '%' . $contact . '%')->orWhere('name', 'like', '%' . $contact . '%');
                })->get();
            }
            else{
                $data = User::where('role', 'client')->where('status', $status)->where(function ($query) use ($contact) {
                    $query->where('contact', 'like', '%' . $contact . '%')->orWhere('name', 'like', '%' . $contact . '%');
                })->get();
            }
        }
        else{
            if(isset($type)){
                $data = User::where('role', 'client')->where('type', $type)->where(function ($query) use ($contact) {
                    $query->where('contact', 'like', '%' . $contact . '%')->orWhere('name', 'like', '%' . $contact . '%');
                })->get();
            }
            else{
                $data = User::where('role', 'client')->where(function ($query) use ($contact) {
                    $query->where('contact', 'like', '%' . $contact . '%')->orWhere('name', 'like', '%' . $contact . '%');
                })->get();
            }
        }

        return view('client-table', compact('data'));
    }
    public function addClient(){
//        $ex = true;
//        $code = 0;
//        while($ex){
//            $code = rand(100000, 999999);
//            $c_user = User::where('user_code', $code)->first();
//            if(!isset($c_user)) {
//                $ex = false;
//            }
//        }
        return view('client-add');
    }
    public function editClient($id){
        $user = User::find($id);
        return view('client-add', compact('user'));
    }
    public function saveClient(Request $request){
        $id = $request->id;
        if(!isset($id)){
            $data = [
                'role' => 'client',
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
            $user = User::create($data);
            $user->givePermissionTo('client');
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
            User::find($id)->update($data);
        }
        return response()->json(['status' => true]);
    }
    public function deleteClient(Request $request){
        $id = $request->id;
//        $user = User::find($id);
//        $parent_id = $user->parent_id;
//        User::where('parent_id', $parent_id)->delete();
        User::where('id', $id)->delete();
        return response()->json(['status' => true]);
    }
}
