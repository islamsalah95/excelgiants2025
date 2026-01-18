    <section id="works" style="background-color: var(--section-alt-bg)">
        <div class="container">
            <div class="section-title">
                <h2>اعمالنا</h2>
                <p>نظرة سريعة على بعض المشاريع والأنظمة التي قمنا بتطويرها</p>
            </div>
            <div class="row g-3">
                @foreach ($worksSections as $section)
                    <div class="col-md-4 col-sm-6">
                        <div class="work-item">
                            @if ($section->getFirstMediaUrl('image'))
                                <img src="{{ $section->getFirstMediaUrl('image') }}" alt="{{ $section->title }}" />
                            @else
                                <img src="https://via.placeholder.com/500" alt="Placeholder" />
                            @endif
                            <div class="work-overlay">
                                <h5 class="text-white">{{ $section->title }}</h5>
                                <p class="text-white small">{!! Str::limit(strip_tags($section->description), 50) !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
