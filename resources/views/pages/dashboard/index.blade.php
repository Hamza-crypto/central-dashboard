@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {

            function getUniqueVisitors(selectedId) {
                $.ajax({
                    url: '/api/stats/',
                    method: 'POST',
                    data: {
                        id: selectedId,
                        _token: '{{ csrf_token() }}' // Include CSRF token if needed
                    },
                    success: function(data) {

                        $('#total_users').text(0.00);
                        $('#bounce_rate').text(0.00);
                        $('#session_duration').text(0.00);
                        $('#total_pages').text(0.00);

                        // Assuming 'data.unique_visitors' contains the data you need
                        if (data.unique_visitors && Array.isArray(data.unique_visitors)) {

                            const tableBody = $('#analytics-table-body');
                            tableBody.empty(); // Clear existing rows

                            let totalUsers = 0;
                            let totalScreenViews = 0;
                            let totalBounceRate = 0;
                            let totalSessionDuration = 0;
                            let count = 0;

                            data.unique_visitors.forEach(visitor => {

                                if (count >= 10) {
                                    return false; // This works like 'break' in a .forEach loop
                                }
                                totalUsers += visitor.activeUsers;
                                totalScreenViews += visitor.screenPageViews;
                                totalBounceRate += parseFloat(visitor.bounceRate);
                                totalSessionDuration += parseFloat(visitor
                                    .averageSessionDuration);
                                count++;

                                const row = $('<tr>');

                                // Modify pagePath
                                let pagePath = visitor.pagePath === '/' ? 'Home Page' : visitor
                                    .pagePath.substring(1);

                                row.append(
                                    `<td>${visitor.pageTitle} </br>${pagePath} </td>`
                                );

                                row.append(`<td class="text-end">${visitor.activeUsers}</td>`);
                                row.append(
                                    `<td class="">${visitor.screenPageViews}</td>`
                                );
                                row.append(
                                    `<td class="">${parseFloat(visitor.bounceRate * 100).toFixed(2)}</td>`
                                );
                                row.append(
                                    `<td class="">${parseFloat(visitor.averageSessionDuration).toFixed(2)}</td>`
                                );

                                tableBody.append(row);

                            });

                            // Calculate averages
                            const averageBounceRate = (totalBounceRate / count) *
                                100; // Convert to percentage
                            const averageSessionDuration = totalSessionDuration / count;
                            // Convert session duration to minutes and format it
                            let sessionDurationMinutes = (averageSessionDuration / 60).toFixed(2);

                            $('#total_users').text(totalUsers);
                            $('#bounce_rate').text(parseFloat(averageBounceRate).toFixed(2) + '%');
                            $('#session_duration').text(parseFloat(averageSessionDuration).toFixed(2));
                            $('#total_pages').text(totalScreenViews);

                        } else {
                            $('#data-result').html('<p>No visitor data available.</p>');
                        }


                        if (data.click_on_listings && Array.isArray(data.click_on_listings)) {

                            const tableBodyClicks = $('#clicks-table-body');
                            tableBodyClicks.empty(); // Clear existing rows


                            data.click_on_listings.forEach(listing => {

                                const row = $('<tr>');

                                // Modify pagePath for home page
                                let pagePath = listing.pagePath === '/' ? 'Home Page' : listing
                                    .pagePath.substring(1);

                                row.append(
                                    `<td class="d-xl-table-cell text-end">${pagePath}</td>`);
                                row.append(
                                    `<td class="d-xl-table-cell text-end">${listing.eventCount}</td>`
                                );
                                row.append(
                                    `<td class="d-xl-table-cell text-end">${parseFloat(listing.eventCountPerUser).toFixed(2)}</td>`
                                );

                                tableBodyClicks.append(row);
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            $('#data-result').html('<p>Data not found.</p>');
                        } else {
                            $('#data-result').html('<p>An error occurred.</p>');
                        }
                    }
                });
            };

            // Trigger data fetch when the page loads
            var initialId = $('#website').find('option:first').val();
            if (initialId) {
                getUniqueVisitors(initialId);
            }

            $('.select2').select2();

            $('#website').on('change', function() {
                var selectedId = $(this).val();
                getUniqueVisitors(selectedId);
            });

            //$('#analytics-table').DataTable();

        });
    </script>
@endsection

@section('content')


    <h1>Dashboard Stats</h1>

    @include('pages.dashboard._inc.stats')
    @include('pages.dashboard._inc.unique_visitors')
    @include('pages.dashboard._inc.clicks_on_listings')

@endsection
