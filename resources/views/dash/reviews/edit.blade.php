@extends('dash.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Review</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.home') }}"><svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Details</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reviews.update', $review->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ old('name', $review->name) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" class="form-control" name="job_title"
                                        value="{{ old('job_title', $review->job_title) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Rating (1-5) <span class="text-danger">*</span></label>
                                    <select name="rating" class="form-control" required>
                                        @foreach ([5, 4, 3, 2, 1] as $r)
                                            <option value="{{ $r }}"
                                                {{ $review->rating == $r ? 'selected' : '' }}>{{ $r }} Stars
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    @if ($review->getFirstMediaUrl('image'))
                                        <div class="mt-2">
                                            <img src="{{ $review->getFirstMediaUrl('image') }}" width="100"
                                                class="rounded">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Review <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="review" name="review" rows="4" required>{{ old('review', $review->review) }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                            {{ $review->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
