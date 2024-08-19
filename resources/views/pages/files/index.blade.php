@extends('layouts.app')

@section('title', __('Groups'))

@section('scripts')
    <script src="{{ asset('/assets/js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection

@section('content')

    @if (session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="gateway-table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Website</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @php  $count = 1 @endphp
                        @foreach ($websites as $website)
                            <tr>
                                <td>{{ $count++ }} </td>


                                <td>{{ $website->url }}</td>

                                <td>{{ $website->created_at->diffForHumans() }}</td>
                                <td class="table-action">
                                    <a href="{{ route('websites.edit', $website->id) }}" class="btn"
                                        style="display: inline">
                                        <i class="fa fa-edit text-info"></i>
                                    </a>
                                    <form method="post" action="{{ route('websites.destroy', $website->id) }}"
                                        onsubmit="return confirmSubmission(this, 'Are you sure you want to delete location ' + '{{ "$website->url" }}')"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn text-danger"
                                            href="{{ route('websites.destroy', $website->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
