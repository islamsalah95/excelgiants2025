    <section id="reviews">
        <div class="container">
            <div class="section-title">
                <h2>آراء عملائنا</h2>
                <p>ماذا يقول عملاؤنا عن خدماتنا وبرامجنا</p>
            </div>
            <div class="row g-4">
                @foreach ($reviews as $review)
                    <div class="col-md-6">
                        <div class="review-card">
                            <div class="d-flex text-warning mb-3">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <i class="fa-regular fa-star"></i>
                                @endfor
                            </div>
                            <p class="review-text">
                                "{!! strip_tags($review->review) !!}"
                            </p>
                            <div class="reviewer-info">
                                @if ($review->getFirstMediaUrl('image'))
                                    <img src="{{ $review->getFirstMediaUrl('image') }}" alt="{{ $review->name }}"
                                        class="reviewer-img" />
                                @else
                                    <img src="https://via.placeholder.com/150" alt="User" class="reviewer-img" />
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $review->name }}</h6>
                                    @if ($review->job_title)
                                        <small class="text-muted">{{ $review->job_title }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
