<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ConversationController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('Therapist')){
            $conversations = DB::table('conversations')
            ->orwhere('user_id',auth()->user()->id)
            ->orWhere('to_user_id',auth()->user()->id)
            ->latest()->get();
        }
        else{
            $conversations = DB::table('conversations')->latest()->get();
        }
        

        return view('superAdmin.messages.index', compact('conversations'));
    }

    public function show($user_id)
    {   
        $loguserid=auth()->user()->id;

        $convs = Conversation::where(function ($query) use($loguserid,$user_id) {

            $query->orwhere(function ($query2) use($loguserid,$user_id) {

                $query2->where('user_id', '=', $loguserid)
                  ->Where('to_user_id', '=', $user_id);
            });

            $query->orwhere(function ($query3) use($loguserid,$user_id) {

            $query3->where('to_user_id', '=', $loguserid)
                  ->Where('user_id', '=', $user_id);

            });
            
        })->get();

        Conversation::where(['user_id' => $user_id])->update(['checked' => 1]);

        $user = User::find($user_id);
        return response()->json([
            'view' => view('superAdmin.messages.partials.conversations', compact('convs', 'user'))->render()
        ]);
    }

    public function view($user_id)
    {
        $loguserid=auth()->user()->id;

        $convs = Conversation::where(function ($query) use($loguserid,$user_id) {

            $query->orwhere(function ($query2) use($loguserid,$user_id) {

                $query2->where('user_id', '=', $loguserid)
                  ->Where('to_user_id', '=', $user_id);
            });

            $query->orwhere(function ($query3) use($loguserid,$user_id) {

            $query3->where('to_user_id', '=', $loguserid)
                  ->Where('user_id', '=', $user_id);

            });
            
        })->get();

        Conversation::where(['user_id' => $user_id])->update(['checked' => 1]);

        $user = User::find($user_id);
        return response()->json([
            'view' => view('superAdmin.messages.partials.conversations', compact('convs', 'user'))->render()
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->reply ) {
            return response()->json([], 403);
        }

        //if image is given
        if ($request->images) {
            $id_img_names = [];
            foreach ($request->images as $img) {
                $image = (new CustomController)->imageUpload($img);
                $image_url = $image;
                array_push($id_img_names, $image_url);
            }
            $images = $id_img_names;
        } else {
            $images = null;
        }

        DB::table('conversations')->insert([
            'user_id' =>auth()->user()->id,
            'to_user_id' => $request->id,
            'message' => $request->reply,
            'image' => json_encode($images),
            'checked' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user_id= $request->id;

        $loguserid=auth()->user()->id;

        $convs = Conversation::where(function ($query) use($loguserid,$user_id) {

            $query->orwhere(function ($query2) use($loguserid,$user_id) {

                $query2->where('user_id', '=', $loguserid)
                  ->Where('to_user_id', '=', $user_id);
            });

            $query->orwhere(function ($query3) use($loguserid,$user_id) {

            $query3->where('to_user_id', '=', $loguserid)
                  ->Where('user_id', '=', $user_id);

            });
            
        })->get();

        $user = User::find($request->id);

        //send push notification
        $fcm_token = $user->cm_firebase_token;
        $data = [
            'title' => 'New message arrived',
            'description' => Str::limit($request->reply??'', 500),
            'order_id' => '',
            'image' => '',
        ];
        

        return response()->json([
            'view' => view('superAdmin.messages.partials.conversations', compact('convs', 'user'))->render()
        ]);
    }

    public function update_fcm_token(Request $request)
    {
        try {
            $admin = Admin::find(auth('admin')->id());
            $admin->fcm_token = $request->fcm_token;
            $admin->save();

            return response()->json(['message' => 'FCM token updated successfully.'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'FCM token updated failed.'], 200);
        }
    }

    public function getconversations(Request $request)
    {
        $conversations = DB::table('conversations')->latest()->get();
        return response()->json([
            'conversation_sidebar' => view('admin-views.messages.partials._list', compact('conversations'))->render(),
        ]);
    }

    public function get_firebase_config(Request $request)
    {
        
    }
}
