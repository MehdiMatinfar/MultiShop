<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\AddUserNotification;
use App\Notifications\TestNotification;
use App\Providers\AddPostEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Monolog\Logger;
use Illuminate\Support\Facades\Redis;
class AdminUserController extends Controller
{


    public function testredis()
    {


         Redis::set('foo','ilami',10);
        return Redis::get('foo');
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|min:4|string|max:255',
            'email' => 'required|email|string|max:255'
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->is_active = 1;
        $user->save();
        return redirect('/admin/users');

    }

    public function edit($id)
    {
        $user = User::query()->find($id);
        $roles = Role::all();


        return view('admin.users.edit', compact('user', 'roles'));

    }


    public function delete($id)
    {
        $user = User::query()->find($id);
        $user->delete();


        return redirect('admin/users');

    }


    public function index(Request $request)
    {

        $search = $request->search ?? "";
        $limit=0;
        if ($search != "") {
            $users = User::query()->where('name', 'LIKE', "%$search%")->get();
        } else {
            $users = User::query()->paginate(10);

        }


        return view('admin.users.index', compact('users'));
    }

    public function create()
    {



            $users = User::all();
            $roles = Role::all();

            return view('admin.users.create', compact('users', 'roles'));




    }

    public function store(Request $request)
    {



            $this->validate($request,
            ['name' => 'required|max:28',
                'email' => 'required|email',

                'password' => 'required',

            ]);
        $newuser = new User();
        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->password = Hash::make($request->password);
        $newuser->role_id = $request->role;
        $newuser->is_active = 1;


        // $photo = $request->file('photo_id');
        // $name = time();

        // $photo->move('images',$name);
        $newuser->photo_id = "favicon.png";

        if ($newuser->save()) {
            event(new AddPostEvent($newuser));
            //refresh !

            Log::debug('Todo could not be created caused by invalid todo data');
            Log::stack(['slack'])->info("I :( have a bad feeling about this!");

            return redirect('admin/users');

    }
        return redirect('/')->withErrors('You Aren\'t Admin');

    }

    public function testNotification()
    {

        $user = \auth()->user();


       Notification::send($user, new TestNotification());

        echo ' Notification Has Been Sent !';
        die();
    }

    public static function collect()
    {

        $var = collect([1, 2, 3, 4]);
        echo $var->max();
        $n = $var->map(function ($item) {

            return $item * 2;
        });
        $n->all();
    }


}
