@extends('layout.admin', ['title' => 'Редактирование отзыва'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Редактировать отзыв</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.review.update', ['review' => $review->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="content">Отзыв</label>
                        <textarea name="content" id="content" rows="5" class="form-control">{{ $review->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating">Рейтинг</label>
                        <select name="rating" id="rating" class="form-control">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
