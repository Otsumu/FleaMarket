<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index() {
        $user = Auth::user();
        $items = Item::when($user, function ($query) use ($user) {
            return $query->where('user_id', '!=', $user->id);
        })->get();

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

        $existingComment = Comment::where('user_id', Auth::id())
                            ->where('item_id', $item_id)
                            ->first();

        if ($existingComment) {
            return redirect()->route('item.detail', $item_id)
                        ->with('error', 'このアイテムにはすでにコメントを投稿しています');
        }

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->item_id = $item_id;
        $comment->content = $validatedData['content'];
        $comment->save();

        $item = Item::findOrFail($item_id);
        $item->comments_count = $item->comments()->count();
        $item->save();

        return redirect()->route('item.detail', $item_id)->with('success','コメントが投稿されました！');
    }

    public function toggleFavorite($itemId) {
        try {
            $user = auth()->user();
            $item = Item::findOrFail($itemId);
            $item->favorites()->toggle($user->id);
            $count = $item->favorites()->count();
            return response()->json([
                'status' => 'success',
                'favorite_count' => $count
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Favorite toggle error:', [
                'error' => $e->getMessage(),
                'item_id' => $itemId
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update favorite'
            ], 500);
        }
    }

    public function getFavorites() {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $favoriteItems = $user->favorites()->get();

            \Log::info('Favorite items:', $favoriteItems->toArray());

            return response()->json([
                'items' => $favoriteItems,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching favorites:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error fetching favorites',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request) {
        $query = $request->input('query');

        session(['search_query' => $query ]);

        $items = Item::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

        return view('item.index', compact('items'));
    }

    public function sell() {
        $item = Item::find(1);
        return view('item.sell', compact('item'));
    }

    public function storeItem(ExhibitionRequest $request) {
        $validatedData = $request->validated();

        $path = '';

        if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
            $path = $request->file('img_url')->store('images', 'public');
        }

        $item = Item::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'img_url' => $path,
            'category' => $validatedData['category'],
            'condition' => $validatedData['condition'],
            'price' => $validatedData['price'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('item.index')->with('success', '商品が登録されました！')->with('item', $item);
    }

    public function showPurchaseForm($item_id) {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        return view('item.purchase', compact('item','user'));
    }

    public function purchase(PurchaseRequest $request, $item_id) {
        $item = Item::findOrFail($item_id);
        if ($item->status === 'soldout') {
            return redirect()
                ->route('item.detail', $item->id)
                ->with('error', 'この商品はすでに売り切れです。');
        }
        try {
            Purchase::create([
                'user_id' => auth()->id(),
                'item_id' => $item->id,
                'payment_method' => $request->payment_method,
            ]);

            $item->update(['status' => 'soldout']);

            return redirect()
                ->route('item.detail', $item->id)
                ->with('success', '購入が完了しました！');
        } catch (\Exception $e) {
            \Log::error('Purchase failed:', ['error' => $e->getMessage()]);
            return redirect()
                ->route('item.detail', $item->id)
                ->with('error', '購入処理に失敗しました。');
        }
    }
}
