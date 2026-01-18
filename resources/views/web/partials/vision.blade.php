    <section id="vision">
        <div class="container">
            <div class="row g-4">
                @foreach ($visionSections as $section)
                    <div class="col-lg-3 col-sm-6">
                        <a class="vision-card" href="#">
                            <div class="rounded p-4">
                                <div class="icon mb-3">
                                    @if ($section->getFirstMediaUrl('image'))
                                        <img src="{{ $section->getFirstMediaUrl('image') }}" alt="{{ $section->title }}"
                                            style="width: 50px; height: 50px; object-fit: contain;">
                                    @else
                                        <i class="fa-solid fa-eye"></i> {{-- Fallback icon if no image --}}
                                    @endif
                                </div>
                                <h6>{{ $section->title }}</h6>
                                <span>{!! $section->description !!}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
