<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Select website to see particular stats</h5>
            </div>
            <div class="card-body">
                <select class="form-control form-select select2" data-toggle="select2" name="website" id="website">
                    @foreach ($websites as $website)
                        <option value="{{ $website->id }}">
                            {{ $website->url }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-xl-12 d-flex">
        <div class="w-100">

            <div class="row">


                <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Bounce Rate (Avg)</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat stat-sm">
                                        <i class="align-middle" data-feather="arrow-up-right"></i>

                                    </div>
                                </div>
                            </div>
                            <span class="h1 d-inline-block mt-1 mb-4" id="bounce_rate">0.00</span>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Avg Session Duration</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat stat-sm">
                                        <i class="align-middle" data-feather="clock"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="h1 d-inline-block mt-1 mb-4" id="session_duration">0.00</span>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Page Views (Total)</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat stat-sm">
                                        <i class="align-middle" data-feather="arrow-up-right"></i>

                                    </div>
                                </div>
                            </div>
                            <span class="h1 d-inline-block mt-1 mb-4" id="total_pages">0.00</span>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Visitors (Total)</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat stat-sm">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="h1 d-inline-block mt-1 mb-4" id="total_users">0.00</span>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
