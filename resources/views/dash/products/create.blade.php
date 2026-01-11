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
                    <h4>Create Product</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.home') }}"><svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
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
                        <h4>Product Information</h4>
                    </div>
                    <div class="card-body">
                        <form id="productForm" action="{{ route('products.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required>
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
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                            rows="4">{{ old('description') }}</textarea>
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
                                        <label class="form-label">Gallery Images</label>
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

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price', 0) }}" step="0.01"
                                            min="0">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                            id="discount" name="discount" value="{{ old('discount', 0) }}"
                                            step="0.01" min="0" max="100">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating</label>
                                        <input type="number" class="form-control @error('rating') is-invalid @enderror"
                                            id="rating" name="rating" value="{{ old('rating', 0) }}" step="0.01"
                                            min="0" max="5">
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
                                                name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_free">Free Product</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_program"
                                                name="is_program" value="1"
                                                {{ old('is_program') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_program">Is Program</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                name="is_active" value="1"
                                                {{ old('is_active', true) ? 'checked' : '' }}>
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
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="download_link" class="form-label">Download Link</label>
                                        <input type="url"
                                            class="form-control @error('download_link') is-invalid @enderror"
                                            id="download_link" name="download_link" value="{{ old('download_link') }}">
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
                                                    {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                                    {{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Create
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
                uploadMultiple: false, // Upload one by one to handle temp paths easier
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
                chunking: true,
                forceChunking: true,
                chunkSize: 2000000, // 2MB
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
                submitBtn.prop('disabled', true).html(
                '<i class="fa fa-spinner fa-spin"></i> Submitting...');

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
                                // Map validation errors for temp files to their respective dropzones
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
        });
    </script>
@endsection
```
