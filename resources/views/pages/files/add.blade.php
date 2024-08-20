@extends('layouts.app')

@section('title', __('Add File'))

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#selectAll').click(function(event) { //on click
                if (this.checked) { // check  if the master checkbox is checked
                    $('.select-row').each(function() { // loop through all checkboxes
                        this.checked = true; // select all checkboxes
                    });
                } else {
                    $('.select-row').each(function() { // loop through all checkboxes
                        this.checked = false; // deselect all checkboxes
                    });
                }
            });
        });
    </script>
@endsection
@section('content')

    @if (session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if (session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif


    <div id="error-messages" class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
        <div class="alert-message">
            <strong>Error!</strong> Please fix the following issues:
            <ul></ul>
        </div>
    </div>

    <h1 class="h3 mb-3">Add New File</h1>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <div class="mb-3">
                                        <input type="file" name="file" required>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="align-middle"
                                    data-feather="upload"></i> Upload File
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    @if (session('websites'))
        @include('pages.files.websites')
    @endif

@endsection
