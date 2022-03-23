<?php

Namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //direct user list page
    public function userList(){
        $userData = User::where( 'role' , 'user')->paginate(5);
        return view('admin.user.userList')->with(['user' => $userData]);
    }

    //direct admin list
    public function adminList(){
        $userData = User::where( 'role' , 'admin')->paginate(5);
        return view('admin.user.adminList')->with(['admin' => $userData]);
    }

    // user account search
    public function userSearch(Request $request){
        $response = $this->search('user' , $request);
        return view('admin.user.userList')->with(['user'=>$searchData]);
    }

      //admin account search
      public function adminSearch(Request $request){
        $response =  $this->search('admin' , $request) ;
        return view('admin.user.adminList')->with(['admin' => $response]);
    }

    //data searching (ဘုံရှာခြင်း)
    private function search( $role , $request){
        $searchData = User::where('role' , $role)
                        ->where(function ($query) use ($request) {
                            $query->orwhere('name' , 'like' , '%' .$request->searchData.'%')
                            ->orwhere('email' , 'like', '%' .$request->searchData.'%')
                            ->orwhere('phone' , 'like',  '%' .$request->searchData .'%')
                            ->orwhere('address' , 'like' , '%'   .$request->searchData.'%');
                        })
                        ->paginate(5);
            $searchData->appends($request->all());
            return $searchData ;
    }

    //user data delete
    public function userDelete($id){
        User::where('id' , $id)->delete();
        return back()->with(['deleteSuccess' => 'User Datas deleted!!']);
    }
}
