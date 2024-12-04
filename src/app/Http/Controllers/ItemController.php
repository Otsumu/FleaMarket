<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;

class ItemController extends Controller
{
    public function index() {
        $items = Item::all();
        return view('item.index',compact('items'));
    }

    public function detail($item_id) {
        $item = Item::findOrFail($item_id);
        $favorites = Favorite::where('item_id', $item_id)->get();
        $favoritesCount = $favorites->count();
        $comments = Comment::where('item_id', $item_id)->get();
        $commentsCount = $comments->count();

        $user = Auth::user();
        $userName = $user ? $user->name : '';
        $userImage = $user && $user->image ? asset('storage/images/' . $user->image) : null;

        return view('item.detail', compact('item', 'favorites','favoritesCount','comments', 'commentsCount', 'userName', 'userImage'));
    }

    public function store(CommentRequest $request, $item_id) {
        $validatedData = $request->validated();

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->item_id = $item_id;
        $comment->content = $validatedData['content'];
        $comment->save();

        return redirect()->route('item.detail', $item_id);
    }

    public function search(Request $request) {
        $query = $request->input('query');

        $items = Item::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

        return view('item.index', compact('items'));
    }

    public function showImageUploadForm() {
        return view('item.image_upload');
    }

    public function saveImageFromUrl(Request $request) {
        $imgUrl = $request->input('img_url');
        $response = Http::get($imgUrl);

        if ($response->successful() && strpos($response->header('Content-Type'), 'image/') === 0) {
            $fileName = basename($imgUrl);
            try {
                Storage::disk('public')->put("images/{$fileName}", $response->body());
                return response()->json(['message' => '画像を保存しました']);
            } catch (\Exception $e) {
                return response()->json(['error' => '画像の保存に失敗しました: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => '無効な画像URLまたは画像の取得に失敗しました。'], 400);
    }

    public function sell() {
        return view('item.sell');
    }

    public function purchase($item_id) {
        $item = Item::firstOrNew(['id' => $item_id]);
        return view('item.purchase', compact('item'));
    }
}
