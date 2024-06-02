<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function edit(Review $review)
    {
        return view('admin.review.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $review->update([
            'content' => $request->input('content'),
            'rating' => $request->input('rating')
        ]);

        return redirect()->route('admin.product.show', ['product' => $review->product_id])->with('success', 'Отзыв успешно обновлен');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.product.show', ['product' => $review->product_id])->with('success', 'Отзыв успешно удален');
    }
}
