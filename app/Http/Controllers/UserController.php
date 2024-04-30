<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'grant_role' => 'required',
            // 'phone' =>  $request->phone != null ? 'unique:users|max:100' : '',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->grant_role = $request->grant_role;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            // 'phone' => 'sometimes|unique:users, phone,'.$id,
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->grant_role = $request->grant_role;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->phone = $request->phone;
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.Auth::user()->id,
            // 'phone' => 'sometimes|unique:users,phone,'.Auth::user()->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);
        // dd($request->all());
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $name = time().'.'.$image->getClientOriginalExtension();
            //save image to public folder
            $destinationPath = public_path('/assets/images/profile');
            $image->move($destinationPath, $name);
            //check if there is an old image
            if (!empty(Auth::user()->profile_picture)) {
                //delete old image
                $old_image = public_path('/assets/images/profile/'.Auth::user()->profile_picture);
                if (file_exists($old_image)) {
                    unlink($old_image);
                }

            }
            $user->profile_picture= $name;
        }
        $user->save();
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
      
      $this->validate($request, [
        'old_password' => 'required',
        'new_password' => 'required|min:6',
      ]);
  
      $user = User::find(Auth::user()->id);
      if (Hash::check($request->old_password, $user->password)) {
        # code...
        $user->password = Hash::make($request->new_password);
        $user->save();
        //return redirect()->back()->with('success', 'Password changed successfully.');
        return response()->json(['success' => 'Password changed successfully.']);
      } else {
        return response()->json(['error' => 'Old password is incorrect.']);
      }
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
