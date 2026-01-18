@extends('web.layouts.main')

@section('content')

    <!-- ================= FILTER BAR ================= -->
    <div class="filter-bar mb-3">
        <div class="container d-flex justify-content-center flex-wrap gap-2">
            <button class="filter-btn active">
                <i class="fa-solid fa-house"></i> الرئيسية
            </button>
        </div>
    </div>

    <!-- ================= ADVANCED FILTERS ================= -->
    <div class="container advanced-filters mb-4">
        <div class="row g-2 align-items-end">

            {{-- CATEGORY --}}
            <div class="col-6 col-md-3">
                <span class="filter-label">التصنيف</span>
                <select class="custom-select" onchange="updateQuery({ category: this.value })">
                    <option value="">الكل</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- YEAR --}}
            <div class="col-6 col-md-3">
                <span class="filter-label">السنة</span>
                <select class="custom-select" onchange="updateQuery({ year: this.value })">
                    <option value="">بدون اختيار</option>
                    @foreach ($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ORDER --}}
            <div class="col-6 col-md-3">
                <span class="filter-label">الترتيب</span>
                <select class="custom-select" onchange="updateQuery({ order: this.value })">
                    <option value="">ترتيب حسب</option>
                    <option value="latest" {{ request('order') == 'latest' ? 'selected' : '' }}>
                        الأحدث
                    </option>
                    <option value="rating" {{ request('order') == 'rating' ? 'selected' : '' }}>
                        الأعلى تقييماً
                    </option>
                    <option value="price_asc" {{ request('order') == 'price_asc' ? 'selected' : '' }}>
                        السعر من الأقل للأعلى
                    </option>
                    <option value="price_desc" {{ request('order') == 'price_desc' ? 'selected' : '' }}>
                        السعر من الأعلى للأقل
                    </option>
                </select>
            </div>

            <div class="col-6 col-md-2">
                <span class="filter-label">عرض</span>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-dark w-100" id="btnListView">
                        <i class="fa-solid fa-list"></i>
                    </button>
                    <button class="btn btn-sm btn-dark w-100 active" id="btnGridView">
                        <i class="fa-solid fa-border-all"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= CONTENT ================= -->
    <main class="container my-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-black">
                <i class="fa-solid fa-box"></i> المنتجات
            </h4>
        </div>

        {{-- PRODUCTS GRID --}}
        <div class="row row-cols-2 row-cols-md-4 g-3">
            @forelse ($products as $product)
                <div class="col">
                    <div class="content-card h-100">

                        <div class="card-img-container">
                            <img src="{{ $product->getFirstMediaUrl('main_image') }}" alt="{{ $product->name }}">
                        </div>

                        <div class="card-body p-2 text-center">
                            <h6 class="mb-1">{{ $product->name }}</h6>

                            {{-- RATING --}}
                            <div class="star-rating mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($product->rating))
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @elseif ($i - 0.5 <= $product->rating)
                                        <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                    @else
                                        <i class="fa-regular fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>

                            {{-- PRICE --}}
                            @if ($product->is_free)
                                <span class="badge bg-success">مجاني</span>
                            @elseif ($product->discount > 0)
                                <span class="badge bg-danger">
                                    {{ number_format($product->discounted_price, 2) }}$
                                </span>
                            @else
                                <span class="badge bg-dark">
                                    {{ number_format($product->price, 2) }}$
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    لا توجد منتجات
                </div>
            @endforelse
        </div>

        <!-- ================= PAGINATION ================= -->
        <div class="mt-4">
            {{ $products->links('pagination.products') }}
        </div>

    </main>

@endsection

{{-- ================= JS ================= --}}
@push('js')
    <script>
        function updateQuery(newParams) {
            const params = new URLSearchParams(window.location.search);

            Object.keys(newParams).forEach(key => {
                if (newParams[key]) {
                    params.set(key, newParams[key]);
                } else {
                    params.delete(key);
                }
            });

            params.delete('page'); // reset pagination on filter change

            window.location.search = params.toString();
        }
    </script>
@endpush
