@if (count($files))
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">

                <div class="card-body">
                    <label>File Upload History (Most recent on the top)</label>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Website(s)</th>
                                <th>Uploaded Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $file->name }}</td>

                                    <td>
                                        <ul>
                                            @foreach ($file->websites as $website)
                                                <li>{{ $website->url }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $file->created_at }} ( {{ $file->created_at->diffForHumans() }} )</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Delete All Files Button -->
                    <form action="{{ route('files.deleteAll') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-3">
                            Delete All Files
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endif
