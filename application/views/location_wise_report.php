<style>
    #loader {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 9999;
    }

    .loader {
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #downloads {
        display: none;
    }

    #dataTable thead th:first-child,
    #dataTable tbody tr td:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: #fff;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<h1 style="text-align:center; ">Location Wise Report</h1>
<div id="loader" style="display: none; text-align: center;">
    <div class="loader"></div>
</div>
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-body">
            <form action="<?php echo site_url(); ?>Location_wise/location_wise_report" id="filterForm" method="POST">
                <div class="form-group col-md-12">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
                        <select class="filter_s col-md-12 col-xs-12 form-control" name="city" id="city" onchange='select_city()'>
                            <option value="">Please Select City</option>
                            <option value="Pune">Pune</option>
                            <option value="Mumbai">Mumbai</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
                        <select class="filter_s col-md-12 col-xs-12 form-control" name="location" id="location">
                            <option value="">Please Select Location</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
                        <div class="form-group">
                            <input type="text" id="fromdate" class="col-md-12 col-xs-12 form-control" placeholder="From Date" name="fromdate" readonly style="cursor: default;">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
                        <div class="form-group">
                            <input type="text" id="todate" class="col-md-12 col-xs-12 form-control" placeholder="To Date" name="todate" readonly style="cursor: default;">
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-lg-offset-4 col-lg-7 col-md-7 col-sm-7 col-xs-12" style="padding:20px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info entypo-search">Search</button>
                            <a target="_blank" id="downloads">
                                <i class="btn btn-primary entypo-download" id="Downloads"> Downloads</i></a>
                            <a onclick="resetForm()"> <i class="btn btn-success entypo-ccw"> Reset</i></a>
                        </div>
                    </div>
                </div>
            </form>
            <div id="table_div" style="display: none; width: 100%;height: 100%; overflow: auto;">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Leads</th>
                            <th>Connected</th>
                            <th>Interested</th>
                            <th>Assigned</th>
                            <th>Test Drive</th>
                            <th>Booking</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<script>
    function resetForm() {
        document.getElementById("filterForm").reset();
        $('#table_div').hide();
        $('#downloads').hide();
    }

    function select_city() {
        var city = $('#city').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Location_wise/get_locations'); ?>",
            data: {
                city: city
            },
            success: function(response) {
                $('#location').html(response);
            }
        });
    }

    $(document).ready(function() {
        $('#fromdate, #todate').datepicker({
            maxDate: 0,
            dateFormat: 'yy-mm-dd'
        });
        $('#filterForm').submit(function(e) {
            e.preventDefault();
            $('#loader').show();
            var fromDate = $('#fromdate').val();
            var toDate = $('#todate').val();
            var fromDateObj = new Date(fromDate);
            var toDateObj = new Date(toDate);
            if (fromDateObj >= toDateObj) {
                toastr.error('Please select a valid date range.');
                $('#loader').hide();
                return;
            }
            var city = $('#city').val();
            var location = $('#location').val();
            if (!fromDate || !toDate) {
                toastr.error('Please select both Start Date and End Date.');
                $('#loader').hide();
                return;
            }
            if (!location) {
                toastr.error('Please select location.');
                $('#loader').hide();
                return;
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url(); ?>Location_wise/filterSubmissionProcesses',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#loader').hide();
                    if (response.success) {
                        $('#table_div').show();
                        $('#dataTable tbody').empty();
                        var allDates = [...new Set(response.results.map(item => item.date).concat(response.dates))];
                        allDates.reverse();
                        var headerRow = '<tr><th>Date</th>';
                        allDates.forEach(function(date) {
                            headerRow += '<th>' + date + '</th>';
                        });
                        headerRow += '<th>Total Count</th></tr>';
                        $('#dataTable thead').empty().append(headerRow);
                        ['lead_count', 'connected_count', 'interested_count', 'testdrive_count', 'booked_count'].forEach(function(metric) {
                            var row = '<tr><td>' + metric.replace('_count', ' ').toUpperCase() + '</td>';
                            var totalCount = 0;
                            allDates.forEach(function(date) {
                                var countObj = response.results.find(function(item) {
                                    return item.date === date;
                                });
                                var dateCount = countObj ? countObj[metric] || 0 : 0;
                                if (!isNaN(dateCount)) {
                                    totalCount += parseInt(dateCount);
                                }
                                row += '<td>' + (dateCount === 0 ? 0 : dateCount) + '</td>';
                            });
                            row += '<td>' + (totalCount === 0 ? 0 : totalCount) + '</td>';
                            row += '</tr>';
                            $('#dataTable tbody').append(row);
                        });
                        $('#downloads').show();
                    } else {
                        if (response.errors) {
                            Object.values(response.errors).forEach(function(error) {
                                toastr.error(error);
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Error: ' + error);
                    $('#loader').hide();
                }
            });
        });
        $('#Downloads').click(function() {
            var table = document.getElementById('dataTable');
            var wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet JS"
            });
            XLSX.writeFile(wb, 'Location_Report.xlsx');
        });
    });

    function findCountByDate(counts, date) {
        var countObj = counts.find(function(item) {
            return item.date === date;
        });
        return countObj ? countObj.count : '';
    }
</script>