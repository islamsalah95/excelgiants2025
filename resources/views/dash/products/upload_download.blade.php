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
                        <div id="uploadForm">
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
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" id="upload-btn" class="btn btn-primary">Save and Finalize</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Skip / Do Later</a>
                            </div>
                        </div>
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
                url: "{{ route('products.save-download', $product->id) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                autoProcessQueue: false,
                maxFiles: 1,
                maxFilesize: 100, // 100MB
                addRemoveLinks: true,
                chunking: true,
                forceChunking: true,
                chunkSize: 2000000, // 2MB
                init: function() {
                    let dz = this;

                    document.getElementById("upload-btn").addEventListener("click", function(e) {
                        e.preventDefault();
                        if (dz.getQueuedFiles().length > 0) {
                            dz.processQueue();
                        } else {
                            alert("Please select a file first.");
                        }
                    });

                    this.on("sending", function(file, xhr, formData) {
                        $('#upload-btn').prop('disabled', true).html(
                            '<i class="fa fa-spinner fa-spin"></i> Uploading...');
                    });

                    this.on("success", function(file, response) {
                        console.log("Upload success:", response);
                        window.location.href = "{{ route('products.index') }}";
                    });

                    this.on("error", function(file, message) {
                        console.error("Dropzone error:", message);
                        let errorMessage = typeof message === 'string' ? message : (message
                            .error || "Upload failed");
                        alert("Error: " + errorMessage);
                        $('#upload-btn').prop('disabled', false).text('Save and Finalize');
                    });
                }
            });
        });
    </script>
@endsection
