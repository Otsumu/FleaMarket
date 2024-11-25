<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Review;

class ItemController extends Controller
{
    public function index() {
        $items = Item::all();
        return view('item.index',compact('items'));
    }

    public function detail($item_id) {
        $item = Item::findOrFail($item_id);
        $reviews = Review::where('item_id', $item_id)->with('user')->get();
        $commentsCount = $reviews->count();

        $user = Auth::user();
        $userName = $user ? $user->name : '';
        $userImage = $user && $user->image ? asset('storage/images/' . $user->image) : asset('images/default-profile.png');

        return view('item.detail', compact('item', 'reviews', 'commentsCount', 'userName', 'userImage'));
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
