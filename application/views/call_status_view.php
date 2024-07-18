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

    .table tbody tr td:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: #fff;
    }

    .button-container {
        margin-bottom: 20px;
    }

    .dashboard-container {
        text-align: center;
        margin-top: 20px;
    }

    .scrollable-table {
        height: 400px;
        overflow: auto;
    }

    .content-below {
        margin-top: 20px;
    }

    .search-checkboxes {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-checkboxes label {
        margin-right: 20px;
        margin-bottom: 0;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<h1 style="text-align:center;">Call Status Report</h1>
<div id="loader" style="display: none; text-align: center;">
    <div class="loader"></div>
</div>
<div class="search-checkboxes">
    <button style="margin-right: 10px;" type="button" class="btn btn-info entypo-search" onclick="showsortresults()">Search</button>
    <label>
        <input type="radio" id="mumbai" name="city" value="mumbai" onchange="updateCheckbox()" checked> Mumbai
    </label>
    <label>
        <input type="radio" id="pune" name="city" value="pune" onchange="updateCheckbox()"> Pune
    </label>
</div>

<div class="col-md-12" id="callstatus" style="display:none;">
    <div class="panel panel-primary">
        <div class="panel-body">
            <form action="<?php echo site_url(); ?>Call_Status/index" id="filterForm" method="POST">
                <div class="form-group col-md-12">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 20px;">
                        <select class="filter_s col-md-12 col-xs-12 form-control" name="call_status" id="call_status" placeholder="Please Select Call Status">
                            <option value="">Please Select Source</option>
                            <option value="Connected">Connected</option>
                            <option value="Not Connected">Not Connected</option>
                        </select>
                        <span class="text-danger error-text" id="source-error"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 20px;">
                        <div class="form-group">
                            <input type="text" id="fromdate" class="filter_s col-md-12 col-xs-12 form-control" placeholder="From Date" name="fromdate" readonly style="cursor: default;">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 20px;">
                        <div class="form-group">
                            <input type="text" id="todate" class="filter_s col-md-12 col-xs-12 form-control" placeholder="To Date" name="todate" readonly style="cursor: default;">
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-lg-offset-4 col-lg-7 col-md-7 col-sm-7 col-xs-12" style="padding:20px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info entypo-search">Search</button>
                            <a target="_blank" id="downloads">
                                <i class="btn btn-primary entypo-download" id="Downloads" onclick="exportToExcel()"> Downloads</i>
                            </a>
                            <a onclick="resetForm()"> <i class="btn btn-success entypo-ccw"> Reset</i></a>
                        </div>
                    </div>
                </div>
            </form>
            <div id="table_div" style="display: none; width: 100%; height: 100%; overflow: auto;">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-container">
    <b>
        <p style="color:red; text-align: right;">Report from <?php echo date('Y-m-01'); ?></p>
    </b>

    <div class="panel panel-primary">
        <h3>Connected Call Status</h3>
        <div class="panel-body">
            <div style="width: 100%; height: 100%; overflow: auto;">
                <div class="scrollable-table">
                    <table id="connectedCallStatusTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Feedback Status</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <h3>Not Connected Call Status</h3>
        <div class="panel-body">
            <div style="width: 100%; height: 100%; overflow: auto;">
                <div class="scrollable-table">
                    <table id="notconnectedCallStatusTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Feedback Status</th>
        
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    var mumbaiChecked = true; 
    var puneChecked = false;
    var debounceTimeout = null; 

    $('#mumbai, #pune').on('change', function() {
        if (debounceTimeout) {
            clearTimeout(debounceTimeout);
        }

        debounceTimeout = setTimeout(function() {
            updateCheckbox();
        }, 200); 
    });

    function updateCheckbox() {
        var mumbaiCheckbox = $('#mumbai');
        var puneCheckbox = $('#pune');
        mumbaiChecked = mumbaiCheckbox.prop('checked');
        puneChecked = puneCheckbox.prop('checked');
        if (mumbaiChecked && puneChecked) {
            puneCheckbox.prop('checked', false);
            puneChecked = false;
        } else if (!mumbaiChecked && !puneChecked) {
            mumbaiCheckbox.prop('checked', true);
            mumbaiChecked = true;
        }
        callIndexAjax(mumbaiChecked, puneChecked);
    }
    callIndexAjax(mumbaiChecked, puneChecked);
});


function callIndexAjax(mumbaiChecked, puneChecked) {
    var city = mumbaiChecked ? 'mumbai' : 'pune';
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url(); ?>Call_Status/index',
        data: {
            city: city
        },
        dataType: 'json',
        beforeSend: function() {
        $('#loader').show();
        },
        success: function(response) {
            $('#loader').hide();
            if (response.success) {
                $('#table_div').show();
                populateConnectedTable(response.connectedData, response.dates);
                populatenotConnectedTable(response.notConnectedData, response.dates);
            } else {
                toastr.error('Error: Unable to fetch data.');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('AJAX Error: ' + status + ' - ' + error);
        }
    });
}

function populateConnectedTable(data, dates) {
    var table = $('#connectedCallStatusTable');
    var thead = table.find('thead');
    var tbody = table.find('tbody');
    thead.empty();
    tbody.empty();
    var headerRow = '<tr><th>Feedback Status</th>';
    dates.forEach(function(date) {
        headerRow += '<th>' + date + '</th>';
    });
    thead.append(headerRow);
    var grandTotal = 0;
    data.forEach(function(item) {
        var row = '<tr><td>' + item.feedbackStatus + '</td>';
        var statusTotal = 0;
        dates.forEach(function(date) {
            var count = getCountForDate(item.counts, date);
            row += '<td>' + count + '</td>';
            statusTotal += count;
        });
        tbody.append(row);
        grandTotal += statusTotal; 
    });

    var grandTotalRow = '<tr><td><strong>Grand Total</strong></td>';
    dates.forEach(function(date) {
        var totalForDate = getTotalForDate(data, date);
        grandTotalRow += '<td><strong>' + totalForDate + '</strong></td>';
    });
    tbody.append(grandTotalRow);
}

function populatenotConnectedTable(data, dates) {
    var table = $('#notconnectedCallStatusTable');
    var thead = table.find('thead');
    var tbody = table.find('tbody');
    thead.empty();
    tbody.empty();
    var headerRow = '<tr><th>Feedback Status</th>';
    dates.forEach(function(date) {
        headerRow += '<th>' + date + '</th>';
    });
    thead.append(headerRow);
    var grandTotal = 0;
    data.forEach(function(item) {
        var row = '<tr><td>' + item.feedbackStatus + '</td>';
        var statusTotal = 0;
        dates.forEach(function(date) {
            var count = getCountForDate(item.counts, date);
            row += '<td>' + count + '</td>';
            statusTotal += count;
        });
        tbody.append(row);
        grandTotal += statusTotal; 
    });
    var grandTotalRow = '<tr><td><strong>Grand Total</strong></td>';
    dates.forEach(function(date) {
        var totalForDate = getTotalForDate(data, date);
        grandTotalRow += '<td><strong>' + totalForDate + '</strong></td>';
    });
    tbody.append(grandTotalRow);
}

function getCountForDate(counts, targetDate) {
    var count = 0;
    counts.forEach(function(item) {
        if (item.date === targetDate) {
            count = parseInt(item.status_count);
            return false;
        }
    });
    return count;
}

function getTotalForDate(data, targetDate) {
    var total = 0;
    data.forEach(function(item) {
        var count = getCountForDate(item.counts, targetDate);
        total += count;
    });
    return total;
}

function calculateGrandTotal(results, uniqueFeedbackStatuses, dates) {
    var grandTotal = 0;
    results.forEach(function(item) {
        uniqueFeedbackStatuses.forEach(function(feedbackStatus) {
            dates.forEach(function(date) {
                var count = item.counts.find(function(countItem) {
                    return countItem.date === date && countItem.feedbackStatus === feedbackStatus;
                });
                if (count) {
                    grandTotal += parseInt(count.status_count);
                }
            });
        });
    });
    return grandTotal;
}

    function resetForm() {
        document.getElementById("filterForm").reset();
        $('#table_div').hide();
        $('#downloads').hide();
    }

    function showsortresults() {
    $('#callstatus').toggle();
    
    $('#fromdate, #todate').datepicker({
        maxDate: 0,
        dateFormat: 'yy-mm-dd'
    });

    $('#filterForm').submit(function(e) {
        e.preventDefault();
        var fromDate = $('#fromdate').val();
        var toDate = $('#todate').val();        
        var fromDateObj = new Date(fromDate);
        var toDateObj = new Date(toDate);
        if (fromDateObj >= toDateObj) {
            toastr.error('Please select a valid date range.');
            return;
        }
        var call_status = $('#call_status').val();
        if (!fromDate || !toDate) {
            toastr.error('Please select both Start Date, End Date.');
            return;
        }
        if (!call_status) {
            toastr.error('Please select call status.');
            return;
        }

        var formData = $(this).serialize();
        formData += '&fromdate=' + fromDate + '&todate=' + toDate;
        formData += '&mumbai=' + ($('#mumbai').is(':checked') ? 'mumbai' : '');
        formData += '&pune=' + ($('#pune').is(':checked') ? 'pune' : '');

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Call_Status/filterSubmissionProcesses',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('#loader').show();
            },
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    $('#table_div').show();
                    var results = response.results || [];
                    var dates = response.dates || [];
                    dates.reverse();

                    var headerRow = '<tr><th>Feedback Status</th>';
                    dates.forEach(function(date) {
                        headerRow += '<th>' + date + '</th>';
                    });
                    headerRow += '</tr>';
                    $('#dataTable thead').html(headerRow);
                    var tbodyHtml = '';
                    var uniqueFeedbackStatuses = Object.keys(results[0]);
                    uniqueFeedbackStatuses.splice(uniqueFeedbackStatuses.indexOf('date'), 1);
                    var grandTotal = {};
                    uniqueFeedbackStatuses.forEach(function(feedbackStatus) {
                        var row = '<tr><td>' + feedbackStatus + '</td>';
                        var statusTotal = 0;
                        dates.forEach(function(date) {
                            var count = results.find(function(item) {
                                return item.date === date && item.hasOwnProperty(feedbackStatus);
                            });

                            var countValue = count ? parseInt(count[feedbackStatus]) : 0;
                            row += '<td>' + countValue + '</td>';
                            statusTotal += countValue;
                        });

                        row += '</tr>';
                        tbodyHtml += row;

                        grandTotal[feedbackStatus] = statusTotal;
                    });

                    var grandTotalRow = '<tr><td><strong>Grand Total</strong></td>';
                    dates.forEach(function(date) {
                        var totalForDate = 0;
                        uniqueFeedbackStatuses.forEach(function(feedbackStatus) {
                            totalForDate += parseInt(results.find(function(item) {
                                return item.date === date && item.hasOwnProperty(feedbackStatus);
                            })?.[feedbackStatus] || 0);
                        });
                        grandTotalRow += '<td><strong>' + totalForDate + '</strong></td>';
                    });
                    grandTotalRow += '</tr>';
                    tbodyHtml += grandTotalRow;

                    $('#dataTable tbody').html(tbodyHtml);
                    $('#downloads').show();

                } else {
                    toastr.error('Error: Unable to fetch data.');
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                toastr.error('Error: ' + error);
            }
        });
    });
}


    function exportToExcel() {
        var table = document.getElementById('dataTable');
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet JS"
        });
        XLSX.writeFile(wb, 'Call_Status_Report.xlsx');
    }
</script>