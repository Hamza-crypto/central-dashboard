<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">

            <div class="card-body">
                <label>Select the websites on which you want to sync the data</label>
                <form action="{{ route('data.sync') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ session('id') }}" />
                    <table class="table">


                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th style="width:10%">Website</th>
                                <th style="width:90%">Categories</th>
                            </tr>


                        </thead>
                        <tbody>
                            @foreach (session('websites') as $website)
                                <tr>
                                    <td><input type="checkbox" class="select-row" name="selected[]"
                                            value="{{ $website->id }}"></td>
                                    <td>{{ $website->url }}</td>


                                    <td>
                                        <select class="form-control form-select select2" data-toggle="select2"
                                            multiple="multiple" name="categories[{{ $website->id }}][]">
                                            @foreach (session('categories') as $category)
                                                <option value="{{ $category }}">
                                                    {{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"> Sync Data
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
