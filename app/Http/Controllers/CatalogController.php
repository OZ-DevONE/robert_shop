<?php

namespace App\Http\Controllers;

use App\Helpers\ProductFilter;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller {
    public function index() {
        $roots = Category::where('parent_id', 0)->get();
        $brands = Brand::popular();
        return view('catalog.index', compact('roots', 'brands'));
    }

    public function category(Category $category, ProductFilter $filters) {
        $products = Product::categoryProducts($category->id)
            ->filterProducts($filters)
            ->paginate(6)
            ->withQueryString();
        return view('catalog.category', compact('category', 'products'));
    }

    public function brand(Brand $brand, ProductFilter $filters) {
        $products = $brand
            ->products() // возвращает построитель запроса
            ->filterProducts($filters)
            ->paginate(6)
            ->withQueryString();
        return view('catalog.brand', compact('brand', 'products'));
    }

    public function product(Product $product)
    {
        $reviews = Review::where('product_id', $product->id)
                         ->orderBy('created_at', 'desc')
                         ->paginate(2); // Замените 5 на нужное количество отзывов на страницу
        return view('catalog.product', compact('product', 'reviews'));
    }
    

    public function addReview(Request $request, Product $product)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        if (!Auth::check() || !Order::where('user_id', Auth::id())->whereHas('items', function($query) use ($product) {
            $query->where('product_id', $product->id);
        })->exists()) {
            return redirect()->back()->with('error', 'Вы не можете оставить отзыв, так как не купили этот товар.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'content' => $request->input('content'),
            'rating' => $request->input('rating')
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен');
    }

    public function editReviewForm(Review $review)
    {
        $this->authorize('update', $review);
        return view('catalog.edit_review', compact('review'));
    }

    public function editReview(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $review->update([
            'content' => $request->input('content'),
            'rating' => $request->input('rating')
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно обновлен');
    }

    public function deleteReview(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return redirect()->back()->with('success', 'Отзыв успешно удален');
    }

    public function search(Request $request) {
        $search = $request->input('query');
        $query = Product::search($search);
        $products = $query->paginate(6)->withQueryString();
        return view('catalog.search', compact('products', 'search'));
    }
}
