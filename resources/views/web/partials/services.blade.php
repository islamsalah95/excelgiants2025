    <section id="services">
        <div class="container">
            <div class="section-title">
                <h2>خدماتنا</h2>
                <p>نقدم مجموعة واسعة من الخدمات التقنية لتلبية جميع احتياجاتكم</p>
            </div>
            <div class="row g-4">
                @foreach ($servicesSections as $section)
                    <div class="col-md-4">
                        <div class="service-card">
                            <div class="service-icon">
                                @if ($section->getFirstMediaUrl('image'))
                                    <img src="{{ $section->getFirstMediaUrl('image') }}" alt="{{ $section->title }}"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <i class="fa-solid fa-code"></i> {{-- Fallback icon if no image --}}
                                @endif
                            </div>
                            <h4 class="service-title">{{ $section->title }}</h4>
                            <p class="service-desc">
                                {!! $section->description !!}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
