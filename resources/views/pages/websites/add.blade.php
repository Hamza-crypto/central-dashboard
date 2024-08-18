@extends('layouts.app')

@section('title', __('Add Group'))
@section('scripts')
    <script>
        $(document).ready(function() {


        });
    </script>
@endsection
@section('content')

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: 'Status has been updated.',
                icon: 'success'
            });
        </script>
    @endif


    <div id="error-messages" class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
        <div class="alert-message">
            <strong>Error!</strong> Please fix the following issues:
            <ul></ul>
        </div>
    </div>

    <h1 class="h3 mb-3">Add New Group</h1>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('websites.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">

                                <div class="mb-3">
                                    <label for="name" class="form-label"> Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Group Name">
                                </div>



                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" spellcheck="true" style="height: 120px;"></textarea>
                                </div>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Add New Group</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
