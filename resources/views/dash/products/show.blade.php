@extends('dash.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Product Profile</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dash.home') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Main Product Info -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>{{ $product->name }}</h4>
                            <div>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Main Image -->
                        @if ($product->getFirstMediaUrl('main_image'))
                            <div class="mb-4">
                                <img src="{{ $product->getFirstMediaUrl('main_image') }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p>{{ $product->description ?? 'No description available.' }}</p>
                        </div>

                        <!-- Gallery -->
                        @if ($product->getMedia('gallery')->count() > 0)
                            <div class="mb-4">
                                <h5>Photo Gallery</h5>
                                <div class="row g-2">
                                    @foreach ($product->getMedia('gallery') as $media)
                                        <div class="col-md-3 col-sm-4 col-6">
                                            <img src="{{ $media->getUrl() }}" alt="Gallery" class="img-fluid rounded"
                                                style="height: 150px; width: 100%; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Tags -->
                        @if ($product->tags->count() > 0)
                            <div class="mb-4">
                                <h5>Tags</h5>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($product->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Download Section -->
                        @if ($product->is_program && ($product->getFirstMedia('downloads') || $product->download_link))
                            <div class="mb-4">
                                <h5>Downloads</h5>
                                @if ($product->getFirstMedia('downloads'))
                                    <div class="mb-2">
                                        <a href="{{ $product->getFirstMediaUrl('downloads') }}" class="btn btn-success"
                                            download>
                                            <i class="fa fa-download"></i> Download File
                                            ({{ $product->getFirstMedia('downloads')->file_name }})
                                        </a>
                                    </div>
                                @endif
                                @if ($product->download_link)
                                    <div>
                                        <a href="{{ $product->download_link }}" class="btn btn-info" target="_blank">
                                            <i class="fa fa-link"></i> Download Link
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Product Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">Category:</th>
                                    <td>
                                        <span class="badge badge-info">{{ $product->category->name ?? 'N/A' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>
                                        @if ($product->is_free)
                                            <span class="badge badge-success">Free</span>
                                        @else
                                            <strong>${{ number_format($product->price, 2) }}</strong>
                                        @endif
                                    </td>
                                </tr>
                                @if ($product->discount > 0)
                                    <tr>
                                        <th>Discount:</th>
                                        <td>
                                            <span class="badge badge-warning">{{ $product->discount }}%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discounted Price:</th>
                                        <td>
                                            <strong
                                                class="text-success">${{ number_format($product->discounted_price, 2) }}</strong>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Rating:</th>
                                    <td>
                                        <span class="badge badge-info">{{ $product->rating }}/5 ⭐</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Type:</th>
                                    <td>
                                        @if ($product->is_program)
                                            <span class="badge badge-secondary">Program</span>
                                        @else
                                            <span class="badge badge-secondary">Product</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if ($product->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $product->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
