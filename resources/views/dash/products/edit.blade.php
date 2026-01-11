@extends('dash.layouts.main')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('dash/assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dash/assets/css/vendors/dropzone.css') }}">
    <style>
        .dropzone {
            border: 2px dashed #7366ff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: #f8f9fe;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            cursor: pointer;
        }

        .dropzone.dz-clickable .dz-message {
            cursor: pointer;
            margin: 0;
            font-weight: 600;
            color: #7366ff;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Product</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.home') }}"><svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
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
                        <h4>Product Information</h4>
                    </div>
                    <div class="card-body">
                        <form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $product->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="4">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Main Image</label>
                                        <div class="dropzone" id="mainImageDropzone">
                                            <div class="dz-message">
                                                <i class="fa fa-cloud-upload fa-3x mb-2"></i>
                                                <p>Drop main image here or click to upload</p>
                                            </div>
                                        </div>
                                        <div id="main-image-hidden"></div>
                                        @error('image')
                                            <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Add Gallery Images</label>
                                        <div class="dropzone" id="galleryDropzone">
                                            <div class="dz-message">
                                                <i class="fa fa-images fa-3x mb-2"></i>
                                                <p>Drop gallery images here or click to upload</p>
                                            </div>
                                        </div>
                                        <div id="gallery-hidden"></div>
                                        @error('gallery_images')
                                            <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if ($product->getMedia('gallery')->count() > 0)
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Current Gallery Images</label>
                                        <div id="gallery-preview" class="d-flex gap-2 flex-wrap">
                                            @foreach ($product->getMedia('gallery') as $media)
                                                <div class="position-relative gallery-item" data-id="{{ $media->id }}">
                                                    <img src="{{ $media->getUrl() }}" alt="Gallery"
                                                        style="width: 100px; height: 100px; object-fit: cover;"
                                                        class="rounded border">
                                                    <button type="button"
                                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 delete-media"
                                                        data-id="{{ $media->id }}"
                                                        style="padding: 2px 5px; font-size: 10px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price', $product->price) }}"
                                            step="0.01" min="0">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                            id="discount" name="discount"
                                            value="{{ old('discount', $product->discount) }}" step="0.01"
                                            min="0" max="100">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating</label>
                                        <input type="number" class="form-control @error('rating') is-invalid @enderror"
                                            id="rating" name="rating" value="{{ old('rating', $product->rating) }}"
                                            step="0.01" min="0" max="5">
                                        @error('rating')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Options</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_free"
                                                name="is_free" value="1"
                                                {{ old('is_free', $product->is_free) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_free">Free Product</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_program"
                                                name="is_program" value="1"
                                                {{ old('is_program', $product->is_program) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_program">Is Program</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                name="is_active" value="1"
                                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Download File</label>
                                        <div class="dropzone" id="downloadFileDropzone">
                                            <div class="dz-message">
                                                <i class="fa fa-file-download fa-3x mb-2"></i>
                                                <p>Drop download file here or click to upload</p>
                                            </div>
                                        </div>
                                        <div id="download-hidden"></div>
                                        @error('download_file')
                                            <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}
                                            </div>
                                        @enderror
                                        @if ($product->getFirstMedia('downloads'))
                                            <div class="mt-2 text-muted">
                                                <small>Current file:
                                                    {{ $product->getFirstMedia('downloads')->file_name }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="download_link" class="form-label">Download Link</label>
                                        <input type="url"
                                            class="form-control @error('download_link') is-invalid @enderror"
                                            id="download_link" name="download_link"
                                            value="{{ old('download_link', $product->download_link) }}">
                                        @error('download_link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <select class="form-control" id="tags" name="tags[]" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update
                                        Product</button>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary"><i
                                            class="fa fa-times"></i> Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dash/assets/js/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            // Select2
            $('#category_id').select2({
                placeholder: "Select Category",
                allowClear: true,
                width: '100%'
            });
            $('#tags').select2({
                placeholder: "Select Tags",
                allowClear: true,
                width: '100%'
            });

            // Dropzones
            let mainImageDz = new Dropzone("#mainImageDropzone", {
                url: "{{ route('media.upload') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 1,
                maxFilesize: 5, // 5MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                init: function() {
                    @if ($product->getFirstMediaUrl('main_image'))
                        let mockFile = {
                            name: "Current Image",
                            size: 12345,
                            accepted: true
                        };
                        this.displayExistingFile(mockFile,
                            "{{ $product->getFirstMediaUrl('main_image') }}");
                    @endif
                },
                success: function(file, response) {
                    $('#main-image-hidden').html(
                        `<input type="hidden" name="temp_image" value="${response.path}">`);
                    file.temp_path = response.path;
                },
                removedfile: function(file) {
                    if (file.temp_path) {
                        $.ajax({
                            url: "{{ route('media.remove-temp') }}",
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                path: file.temp_path
                            }
                        });
                        $('#main-image-hidden').empty();
                    }
                    file.previewElement.remove();
                }
            });

            let galleryDz = new Dropzone("#galleryDropzone", {
                url: "{{ route('media.upload') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 10,
                maxFilesize: 15, // 15MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                uploadMultiple: false,
                success: function(file, response) {
                    $('#gallery-hidden').append(
                        `<input type="hidden" name="temp_gallery_images[]" value="${response.path}" data-name="${file.name}">`
                        );
                    file.temp_path = response.path;
                },
                removedfile: function(file) {
                    if (file.temp_path) {
                        $.ajax({
                            url: "{{ route('media.remove-temp') }}",
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                path: file.temp_path
                            }
                        });
                        $(`#gallery-hidden input[data-name="${file.name}"]`).remove();
                    }
                    file.previewElement.remove();
                }
            });

            let downloadDz = new Dropzone("#downloadFileDropzone", {
                url: "{{ route('media.upload') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 1,
                maxFilesize: 100, // 100MB
                addRemoveLinks: true,
                success: function(file, response) {
                    $('#download-hidden').html(
                        `<input type="hidden" name="temp_download_file" value="${response.path}">`);
                    file.temp_path = response.path;
                },
                removedfile: function(file) {
                    if (file.temp_path) {
                        $.ajax({
                            url: "{{ route('media.remove-temp') }}",
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                path: file.temp_path
                            }
                        });
                        $('#download-hidden').empty();
                    }
                    file.previewElement.remove();
                }
            });

            // Form Submit Interception
            $("#productForm").on("submit", function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);

                // Show loading state
                let submitBtn = $(form).find('button[type="submit"]');
                let originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.href = "{{ route('products.index') }}";
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $(".text-danger").remove();
                            $(".is-invalid").removeClass("is-invalid");

                            $.each(errors, function(key, value) {
                                let input = $('[name="' + key + '"]');
                                if (key === 'temp_gallery_images' || key.startsWith(
                                        'temp_gallery_images.')) {
                                    input = $('#galleryDropzone');
                                } else if (key === 'temp_image') {
                                    input = $('#mainImageDropzone');
                                } else if (key === 'temp_download_file') {
                                    input = $('#downloadFileDropzone');
                                }

                                if (input.length) {
                                    input.addClass("is-invalid");
                                    input.after(
                                        '<div class="text-danger mt-1" style="font-size: 0.875em;">' +
                                        value[0] + '</div>');
                                }
                            });

                            $('html, body').animate({
                                scrollTop: $(".text-danger").first().offset().top - 100
                            }, 500);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });
            // Delete Existing Media
            $(document).on("click", ".delete-media", function() {
                let btn = $(this);
                let id = btn.data("id");

                if (confirm("Are you sure you want to delete this image?")) {
                    $.ajax({
                        url: "{{ url('media') }}/" + id,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            btn.closest(".gallery-item").remove();
                        },
                        error: function() {
                            alert("Failed to delete media.");
                        }
                    });
                }
            });
        });
    </script>
@endsection
