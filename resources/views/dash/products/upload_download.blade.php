@extends('dash.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Upload Download File</h4>
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
                        <li class="breadcrumb-item">Management</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="breadcrumb-item active">Upload Download</li>
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
                        <h5>Upload File for: {{ $product->name }}</h5>
                    </div>
                    <div class="card-body">

                        {{-- Alert Area --}}
                        <div id="alert-container"></div>

                        {{-- Current File Info --}}
                        @if($product->getFirstMediaUrl('downloads'))
                            <div class="alert alert-light-primary" role="alert">
                                <i class="txt-primary" data-feather="file-text"></i>
                                <span class="txt-primary">Current File: </span>
                                <a href="{{ $product->getFirstMediaUrl('downloads') }}" target="_blank" class="alert-link txt-primary">Download Current File</a>
                            </div>
                        @else
                            <div class="alert alert-light-secondary" role="alert">
                                <i class="txt-secondary" data-feather="info"></i>
                                <span class="txt-secondary">No downloadable file currently uploaded.</span>
                            </div>
                        @endif

                        {{-- Upload Form --}}
                        <form id="upload-form" action="{{ route('products.save-download', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file-input" class="form-label">Select File (Max: 500MB)</label>
                                <input class="form-control" type="file" id="file-input" name="file" required>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="progress mb-3 d-none" id="progress-container" style="height: 25px;">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>

                            <div class="card-footer text-end">
                                <a href="{{ route('products.index') }}" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="fa fa-upload"></i> Upload File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('upload-form');
            const fileInput = document.getElementById('file-input');
            const progressBar = document.getElementById('progress-bar');
            const progressContainer = document.getElementById('progress-container');
            const alertContainer = document.getElementById('alert-container');
            const submitBtn = document.getElementById('submit-btn');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous alerts
                alertContainer.innerHTML = '';

                // Validate file selection
                if (!fileInput.files.length) {
                    showAlert('Please select a file first.', 'danger');
                    return;
                }

                const file = fileInput.files[0];
                // Client-side size validation (500MB = 524288000 bytes)
                if (file.size > 524288000) {
                     showAlert('File is too large. Max size is 500MB.', 'danger');
                     return;
                }

                // Prepare FormData
                const formData = new FormData(form);

                // Disable button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';

                // Show progress bar
                progressContainer.classList.remove('d-none');
                progressBar.style.width = '0%';
                progressBar.innerHTML = '0%';
                progressBar.setAttribute('aria-valuenow', 0);
                progressBar.classList.remove('bg-success', 'bg-danger');

                // AJAX Request
                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                
                // Progress event
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = Math.round((e.loaded / e.total) * 100);
                        progressBar.style.width = percentComplete + '%';
                        progressBar.innerHTML = percentComplete + '%';
                        progressBar.setAttribute('aria-valuenow', percentComplete);
                    }
                };

                // Load event (Success/Error from server)
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                progressBar.classList.add('bg-success');
                                progressBar.innerHTML = 'Upload Complete!';
                                showAlert(response.message || 'File uploaded successfully!', 'success');
                                // Optional: Reload page after short delay to show new file
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                throw new Error(response.error || 'Upload failed');
                            }
                        } catch (err) {
                            handleError(err.message || 'Invalid server response');
                        }
                    } else {
                        // Try to parse JSON error response
                        try {
                             const response = JSON.parse(xhr.responseText);
                             handleError(response.message || response.error || 'Server Error: ' + xhr.status);
                        } catch(e) {
                            handleError('Server Error: ' + xhr.status);
                        }
                    }
                    resetFormState();
                };

                // Error event (Network error)
                xhr.onerror = function() {
                    handleError('Network error occurred during upload.');
                    resetFormState();
                };

                xhr.send(formData);
            });

            function handleError(message) {
                progressBar.classList.add('bg-danger');
                progressBar.innerHTML = 'Failed';
                showAlert(message, 'danger');
            }

            function resetFormState() {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa fa-upload"></i> Upload File';
            }

            function showAlert(message, type) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                alertContainer.innerHTML = alertHtml;
            }
        });
    </script>
@endsection
