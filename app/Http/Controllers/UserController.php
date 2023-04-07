<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Jobs\SendAccountCredential;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles','staff','staff.department','staff.position'])->paginate(10);

        $staffs = Staff::with(['department','position'])->get();

        $roles = Role::select('id','name')->get();

        // For Select2 Plugin
        view()->share(['select2' => true]);

        return view('pages.users.index',compact('users','staffs','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $str = Str::random(8);
        $password = Hash::make($str);

        $request->request->add(['password' => $password,'active' => 1]);

        $user = User::create($request->all());

        $role = Role::findById($request->role_id);

        $user->assignRole([$role->id]);

        try {
            $credentials = [
                'username' => $request->username,
                'password' => $str,
            ];

            SendAccountCredential::dispatch($user->staff->email,$credentials);

            return response()->json(['success' => 'Succesfully Added']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Email Could not send!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $role = Role::findById($request->validated()['role_id']);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole([$role->id]);

        return response()->json(['success' => 'Succesfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id',$request->ids)->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }
}
