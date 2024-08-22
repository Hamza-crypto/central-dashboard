@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#website').on('change', function() {
                var selectedId = $(this).val();
                console.log('Selected ID:', selectedId);
                // You can now use selectedId for further actions
            });

        });
    </script>
@endsection

@section('content')


    <h1>Dashboard Stats</h1>
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
                        <div class="card illustration flex-fill">
                            <div class="card-body p-0 d-flex flex-fill">
                                <div class="row g-0 w-100">
                                    <div class="col-6">
                                        <div class="illustration-text p-3 m-1">
                                            <h4 class="illustration-text">Welcome Back, Chris!</h4>
                                            <p class="mb-0">AppStack Dashboard</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Bounce</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="align-middle" data-feather="arrow-up-right"></i>

                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">2.364</span>
                                <div class="mb-0">
                                    <span class="badge badge-subtle-success me-2"> +3.65% </span>
                                    <span class="text-muted">Since last week</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Real-Time</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="align-middle" data-feather="clock"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">1.856</span>
                                <div class="mb-0">
                                    <span class="badge badge-subtle-success me-2"> +2.25% </span>
                                    <span class="text-muted">Since last week</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-12 col-xxl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Visitors</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="align-middle" data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">17.212</span>
                                <div class="mb-0">
                                    <span class="badge badge-subtle-danger me-2"> -1.25% </span>
                                    <span class="text-muted">Since last week</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>


    <h2>Unique Visitors</h2>
    <ul>
        @foreach ($stats['unique_visitors'] as $visitor)
            <li>{{ $visitor['pagePath'] }}: {{ $visitor['activeUsers'] }} active users</li>
        @endforeach
    </ul>

    <h2>Bounce Rate</h2>
    <ul>
        @foreach ($stats['bounce_rate'] as $rate)
            <li>{{ $rate['pageTitle'] }}: {{ $rate['screenPageViews'] }} views, Bounce Rate: {{ $rate['bounceRate'] }}</li>
        @endforeach
    </ul>

    <h2>Average Session Duration</h2>
    <p>{{ $stats['avg_session'] }} seconds</p>

    <h2>Clicks on Listings</h2>
    <ul>
        @foreach ($stats['click_on_listings'] as $click)
            <li>{{ $click['pagePath'] }}: {{ $click['eventCount'] }} clicks</li>
        @endforeach
    </ul>

    <h2>Revenue Per Site</h2>
    <ul>
        @foreach ($stats['revenue_per_site'] as $revenue)
            <li>{{ $revenue['pagePath'] }}: {{ $revenue['eventCount'] }} events</li>
        @endforeach
    </ul>

@endsection
