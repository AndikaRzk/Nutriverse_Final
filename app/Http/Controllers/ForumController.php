<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Forumposts;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ForumController extends Controller
{
    function returnview(String $forumid){
        if(isset($forumid)){
            $newid=(int)$forumid;
            $forumposts=Forumposts::where('ForumID',$newid)->get();
            $forum=Forum::where('ForumID',$newid)->get();
            return view('forum.pageforum',['forumposts'=>$forumposts,'forumid'=>$newid,'forum'=>$forum]);
        }
        else{
            return redirect()->back();
        }
    }

    function input_handler(Request $req) {
        $validator = $req->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required'],
            'ForumImage' => ['nullable', 'file', 'image'],
        ]);

        $forum = new Forum;
        $forum->ForumTitle = $req->title;
        $forum->ForumContent = $req->content;
        $forum->ForumCreator = Auth::id();

        // Untuk tanggal CreatedAt, simpan format Y-m-d (karena kolomnya date)
        $forum->CreatedAt = now()->toDateString();

        // Handle upload gambar
        if ($req->hasFile('ForumImage')) {
            $file = $req->file('ForumImage');
            $extension = $file->getClientOriginalExtension();

            // Buat nama file aman
            $newtitle = preg_replace('/[^A-Za-z0-9]/', 's', $req->title);
            $time = now()->format('YmdHis'); // contoh: 20250526143545
            $renamed = $newtitle . $time . '.' . $extension;

            // Simpan file ke folder 'forumimages' di storage/app/public/forumimages
            $file->storeAs('forumimages', $renamed);

            // Simpan nama file di database
            $forum->ForumImage = $renamed;
        } else {
            $forum->ForumImage = null;
        }

        $forum->save();

        $value = $forum->ForumID;

        return redirect("/forumpost/$value");
    }

    function generalforumview(){
        $allforums = Forum::with('customer') // Eager load the customer relationship
                           ->orderBy('created_at', 'DESC')
                           ->paginate(10);
        return view('forum.allforums',['forums'=>$allforums]);
    }
    function deleteforum(String $forumid){
        if(isset($forumid)){
            $newid=(int)$forumid;
            $selected=Forum::where("ForumID",$newid)->first();
            Storage::delete('forumimages/'.$selected->ForumImage);
            $selected->delete();
            //  Alert::success('Hapus', 'Data telah berhasil dihapus!');
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        // Ambil query pencarian dari request
        $query = $request->Query;

        // Buat query builder dengan kondisi pencarian
        $forums = Forum::where('ForumTitle', 'like', "%{$query}%")
        ->orWhere('ForumContent', 'like', "%{$query}%")
        ->orderBy('CreatedAt', 'desc')
        ->paginate(5)
        ->appends(request()->all());

        // Kirim data ke view
        return view('forum.allforums', compact('forums'));
    }
}
