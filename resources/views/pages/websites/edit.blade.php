@extends('layouts.app')

@section('title', __('Add Website'))
@section('scripts')
    <script>
        $(document).ready(function() {


        });
    </script>
@endsection
@section('content')

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
                                    <input type="text" class="form-control" name="url" value="{{ $website->url }}"
                                        placeholder="Website Name">
                                </div>


                                <div class="mb-3">
                                    <label for="token" class="form-label">Token (Optional)</label>
                                    <input type="text" class="form-control" name="token" value="{{ $website->token }}"
                                        placeholder="Token">
                                </div>

                                <div class="mb-3">
                                    <label for="token" class="form-label">Preffered Fields (Optional)</label>
                                    <input type="text" class="form-control select2" name="preffered_columns"
                                        value="{{ $website->preffered_columns }}" placeholder="Preffered columns">
                                </div>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Add New Website</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
