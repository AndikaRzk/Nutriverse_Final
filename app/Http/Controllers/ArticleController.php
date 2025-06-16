<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->query('search');

        $articles = Article::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('author', 'like', '%' . $search . '%')
                         ->orWhere('content', 'like', '%' . $search . '%');
        })->paginate(9);

        return view('article.article', compact('articles')); // gunakan 'articles', bukan 'blogs'
    }

    public function index_article($id)
{
    $article = Article::findOrFail($id); // Artikel utama berdasarkan ID

    $articles = Article::where('id', '!=', $id) // Artikel lainnya (bukan yang utama)
                    ->inRandomOrder()
                    ->paginate(3);

    return view('article.article_detail', compact('article', 'articles'));
}

public function input_handler(Request $req)
{
    $req->validate([
        'author' => ['required', 'max:255'],
        'title' => ['required', 'max:255'],
        'content' => ['required'],
        'image' => ['nullable', 'file', 'image', 'max:5120'], // max 5MB
    ]);

    $article = new Article;
    $article->author = $req->author;
    $article->title = $req->title;
    $article->content = $req->content;

    if ($req->hasFile('image')) {
        // Simpan ke folder articles di disk public
        $path = $req->file('image')->store('articles', 'public'); // return: articles/nama-file.jpg
        $article->image = $path; // Simpan path lengkap (articles/...)
    } else {
        $article->image = null;
    }

    $article->save();

    return redirect("/articles/{$article->id}")
        ->with('success', 'Artikel berhasil ditambahkan!');
}



}
