<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Forum;
use App\Models\Forumposts;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ForumpostsController extends Controller
{
    function inputHandler(Request $req)
    {
        $forumpost=new Forumposts();
        $forumpost->commentcontent=$req->commentcontent;
        $forumpost->ForumID=(int)$req->ForumID;
        $forumpost->username=$req->username;
        $time=now();
        $forumpost->CreatedAt=$time;
        // $forumpost->userid=$req->userid;
        $forumpost->customerid =  Auth::id();
        $forumpost->save();
        // Alert::success('Berhasil 🎉', 'Anda telah berhasil Berkomentar');
        return redirect("/forumpost/".$req->ForumID);
    }

    function ReturnView(String $forumID){
        if(null!==$forumID){
            $currentforum=Forum::where('ForumID',(integer)$forumID)->get();
            $forumposts=Forumposts::where('ForumID',(integer)$forumID)->get();
            $forumcreator=Customer::findOrFail($currentforum[0]->ForumCreator);

            return view('forum.pageforum',['forum'=>$currentforum,'forumid'=>$forumID,'creator'=>$forumcreator,'forumposts'=>$forumposts]);
        }
    }
}
