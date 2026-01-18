@extends('dash.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Create Review</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.home') }}"><svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ old('name') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" class="form-control" name="job_title"
                                        value="{{ old('job_title') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Rating (1-5) <span class="text-danger">*</span></label>
                                    <select name="rating" class="form-control" required>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Review <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="review" name="review" rows="4" required>{{ old('review') }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                            checked>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
