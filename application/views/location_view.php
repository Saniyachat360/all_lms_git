<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<h1 style="text-align:center; ">Location Wise Report</h1>
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
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
              <form action="<?php echo site_url('Location/front_view'); ?> " id="filterForm1" method="post" onsubmit="return validateDates()">
                <select class="filter_s col-md-12 col-xs-12 form-control" name="location" id="location">
                  <option value="all">Please Select</option>
                  <?php foreach ($leads as $lead) : ?>
                    <option value="<?php echo $lead['location']; ?>"><?php echo $lead['location']; ?></option>
                  <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
                <div class="form-group">
                  <input type="date" id="fromdate" value="" class="filter_s col-md-12 col-xs-12 form-control" placeholder="From Date" name="fromdate" readonly style="cursor: default;">
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 20px;">
                <div class="form-group">
                  <input type="date" id="todate" value="" class="filter_s col-md-12 col-xs-12 form-control" placeholder="To Date" name="todate" readonly style="cursor: default;">
                </div>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding: 20px;">
                <div class="form-group">
                  <button type="submit" id="submitButton" class="btn btn-info btn-block">Submit</button>
                </div>
              </div>
            </div>
            </form>

            <!-- Your table -->
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
            <script>
              function validateDates() {
                var fromDate = document.getElementById("fromdate").value;
                var toDate = document.getElementById("todate").value;
                var count = document.getElementById("location").value;
                console.log(count);

                if (count === 'all') {
                  alert("Please select a location");
                  return false;
                }

                if (fromDate === '' || toDate === '') {
                  alert("Please select both From Date and To Date.");
                  return false;
                }

                return true;
              }

              $(document).ready(function() {
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
                  var formData = {
                    start_date: $('#fromdate').val(),
                    end_date: $('#todate').val(),
                    location: $('#location').val(),
                  };
                  $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url(); ?>location/filterSubmissionProcesses1',
                    data: formData,
                    dataType: 'json',
                  
                    success: function(response) {
                      console.log(response);
                      document.getElementById('table_div').style.display = 'block';
                      $('#dataTable tbody').empty();
                      $('#dataTable thead').empty();

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

                      if (response.length) {
                        const dictByDate = {};
                        response.forEach(item => {
                          dictByDate[item.date] = item;
                        });

                        datesArray.reverse();
                        var headerRow = '<tr><th>Date</th>';
                        datesArray.forEach(function(date) {
                          headerRow += '<th>' + date + '</th>';
                        });
                        headerRow += '</tr>';
                        $('#dataTable thead').html(headerRow);

                        var leadrow = '<tr><td>Leads</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            leadrow += '<td>' + dictByDate[date]['total_leads'] + '</td>';
                          } else {
                            leadrow += '<td>NA</td>';
                          }
                        });
                        leadrow += '</tr>';

                        var attemptrow = '<tr><td>Attempt</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            attemptrow += '<td>' + dictByDate[date]['attempt'] + '</td>';
                          } else {
                            attemptrow += '<td>NA</td>';
                          }
                        });
                        attemptrow += '</tr>';

                        var connectedrow = '<tr><td>Connected</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            connectedrow += '<td>' + dictByDate[date]['connected'] + '</td>';
                          } else {
                            connectedrow += '<td>NA</td>';
                          }
                        });
                        connectedrow += '</tr>';

                        var intresteddrow = '<tr><td>Interested</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            intresteddrow += '<td>' + dictByDate[date]['interested'] + '</td>';
                          } else {
                            intresteddrow += '<td>NA</td>';
                          }
                        });
                        intresteddrow += '</tr>';

                        var assignedrow = '<tr><td>Assigned</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            assignedrow += '<td>' + dictByDate[date]['total_leads'] + '</td>';
                          } else {
                            assignedrow += '<td>NA</td>';
                          }
                        });
                        assignedrow += '</tr>';

                        var testdriverow = '<tr><td>Test Drive</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            testdriverow += '<td>' + dictByDate[date]['Test_Drive'] + '</td>';
                          } else {
                            testdriverow += '<td>NA</td>';
                          }
                        });
                        testdriverow += '</tr>';

                        var bookingrow = '<tr><td>Booking</td>';
                        datesArray.forEach(function(date) {
                          if (dictByDate[date]) {
                            bookingrow += '<td>' + dictByDate[date]['Booked'] + '</td>';
                          } else {
                            bookingrow += '<td>NA</td>';
                          }
                        });
                        bookingrow += '</tr>';

                        $('#dataTable tbody').html(leadrow + attemptrow + connectedrow + intresteddrow + assignedrow + testdriverow + bookingrow);
                      } else {
                        var headerRow = '<tr><th></th></tr>';
                        $('#dataTable thead').html(headerRow);

                        var noDataRow = '<tr><td class="text-center" colspan="100%">No records found for the selected date range</td></tr>';
                        $('#dataTable tbody').html(noDataRow);
                      }
                    },

                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  });
                });
              });
            </script>