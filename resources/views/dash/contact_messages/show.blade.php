@extends('dash.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Message Details</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.home') }}"><svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contact-messages.index') }}">Contact Messages</a>
                        </li>
                        <li class="breadcrumb-item active">View</li>
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
                        <h4>From: {{ $message->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <p>{{ $message->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Subject:</label>
                            <p>{{ $message->subject }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Date:</label>
                            <p>{{ $message->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Message:</label>
                            <div class="p-3 bg-light border rounded">
                                {{ $message->message }}
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('contact-messages.index') }}" class="btn btn-secondary">Back to List</a>
                            <form action="{{ route('contact-messages.destroy', $message->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
