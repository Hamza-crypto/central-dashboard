@extends('layouts.app')

@section('title', __('Add Website'))
@section('scripts')
    <script>
        $(document).ready(function() {


        });
    </script>
@endsection
@section('content')

    @if (session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif


    <div id="error-messages" class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
        <div class="alert-message">
            <strong>Error!</strong> Please fix the following issues:
            <ul></ul>
        </div>
    </div>

    <h1 class="h3 mb-3">Add New Website</h1>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('websites.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">

                                <div class="mb-3">
                                    <label for="name" class="form-label"> URL</label>
                                    <input type="text" class="form-control" name="url" placeholder="Website Name"
                                        required>
                                </div>


                                <div class="mb-3">
                                    <label for="token" class="form-label">Token (Optional)</label>
                                    <input type="text" class="form-control" name="token" placeholder="Token">
                                </div>

                                <small>For wordpress based website please append the following url with website
                                    address. <a
                                        href="/wp-json/central-dashboard/v1/sync">/wp-json/central-dashboard/v1/sync</a></small>
                                <hr> <small>https://example.com/wp-json/central-dashboard/v1/sync<a
                                        href="/wp-json/central-dashboard/v1/sync"></a></small>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Add New Website</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
