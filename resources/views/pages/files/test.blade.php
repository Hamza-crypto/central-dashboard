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
        });
    </script>
@endsection
@section('content')


    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label" for="employment_type"> Employment Type </label>

                        <select class="form-control form-select select2" name="states[]" multiple="multiple"
                            data-toggle="select2">
                            <option value="AL">Alabama</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
