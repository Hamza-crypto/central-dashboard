<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">

            <div class="card-body">
                <label>File Upload History</label>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Websites</th>
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
                                <td>{{ $file->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
