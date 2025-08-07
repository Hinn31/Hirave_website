
@forelse ($reviews as $review)
    <div class="review-item">
        <img src="{{ asset($review->user->avatar ?? 'images/avatars/default.jpg') }}" alt="Avatar">
        <div class="review-info">
            <strong>{{ $review->user->fullname ?? 'Anonymous' }}</strong>
            <small>{{ $review->reviewDate->format('M d, Y') }}</small>
            <p class="review-text">{{$review->comment}}</p>
        </div>
    </div>
@empty
    <p class="review-notification" style="display: flex; justify-content: center;">No reviews yet.</p>
@endforelse
