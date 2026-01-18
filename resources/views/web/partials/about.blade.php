    <section id="about" style="background-color: var(--section-alt-bg)">
        <div class="container">
            @foreach ($aboutSections as $section)
                <div class="row align-items-center mb-5">
                    @if ($loop->iteration % 2 != 0)
                        {{-- Odd rows: Image Left, Text Right (Default) --}}
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="about-img">
                                @if ($section->getFirstMediaUrl('image'))
                                    <img src="{{ $section->getFirstMediaUrl('image') }}" class="img-fluid rounded shadow"
                                        alt="{{ $section->title }}" />
                                @else
                                    <img src="https://via.placeholder.com/800x600" class="img-fluid rounded shadow"
                                        alt="Placeholder" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-text">
                                <h3>{{ $section->title }}</h3>
                                <p>
                                    {!! $section->description !!}
                                </p>
                                @if ($section->button_text)
                                    <button class="btn btn-warning text-white mt-2">
                                        {{ $section->button_text }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Even rows: Text Left, Image Right --}}
                        <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                            <div class="about-img">
                                @if ($section->getFirstMediaUrl('image'))
                                    <img src="{{ $section->getFirstMediaUrl('image') }}"
                                        class="img-fluid rounded shadow" alt="{{ $section->title }}" />
                                @else
                                    <img src="https://via.placeholder.com/800x600" class="img-fluid rounded shadow"
                                        alt="Placeholder" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 order-md-1">
                            <div class="about-text">
                                <h3>{{ $section->title }}</h3>
                                <p>
                                    {!! nl2br(e($section->description)) !!}
                                </p>
                                @if ($section->button_text)
                                    <button class="btn btn-warning text-white mt-2">
                                        {{ $section->button_text }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            @if ($aboutSections->isEmpty())
                <div class="text-center">
                    <p>No about sections available.</p>
                </div>
            @endif
        </div>
    </section>
