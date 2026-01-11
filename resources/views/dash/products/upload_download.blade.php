@extends('dash.layouts.main')

@section('title', 'Upload Download File')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('dash/assets/css/vendors/dropzone.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Upload Download File</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Products</li>
                        <li class="breadcrumb-item active">Upload File</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Download File for: {{ $product->name }}</h5>
                        <span>Please upload the main file for this product. You can skip this for now and come back later
                            via the edit page if needed.</span>
                    </div>
                    <div class="card-body">
                        <form id="uploadForm" action="{{ route('products.save-download', $product->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">File upload (Max 100MB)</label>
                                        <div class="dropzone" id="downloadFileDropzone">
                                            <div class="dz-message">
                                                <i class="fa fa-file-download fa-3x mb-2"></i>
                                                <p>Drop file here or click to upload</p>
                                            </div>
                                        </div>
                                        <div id="download-hidden"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Save and Finalize</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Skip / Do Later</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/assets/js/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
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
                },
                error: function(file, message) {
                    alert(message);
                    this.removeFile(file);
                }
            });

            $("#uploadForm").on("submit", function(e) {
                if ($('#download-hidden input').length === 0) {
                    e.preventDefault();
                    alert('Please upload a file before saving, or click Skip.');
                    return;
                }

                let submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            });
        });
    </script>
@endsection
