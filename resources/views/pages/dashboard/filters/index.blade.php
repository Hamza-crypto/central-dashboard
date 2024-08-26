<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Select Options</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <!-- Website Dropdown -->
                    <div class="form-group col-md-6">
                        <label for="website">Select Website</label>
                        <select class="form-control form-select select2" name="website" id="website">
                            @foreach ($websites as $website)
                                <option value="{{ $website->id }}">
                                    {{ $website->url }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Period Dropdown -->
                    <div class="form-group col-md-6">
                        <label for="period">Select Period</label>
                        <select class="form-control form-select select2" name="period" id="period">
                            <option value="1h">Last 1 Hour</option>
                            <option value="1d">Last 1 Day</option>
                            <option value="1w">Last 1 Week</option>
                            <option value="1mo">Last 1 Month</option>
                            <option value="3mo">Last 3 Months</option>
                            <option value="6mo">Last 6 Months</option>
                            <option value="12mo">Last 12 Months</option>
                        </select>
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
            </div>
        </div>

    </div>

</div>
