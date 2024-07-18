<style>
    #downloadButton {
        display: none;
    }

    #loader {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 9999;
    }

    #dataTable thead th:first-child,
    #dataTable tbody tr td:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: #fff;
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
</style>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<h1 style="text-align:center; ">DSE Date Wise Report</h1>
<div id="loader" style="display: none; text-align: center;">
    <div class="loader"></div>
</div>
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-body">
            <?php $header_process_id = $this->session->userdata('process_id');
            $executive_array = array("1", "2", "5", "7", "9", "11", "13", "15");
            if (in_array($this->session->userdata('role'), $executive_array)) { ?>
                <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="col-md-offset-1 col-md-11">
                    <?php } ?>
                    <div class="form-group col-md-12">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 20px;">
                            <form action="<?php echo site_url(); ?>Dse/dse_view" id="filterForm1" method="post">
                                <select class="filter_s col-md-12 col-xs-12 form-control" name="dse_user" id="dse_user">
                                    <option value="all">Please Select</option>
                                    <?php foreach ($leads as $lead) : ?>
                                        <option value="<?php echo $lead['id']; ?>"><?php echo $lead['full_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 20px;">
                            <div class="form-group">
                                <input type="date" id="fromdate" value="" class="filter_s col-md-12 col-xs-12 form-control" placeholder="From Date" name="fromdate" readonly style="cursor: default;">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 20px;">
                            <div class="form-group">
                                <input type="date" id="todate" value="" class="filter_s col-md-12 col-xs-12 form-control" placeholder="To Date" name="todate" readonly style="cursor: default;">
                            </div>
                        </div>
                        <div class="col-md-offset-4 col-lg-offset-4 col-lg-7 col-md-7 col-sm-7 col-xs-12" style="padding:20px;">
                            <div class="form-group">
                                <button type="submit" id="submitButton" class="btn btn-info"><i class="entypo-search"> Search</i></button>
                                <button type="button" id="downloadButton" onclick="test(event)" class="btn btn-primary"><i class="entypo-download"> Download</i></button>
                                <button type="button" onclick="resetForm()" class="btn btn-success"><i class="entypo-ccw"> Reset</i></button>
                            </div>
                        </div>
                        </form>

                        <div id="table_div" style="display: none; width: 100%;height: 100%; overflow: auto;">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Leads</th>
                                        <th>Attempted</th>
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

                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                        <script>
                            function validateDates() {
                                var fromDate = document.getElementById("fromdate").value;
                                var toDate = document.getElementById("todate").value;
                                var dseUser = document.getElementById("dse_user").value;
                                if (dseUser === 'all') {
                                    toastr.error("Please select a valid DSE User.");

                                    return false;
                                }
                                if (fromDate === '' || toDate === '') {
                                    toastr.error("Please select both From Date and To Date.");

                                    return false;
                                }
                                return true;
                            }

                            function resetForm() {
                                document.getElementById('filterForm1').reset();
                                document.getElementById('dse_user').selectedIndex = 0; // Reset the dropdown to the first option
                                document.getElementById('dataTable').innerHTML = '';
                                $('#downloadButton').hide();
                            }
                            $(document).ready(function() {
                                $('#downloadButton').hide();
                                $('#fromdate, #todate').datepicker({
                                    maxDate: 0,
                                    dateFormat: 'yy-mm-dd'
                                });
                                $('#filterForm1').submit(function(e) {
                                    if (!validateDates()) {
                                        e.preventDefault();
                                        return;
                                    }
                                    e.preventDefault();
                                    $('#loader').show();
                                    var formData = {
                                        start_date: $('#fromdate').val(),
                                        end_date: $('#todate').val(),
                                        dse_user: $('#dse_user').val(),
                                    };
                                    var fromDate = $('#fromdate').val();
                                    var toDate = $('#todate').val();
                                    var fromDateObj = new Date(fromDate);
                                    var toDateObj = new Date(toDate);
                                    if (fromDateObj >= toDateObj) {
                                        toastr.error('Please select a valid date range.');
                                        $('#loader').hide();
                                        return;
                                    }
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo site_url(); ?>Dse/filterSubmissionProcesses1',
                                        data: formData,
                                        dataType: 'json',
                                        success: function(response) {
                                            $('#loader').hide();
                                            console.log(response);
                                            if (response.length) {
                                                $('#downloadButton').show();
                                                document.getElementById('table_div').style.display = 'block';
                                                $('#dataTable tbody').empty();
                                                var currentDate = $('#fromdate').val();
                                                var toDate = $('#todate').val();
                                                currentDate = new Date(currentDate);
                                                toDate = new Date(toDate);
                                                var datesArray = [];
                                                while (currentDate <= toDate) {
                                                    var dateFormatted = currentDate.toISOString().split('T')[0];
                                                    datesArray.push(dateFormatted);
                                                    currentDate.setDate(currentDate.getDate() + 1);
                                                }
                                                const dictByDate = {};
                                                response.forEach(item => {
                                                    dictByDate[item.date] = item;
                                                });
                                                datesArray.reverse();

                                                var headerRow = '<tr><th>Date</th>';
                                                datesArray.forEach(function(date) {
                                                    headerRow += '<th>' + date + '</th>';
                                                });
                                                headerRow += '<th>Total Count</th>';
                                                headerRow += '</tr>';

                                                $('#dataTable thead').html(headerRow);
                                                var leadrow = '<tr><td>Leads</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        leadrow += '<td>' + dictByDate[date]['total_leads'] + '</td>';
                                                        count += parseInt(dictByDate[date]['total_leads']);
                                                    } else {
                                                        leadrow += '<td>NA</td>';
                                                    }
                                                });
                                                leadrow += '<td>' + count + '</td>';
                                                leadrow += '</tr>';


                                                var attemptrow = '<tr><td>Attempt</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        attemptrow += '<td>' + dictByDate[date]['attempt'] + '</td>';
                                                        count += parseInt(dictByDate[date]['attempt']);
                                                    } else {
                                                        attemptrow += '<td>NA</td>';
                                                    }
                                                });
                                                attemptrow += '<td>' + count + '</td>';
                                                attemptrow += '</tr>';


                                                var connectedrow = '<tr><td>Connected</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        connectedrow += '<td>' + dictByDate[date]['connected'] + '</td>';
                                                        count += parseInt(dictByDate[date]['connected']);
                                                    } else {
                                                        connectedrow += '<td>NA</td>';
                                                    }
                                                });
                                                connectedrow += '<td>' + count + '</td>';
                                                connectedrow += '</tr>';



                                                var intresteddrow = '<tr><td>Intrested</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        intresteddrow += '<td>' + dictByDate[date]['interested'] + '</td>';
                                                        count += parseInt(dictByDate[date]['interested']);
                                                    } else {
                                                        intresteddrow += '<td>NA</td>';
                                                    }
                                                });
                                                intresteddrow += '<td>' + count + '</td>';
                                                intresteddrow += '</tr>';


                                                var assignedrow = '<tr><td>Assigned</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        assignedrow += '<td>' + dictByDate[date]['total_leads'] + '</td>';
                                                        count += parseInt(dictByDate[date]['total_leads']);
                                                    } else {
                                                        assignedrow += '<td>NA</td>';
                                                    }
                                                });
                                                assignedrow += '<td>' + count + '</td>';
                                                assignedrow += '</tr>';


                                                var testdriverow = '<tr><td>Test Drive</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        testdriverow += '<td>' + dictByDate[date]['Test_Drive'] + '</td>';
                                                        count += parseInt(dictByDate[date]['Test_Drive']);
                                                    } else {
                                                        testdriverow += '<td>NA</td>';
                                                    }
                                                });
                                                testdriverow += '<td>' + count + '</td>';
                                                testdriverow += '</tr>';


                                                var bookingrow = '<tr><td>Booking</td>';
                                                count = 0
                                                datesArray.forEach(function(date) {
                                                    if (dictByDate[date]) {
                                                        bookingrow += '<td>' + dictByDate[date]['Booked'] + '</td>';
                                                        count += parseInt(dictByDate[date]['Booked']);
                                                    } else {
                                                        bookingrow += '<td>NA</td>';
                                                    }
                                                });
                                                bookingrow += '<td>' + count + '</td>';
                                                bookingrow += '</tr>';

                                                $('#dataTable tbody').html(leadrow + attemptrow + connectedrow + intresteddrow + assignedrow + testdriverow + bookingrow);
                                            }

                                        },
                                        error: function(xhr, status, error) {
                                            $('#loader').hide();
                                            console.log(xhr.responseText);
                                        }
                                    });
                                });

                                $('#downloadButton').click(function() {
                                    var table = document.getElementById('dataTable');
                                    var wb = XLSX.utils.table_to_book(table, {
                                        sheet: "Sheet JS"
                                    });
                                    XLSX.writeFile(wb, 'DSE_Report.xlsx');
                                });
                            });
                        </script>