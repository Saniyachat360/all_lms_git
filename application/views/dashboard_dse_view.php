<script src="<?php echo base_url(); ?>assets/js/download_excel/FileSaver.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/download_excel/tableexport.min.js"></script>


<style>
  .btn-toolbar .btn {
    background-color: #1988b6;
    color: #fff;
    float: right;
  }

  .btn-default,
  .btn-default:hover {
    background-color: #1988b6;
    color: #fff;
    float: right;
  }
</style>


<div class="row">
  <h1 style="text-align:center; ">DSE Dashboard</h1>
  <div class="col-md-12">
    <div class="panel panel-primary">
      <?php
      /*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){}else{ */ ?>
      <div class="panel-body">

        <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

          <div class="col-md-12">

            <div class="form-group  col-md-2" style="padding:20px;">
              <!--	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>-->

              <select id="location" class="form-control" onchange="get_tl()" required name="location">

                <option value="">Select Location</option>
                <?php foreach ($select_location as $location) { ?>
                  <option value="<?php echo $location->location_id;
                                  $location->location ?>"><?php echo $location->location; ?></option>
                <?php } ?>

              </select>

            </div>
            <div class="form-group col-md-2" id="tl_div" style="padding:20px;">
              <select class="form-control" id="tl_id" name="tl_id" onchange="get_dse()">
                <option value="">Select TL</option>
              </select>
            </div>

            <div class="form-group col-md-2" id="dse_div" style="padding:20px;">
              <select class="form-control" id="user_id" name="user_id">
                <option value="">Select DSE Name</option>
              </select>
            </div>

            <div class="col-md-2" style="padding:20px;">
              <div class="form-group">
                <select class="form-control" onchange='dateRangeShow(this.value)' id="date_type" name="date_type">
                  <option value="">Select Date Type</option>
                  <option value="As on Date">As on Date</option>
                  <option value="Date Range">Date Range</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-2" style="padding:20px;">
              <input type="text" id="from_date" name="from_date" class="form-control datett" placeholder="From Date">
            </div>
            <div class="form-group col-md-2" id='todateDiv' style="padding:20px;">
              <input type="text" id="to_date" name="to_date" class="form-control datett" placeholder="To Date">
            </div>

            <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
              <div class="form-group">
                <button type="submit" class="btn btn-info" id="toggle" onclick="search();"><i class="entypo-search"> Search</i></button>
                <!--  <a target="_blank" href="<?php echo site_url('new_tracker/download_data/?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type); ?>" >--></a>
                <a onclick="reset()"> <i class="btn btn-success entypo-ccw"> Reset</i></a>
              </div>
            </div>

          </div>
        </div>
      </div><?php // } 
            ?>
    </div>
  </div>
</div>
<div class="row" id="table_div">
  <div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
</div>

<script>
  function dateRangeShow(val) {
    if (val == "As on Date") {
      document.getElementById("to_date").disabled = true;
      var hiddenDiv = document.getElementById("todateDiv");
      hiddenDiv.style.display = "none";
      document.getElementById("from_date").placeholder = "Date";
    } else {
      var hiddenDiv = document.getElementById("todateDiv");
      hiddenDiv.style.display = "block";
      document.getElementById("to_date").disabled = false;
      document.getElementById("from_date").placeholder = "From Date";
    }
  }

  function search() {
    var from_date = document.getElementById("from_date").value;
    var to_date = document.getElementById("to_date").value;
    var dse_id = document.getElementById("user_id").value;

    var l = document.getElementById("location");
    var location = l.value;
    var location_name = l.options[l.selectedIndex].text;

    var date_type = document.getElementById("date_type").value;
    var tl_id = document.getElementById("tl_id").value;

    // console.log('hello' + from_date, to_date, dse_id, location,date_type,tl_id);

    if (location == '') {
      alert("Please select Location");
      return false;
    } else if (date_type == '') {
      alert("Please select Date Type");
      return false;
    } else if (date_type == "As on Date" && from_date == '') {
      alert("Please Select Date");
      return false;
    } else if (date_type != "As on Date" && (from_date == '' || to_date == '')) {
      alert("Please Select From Date and To Date");
      return false;
    }

    //Create Loaderdashboard_dse
    // src1 = "<?php echo base_url('assets/images/loader200.gif'); ?>";
    // var elem = document.createElement("img");
    // elem.setAttribute("src", src1);
    // elem.setAttribute("height", "95");
    // elem.setAttribute("width", "250");
    // elem.setAttribute("alt", "loader");

    // document.getElementById("blah").appendChild(elem);
    $.ajax({
      url: ' <?php echo site_url(); ?>dashboard_dse/search_dse_performance',
      type: 'POST',
      data: {
        dse_id: dse_id,
        from_date: from_date,
        to_date: to_date,
        location: location,
        location_name: location_name,
        date_type: date_type,
        tl_id: tl_id
      },
      success: function(result) {
        $("#table_div").html(result);
      }
    });
  }

  function clear() {
    document.getElementById("location").innerHTML = '';

    document.getElementById("from_date").innerHTML = '';
    document.getElementById("to_date").innerHTML = '';

    document.getElementById("user_id").innerHTML = '';
    document.getElementById("tl_id").innerHTML = '';


  }

  function get_tl() {
    var location = document.getElementById("location").value;
    $.ajax({
      url: '<?php echo site_url('dashboard_dse/get_tl') ?>',
      type: 'POST',
      data: {
        location: location
      },
      success: function(response) {
        $("#tl_div").html(response);
      }
    });
  }

  function get_dse() {
    var location = document.getElementById("location").value;

    var tl_id = document.getElementById("tl_id").value;
    // alert(tl_id);
    $.ajax({
      url: '<?php echo site_url('dashboard_dse/get_dse') ?>',
      type: 'POST',
      data: {
        location: location,
        tl_id: tl_id
      },
      success: function(response) {
        $("#dse_div").html(response);
      }
    });
  }

  $(document).ready(function() {
    $('.datett').daterangepicker({
      singleDatePicker: true,
      format: 'YYYY-MM-DD',
      calender_style: "picker_1"
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });

  });
</script>

<style>
  * {
    box-sizing: border-box;
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
  }

  /* Float four columns side by side */
  .column {
    float: left;
    width: 25%;
    padding: 0 10px;
  }

  /* Remove extra left and right margins, due to padding */
  .row {
    margin: 0 -5px;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  /* Responsive columns */
  @media screen and (max-width: 600px) {
    .column {
      width: 100%;
      display: block;
      margin-bottom: 20px;
    }
  }

  /* Style the counter cards */
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    padding: 10px;
    text-align: center;
    background-color: #f1f1f1;
  }
</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet">

<style type="text/css">
  a {
    text-decoration: none;
    color: #5e72e4;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
  }

  a:hover {
    text-decoration: none;
    color: #233dd2;
  }

  a:not([href]):not([tabindex]) {
    text-decoration: none;
    color: inherit;
  }

  a:not([href]):not([tabindex]):hover,
  a:not([href]):not([tabindex]):focus {
    text-decoration: none;
    color: inherit;
  }

  a:not([href]):not([tabindex]):focus {
    outline: 0;
  }


  button {
    border-radius: 0;
  }

  button:focus {
    outline: 1px dotted;
    outline: 5px auto -webkit-focus-ring-color;
  }

  input,
  button {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    margin: 0;
  }

  button,
  input {
    overflow: visible;
  }

  button {
    text-transform: none;
  }

  button,
  [type='reset'],
  [type='submit'] {
    -webkit-appearance: button;
  }

  button::-moz-focus-inner,
  [type='button']::-moz-focus-inner,
  [type='reset']::-moz-focus-inner,
  [type='submit']::-moz-focus-inner {
    padding: 0;
    border-style: none;
  }

  input[type='radio'],
  input[type='checkbox'] {
    box-sizing: border-box;
    padding: 0;
  }

  input[type='date'],
  input[type='time'],
  input[type='datetime-local'],
  input[type='month'] {
    -webkit-appearance: listbox;
  }

  legend {
    font-size: 1.5rem;
    line-height: inherit;
    display: block;
    width: 100%;
    max-width: 100%;
    margin-bottom: .5rem;
    padding: 0;
    white-space: normal;
    color: inherit;
  }

  [type='number']::-webkit-inner-spin-button,
  [type='number']::-webkit-outer-spin-button {
    height: auto;
  }

  [type='search'] {
    outline-offset: -2px;
    -webkit-appearance: none;
  }

  [type='search']::-webkit-search-cancel-button,
  [type='search']::-webkit-search-decoration {
    -webkit-appearance: none;
  }

  ::-webkit-file-upload-button {
    font: inherit;
    -webkit-appearance: button;
  }

  [hidden] {
    display: none !important;
  }

  h2,
  h5,
  .h2,
  .h5 {
    font-family: inherit;
    font-weight: 600;
    line-height: 1.5;
    margin-bottom: .5rem;
    color: #32325d;
  }

  h2,
  .h2 {
    font-size: 1.25rem;
  }

  h5,
  .h5 {
    font-size: .8125rem;
  }

  .col,
  .col-auto,
  .col-lg-6,
  .col-xl-3,
  .col-xl-6 {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
  }

  .col {
    max-width: 100%;
    flex-basis: 0;
    flex-grow: 1;
  }

  .col-auto {
    width: auto;
    max-width: none;
    flex: 0 0 auto;
  }

  @media (min-width: 992px) {
    .col-lg-6 {
      max-width: 50%;
      flex: 0 0 50%;
    }
  }

  @media (min-width: 1200px) {
    .col-xl-3 {
      max-width: 25%;
      flex: 0 0 25%;
    }

    .col-xl-6 {
      max-width: 50%;
      flex: 0 0 50%;
    }
  }

  .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    border: 1px solid rgba(0, 0, 0, .05);
    border-radius: .375rem;
    background-color: #fff;
    background-clip: border-box;
  }

  .card-body {
    padding: 1rem;
    flex: 1 1 auto;
  }

  .card-title {
    margin-bottom: 1.25rem;
  }

  @keyframes progress-bar-stripes {
    from {
      background-position: 1rem 0;
    }

    to {
      background-position: 0 0;
    }
  }

  .bg-info {
    background-color: #11cdef !important;
  }

  a.bg-info:hover,
  a.bg-info:focus,
  button.bg-info:hover,
  button.bg-info:focus {
    background-color: #0da5c0 !important;
  }

  .bg-warning {
    background-color: #fb6340 !important;
  }

  a.bg-warning:hover,
  a.bg-warning:focus,
  button.bg-warning:hover,
  button.bg-warning:focus {
    background-color: #fa3a0e !important;
  }

  .bg-danger {
    background-color: #f5365c !important;
  }

  a.bg-danger:hover,
  a.bg-danger:focus,
  button.bg-danger:hover,
  button.bg-danger:focus {
    background-color: #ec0c38 !important;
  }

  .bg-default {
    background-color: #172b4d !important;
  }

  a.bg-default:hover,
  a.bg-default:focus,
  button.bg-default:hover,
  button.bg-default:focus {
    background-color: #0b1526 !important;
  }

  .rounded-circle {
    border-radius: 50% !important;
  }

  .align-items-center {
    align-items: center !important;
  }

  @media (min-width: 1200px) {
    .justify-content-xl-between {
      justify-content: space-between !important;
    }
  }

  .shadow {
    box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
  }

  .mb-0 {
    margin-bottom: 0 !important;
  }

  .mr-2 {
    margin-right: .5rem !important;
  }

  .mt-3 {
    margin-top: 1rem !important;
  }

  .mb-4 {
    margin-bottom: 1.5rem !important;
  }

  .mb-5 {
    margin-bottom: 3rem !important;
  }

  .pt-5 {
    padding-top: 3rem !important;
  }

  .pb-8 {
    padding-bottom: 8rem !important;
  }

  .m-auto {
    margin: auto !important;
  }

  @media (min-width: 768px) {
    .pt-md-8 {
      padding-top: 8rem !important;
    }
  }

  @media (min-width: 1200px) {
    .mb-xl-0 {
      margin-bottom: 0 !important;
    }
  }

  .text-nowrap {
    white-space: nowrap !important;
  }

  .text-center {
    text-align: center !important;
  }

  .text-uppercase {
    text-transform: uppercase !important;
  }

  .font-weight-bold {
    font-weight: 600 !important;
  }

  .text-white {
    color: #fff !important;
  }

  .text-success {
    color: #2dce89 !important;
  }

  a.text-success:hover,
  a.text-success:focus {
    color: #24a46d !important;
  }

  .text-warning {
    color: #fb6340 !important;
  }

  a.text-warning:hover,
  a.text-warning:focus {
    color: #fa3a0e !important;
  }

  .text-danger {
    color: #f5365c !important;
  }

  a.text-danger:hover,
  a.text-danger:focus {
    color: #ec0c38 !important;
  }

  .text-white {
    color: #fff !important;
  }

  a.text-white:hover,
  a.text-white:focus {
    color: #e6e6e6 !important;
  }

  .text-muted {
    color: #8898aa !important;
  }

  @media print {

    *,
    *::before,
    *::after {
      box-shadow: none !important;
      text-shadow: none !important;
    }

    a:not(.btn) {
      text-decoration: underline;
    }

    p,
    h2 {
      orphans: 3;
      widows: 3;
    }

    h2 {
      page-break-after: avoid;
    }

    @page {
      size: a3;
    }

    body {
      min-width: 992px !important;
    }
  }

  figcaption,
  main {
    display: block;
  }

  main {
    overflow: hidden;
  }

  .bg-yellow {
    background-color: #ffd600 !important;
  }

  a.bg-yellow:hover,
  a.bg-yellow:focus,
  button.bg-yellow:hover,
  button.bg-yellow:focus {
    background-color: #ccab00 !important;
  }

  .bg-gradient-primary {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
  }

  .bg-gradient-primary {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
  }

  @keyframes floating-lg {
    0% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(15px);
    }

    100% {
      transform: translateY(0px);
    }
  }

  @keyframes floating {
    0% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(10px);
    }

    100% {
      transform: translateY(0px);
    }
  }

  @keyframes floating-sm {
    0% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(5px);
    }

    100% {
      transform: translateY(0px);
    }
  }

  [class*='shadow'] {
    transition: all .15s ease;
  }

  .text-sm {
    font-size: .875rem !important;
  }

  .text-white {
    color: #fff !important;
  }

  a.text-white:hover,
  a.text-white:focus {
    color: #e6e6e6 !important;
  }

  [class*='btn-outline-'] {
    border-width: 1px;
  }

  .card-stats .card-body {
    padding: 1rem 1.5rem;
  }

  .main-content {
    position: relative;
  }

  @media (min-width: 768px) {
    .main-content .container-fluid {
      padding-right: 20px !important;
      padding-left: 20px !important;
    }
  }

  .footer {
    padding: 1rem 0;
    background: #f7fafc;
  }

  .footer .copyright {
    font-size: .875rem;
  }

  .header {
    position: relative;
  }

  .icon {
    width: 3rem;
    height: 3rem;
  }

  .icon i {
    font-size: 2.25rem;
  }

  .icon-shape {
    display: inline-flex;
    padding: 12px;
    text-align: center;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
  }

  .icon-shape i {
    font-size: 1.25rem;
  }

  @media (min-width: 768px) {
    @keyframes show-navbar-dropdown {
      0% {
        transition: visibility .25s, opacity .25s, transform .25s;
        transform: translate(0, 10px) perspective(200px) rotateX(-2deg);
        opacity: 0;
      }

      100% {
        transform: translate(0, 0);
        opacity: 1;
      }
    }

    @keyframes hide-navbar-dropdown {
      from {
        opacity: 1;
      }

      to {
        transform: translate(0, 10px);
        opacity: 0;
      }
    }
  }

  @keyframes show-navbar-collapse {
    0% {
      transform: scale(.95);
      transform-origin: 100% 0;
      opacity: 0;
    }

    100% {
      transform: scale(1);
      opacity: 1;
    }
  }

  @keyframes hide-navbar-collapse {
    from {
      transform: scale(1);
      transform-origin: 100% 0;
      opacity: 1;
    }

    to {
      transform: scale(.95);
      opacity: 0;
    }
  }

  p {
    font-size: 1rem;
    font-weight: 300;
    line-height: 1.7;
  }
</style>


<br>

<!-- ********** Charts with responsive *********** -->

<div class="main-content">
  <div class="container-fluid">
    <div class="header-body">

      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/exporting.js"></script>
                <script src="https://code.highcharts.com/modules/export-data.js"></script>
                <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
                <figure class="highcharts-figure">
                  <div id="container"></div>
                </figure>

                <style>
                  .highcharts-figure,
                  .highcharts-data-table table {
                    min-width: 200px;
                    max-width: auto;
                    /* margin: 1em auto; */
                  }

                  #container {
                    height: 400px;
                  }

                  .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #ebebeb;
                    /* margin: 10px auto; */
                    text-align: center;
                    width: auto;
                    max-width: 500px;
                  }

                  .highcharts-data-table caption {
                    /* padding: 1em 0; */
                    font-size: 1.2em;
                    color: #555;
                  }

                  .highcharts-data-table th {
                    font-weight: 600;
                    /* padding: 0.5em; */
                  }

                  .highcharts-data-table td,
                  .highcharts-data-table th,
                  .highcharts-data-table caption {
                    padding: 0.5em;
                  }

                  .highcharts-data-table thead tr,
                  .highcharts-data-table tr:nth-child(even) {
                    background: #f8f8f8;
                  }

                  .highcharts-data-table tr:hover {
                    background: #f1f7ff;
                  }
                </style>


                <!-- start lead flow history -->
                <?php
                $query_dec = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-12%'");
                $lead_dec =  $query_dec->num_rows();

                $query_nov = $this->db->query("SELECT created_date  FROM lead_master WHERE  created_date LIKE '2022-11%'");
                $lead_nov =  $query_nov->num_rows();

                $query_oct = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-10%'");
                $lead_oct =  $query_oct->num_rows();

                $query_sept = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-09%'");
                $lead_sept =  $query_sept->num_rows();

                $query_aug = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-08%'");
                $lead_aug =  $query_aug->num_rows();

                $query_july = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-07%'");
                $lead_july =  $query_july->num_rows();

                $query_jun = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-06%'");
                $lead_jun =  $query_jun->num_rows();

                $query_may = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-05%'");
                $lead_may =  $query_may->num_rows();

                $query_apr = $this->db->query("SELECT created_date FROM lead_master WHERE  created_date LIKE '2022-04%'");
                $lead_apr =  $query_apr->num_rows();

                $query_march = $this->db->query("SELECT created_date FROM lead_master WHERE created_date LIKE '2022-03%'");
                $lead_march =  $query_march->num_rows();

                $query_feb = $this->db->query("SELECT created_date FROM lead_master WHERE created_date LIKE '2022-02%'");
                $lead_feb =  $query_feb->num_rows();

                $query_jan = $this->db->query("SELECT created_date FROM lead_master WHERE created_date LIKE '2022-01%'");
                $lead_jan =  $query_jan->num_rows();

                ?>               

                <script>
                  let jan = <?php echo $lead_jan ?>;
                  let feb = <?php echo $lead_feb ?>;
                  let mar = <?php echo $lead_march ?>;
                  let apr = <?php echo $lead_apr ?>;
                  let may = <?php echo $lead_may ?>;
                  let jun = <?php echo $lead_jun ?>;
                  let jul = <?php echo $lead_july ?>;
                  let aug = <?php echo $lead_aug ?>;
                  let sep = <?php echo $lead_sept ?>;
                  let oct = <?php echo $lead_oct ?>;
                  let nov = <?php echo $lead_nov ?>;
                  let dec = <?php echo $lead_dec ?>;

                  Highcharts.chart('container', {
                    chart: {
                      type: 'column'
                    },
                    title: {
                      text: 'Lead Flow History - 2022'
                    },
                    xAxis: {
                      categories: [
                        'Jan 22',
                        'Feb 22',
                        'Mar 22',
                        'Apr 22',
                        'May 22',
                        'Jun 22',
                        'Jul 22',
                        'Aug 22',
                        'Sep 22',
                        'Oct 22',
                        'Nov 22',
                        'Dec 22'
                      ],
                      crosshair: true
                    },
                    tooltip: {
                      headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                      footerFormat: '</table>',
                      shared: true,
                      useHTML: true
                    },
                    credits: {
                      enabled: false
                    },
                    plotOptions: {
                      column: {
                        dataLabels: {
                          enabled: true
                        },
                        pointPadding: 0.2,
                        borderWidth: 0
                      }
                    },
                    series: [{
                      name: 'Lead Flow History',

                      data: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
                      color: {
                        linearGradient: {
                          x1: 0,
                          x2: 0,
                          y1: 0,
                          y2: 1
                        },
                        stops: [
                          [0, '#8dd0dc'],
                          [1, '#dfebe5']
                        ]
                      },
                    }]
                  });
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- eof lead flow histroy -->

      <br>

      <!-- start call intent anlysis -->
      <div class="row">
        <div class="col-xl-6 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <?php
                $query_b30 = $this->db->query("SELECT days60_booking FROM `lead_master` WHERE `days60_booking` = '30'");
                $lead_b30 =  $query_b30->num_rows();

                $query_b60 = $this->db->query("SELECT days60_booking FROM `lead_master` WHERE `days60_booking` = '60'");
                $lead_b60 =  $query_b60->num_rows();

                $query_b90 = $this->db->query("SELECT days60_booking FROM `lead_master` WHERE `days60_booking` = '90'");
                $lead_b90 =  $query_b90->num_rows();

                $query_bimmediate = $this->db->query("SELECT days60_booking FROM `lead_master` WHERE `days60_booking` = 'Immediate'");
                $lead_bimmediate =  $query_bimmediate->num_rows();

                $query_reserching = $this->db->query("SELECT days60_booking FROM `lead_master` WHERE `days60_booking` = 'Just Researching'");
                $lead_reserching =  $query_reserching->num_rows();

                $query_undecide = $this->db->query("SELECT days60_booking FROM `lead_master` WHERE `days60_booking` = 'Undecided'");
                $lead_undecide =  $query_undecide->num_rows();
                ?>

                <figure class="highcharts-figure">
                  <div id="container1"></div>
                </figure>
                <script>
                  Highcharts.chart('container1', {
                    chart: {
                      type: 'variablepie'
                    },
                    title: {
                      text: 'Customer Intent Analysis'
                    },
                    tooltip: {
                      headerFormat: '',
                      pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br />'
                    },
                    credits: {
                      enabled: false
                    },
                    series: [{
                      minPointSize: 10,
                      innerSize: '20%',
                      zMin: 0,
                      name: 'Booking within days',
                      data: [{
                        name: '30 Booking Days: <?php echo $lead_b30; ?>',
                        y: <?php echo $lead_b30; ?>,
                        z: 10
                      }, {
                        name: '60 Booking Days: <?php echo $lead_b60; ?>',
                        y: <?php echo $lead_b60; ?>,
                        z: 10
                      }, {
                        name: '90 Booking Days: <?php echo $lead_b90; ?>',
                        y: <?php echo $lead_b90; ?>,
                        z: 10
                      }, {
                        name: 'Immediate: <?php echo $lead_bimmediate; ?>',
                        y: <?php echo $lead_bimmediate; ?>,
                        z: 10
                      }, {
                        name: 'Just Researching: <?php echo $lead_reserching; ?>',
                        y: <?php echo $lead_reserching; ?>,
                        z: 10
                      }, {
                        name: 'Undecided: <?php echo $lead_undecide; ?>',
                        y: <?php echo $lead_undecide; ?>,
                        z: 10
                      }]
                    }]
                  });
                </script>

                <style>
                  #container1 {
                    height: 400px;
                  }
                </style>
              </div>
            </div>
          </div>
        </div>
        <!-- eof call intent anlysis -->

        <!-- start call status analysis -->
        <div class="col-xl-6 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <figure class="highcharts-figure">
                  <div id="container2"></div>
                </figure>
                <?php
                $query_not_connect = $this->db->query("SELECT contactibility FROM lead_followup WHERE contactibility='Not Connected' ");
                $not_connected =  $query_not_connect->num_rows();

                $query_connected = $this->db->query("SELECT contactibility FROM lead_followup WHERE  contactibility='Connected'");
                $connected =  $query_connected->num_rows();
                ?>
                <script>
                  Highcharts.chart('container2', {
                    chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                    },
                    title: {
                      text: 'Call Status Analysis'
                    },
                    tooltip: {
                      pointFormat: '{series.name}: <b>{point.y}</b>'
                    },
                    credits: {
                      enabled: false
                    },

                    accessibility: {
                      point: {
                        valueSuffix: '%'
                      }
                    },
                    plotOptions: {
                      pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '<b>{point.name}</b>: {point.y}'
                        }
                      }
                    },
                    series: [{
                      name: 'Call Status',
                      colorByPoint: true,
                      colors: ['#00DCD2', '#DC3200'],
                      data: [{
                        name: 'Connected',
                        y: <?php echo $connected; ?>
                      }, {
                        name: 'Not Connected',
                        y: <?php echo $not_connected; ?>
                      }],

                    }]
                  });
                </script>

                <style>
                  #container2 {
                    height: 400px;
                  }
                </style>
              </div>
            </div>
          </div>
        </div>
        <!-- eof call status analysis -->
      </div>

      <br>

      <!-- start lead type analysis -->
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <figure class="highcharts-figure">
                  <div id="container3"></div>
                </figure>

                <?php
                $interested_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Interested'");
                $interested =  $interested_q->num_rows();

                $not_interested_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Not Interested'");
                $not_interested =  $not_interested_q->num_rows();

                $undecided_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Undecided'");
                $undecided =  $undecided_q->num_rows();

                $already_booked_from_us_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Already Booked From Us'");
                $already_booked_from_us =  $already_booked_from_us_q->num_rows();

                $colour_and_model_availability_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Colour And Model Availability'");
                $colour_and_model_availability =  $colour_and_model_availability_q->num_rows();

                $family_choice_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Family Choice'");
                $family_choice =  $family_choice_q->num_rows();

                $invalid_number_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Invalid Number'");
                $invalid_number =  $invalid_number_q->num_rows();

                $lost_to_co_dealer_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Lost To Co-Dealer'");
                $lost_to_co_dealer =  $lost_to_co_dealer_q->num_rows();

                $nearest_dealership_available_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Nearest Dealership Available'");
                $nearest_dealership_available =  $nearest_dealership_available_q->num_rows();

                $not_responding_multiple_attempts_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Not Responding-Multiple Attempts'");
                $not_responding_multiple_attempts =  $not_responding_multiple_attempts_q->num_rows();

                $outstation_purchase_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Outstation Purchase'");
                $outstation_purchase =  $outstation_purchase_q->num_rows();

                $plan_cancelled_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Plan Cancelled'");
                $plan_cancelled =  $plan_cancelled_q->num_rows();

                $wrong_number_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Wrong Number'");
                $wrong_number =  $wrong_number_q->num_rows();

                $service_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Service'");
                $service =  $service_q->num_rows();

                $insurance_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Insurance'");
                $insurance =  $insurance_q->num_rows();

                $booked_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Booked'");
                $booked =  $booked_q->num_rows();

                $ringing_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Ringing'");
                $ringing =  $ringing_q->num_rows();

                $not_reachable_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Not Reachable'");
                $not_reachable =  $not_reachable_q->num_rows();

                $switched_off_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Switched Off'");
                $switched_off =  $switched_off_q->num_rows();

                $others_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Others'");
                $others =  $others_q->num_rows();

                $lost_to_competitor_brand_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Lost To Competitor Brand'");
                $lost_to_competitor_brand =  $lost_to_competitor_brand_q->num_rows();

                $budget_issue_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Budget Issue'");
                $budget_issue =  $budget_issue_q->num_rows();

                $negative_feedback_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Negative feedback'");
                $negative_feedback =  $negative_feedback_q->num_rows();

                $duplicate_entry_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Duplicate Entry'");
                $duplicate_entry =  $duplicate_entry_q->num_rows();

                $busy_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Busy'");
                $busy =  $busy_q->num_rows();

                $lead_transfer_to_other_process_q = $this->db->query("SELECT feedbackStatus FROM lead_master WHERE feedbackStatus = 'Lead Transfer To Other Process'");
                $lead_transfer_to_other_process =  $lead_transfer_to_other_process_q->num_rows();
                ?>                

                <script>
                  let interested = <?php echo $interested ?>;
                  let not_interested = <?php echo $not_interested ?>;
                  let undecided = <?php echo $undecided ?>;
                  let already_booked_from_us = <?php echo $already_booked_from_us ?>;
                  let colour_and_model_availability = <?php echo $colour_and_model_availability ?>;
                  let family_choice = <?php echo $family_choice ?>;
                  let invalid_number = <?php echo $invalid_number ?>;
                  let lost_to_co_dealer = <?php echo $lost_to_co_dealer ?>;
                  let nearest_dealership_available = <?php echo $nearest_dealership_available ?>;
                  let not_responding_multiple_attempts = <?php echo $not_responding_multiple_attempts ?>;
                  let outstation_purchase = <?php echo $outstation_purchase ?>;
                  let plan_cancelled = <?php echo $plan_cancelled ?>;
                  let wrong_number = <?php echo $wrong_number ?>;
                  let service = <?php echo $service ?>;
                  let insurance = <?php echo $insurance ?>;
                  let booked = <?php echo $booked ?>;
                  let ringing = <?php echo $ringing ?>;
                  let not_reachable = <?php echo $not_reachable ?>;
                  let switched_off = <?php echo $switched_off ?>;
                  let others = <?php echo $others ?>;
                  let lost_to_competitor_brand = <?php echo $lost_to_competitor_brand ?>;
                  let budget_issue = <?php echo $budget_issue ?>;
                  let negative_feedback = <?php echo $negative_feedback ?>;
                  let duplicate_entry = <?php echo $duplicate_entry ?>;
                  let busy = <?php echo $busy ?>;
                  let lead_transfer_to_other_process = <?php echo $lead_transfer_to_other_process ?>;

                  Highcharts.chart('container3', {
                    chart: {
                      type: 'column'
                    },
                    title: {
                      text: 'Lead Type Analysis '
                    },
                    xAxis: {
                      categories: ['Interested', 'Not Interested', 'Undecided', 'Already Booked From Us', 'Colour & Model Availability', 'Family Choice',
                        'Invalid Number', 'Lost To Co-Dealer', 'Nearest Dealer Available', 'Not Responding', 'Outstation Purchase', 'Plan Cancelled',
                        'Wrong Number', 'Service', 'Insurance', 'Booked', 'Ringing', 'Not Reachable', 'Switched Off', 'Others', 'Lost To Competitor', 'Budget Issue',
                        'Negative Feedback', 'Duplicate Entry', 'Busy', 'Transfer to Other Process'
                      ],


                      title: {
                        text: null
                      }
                    },
                    tooltip: {
                      headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                      footerFormat: '</table>',
                      shared: true,
                      useHTML: true
                    },
                    credits: {
                      enabled: false
                    },
                    plotOptions: {
                      column: {
                        dataLabels: {
                          enabled: true
                        },
                        pointPadding: 0.2,
                        borderWidth: 0
                      }
                    },
                    series: [{
                      name: 'Lead Type Analysis',

                      data: [interested, not_interested, undecided, already_booked_from_us, colour_and_model_availability,
                        family_choice, invalid_number, lost_to_co_dealer, nearest_dealership_available, not_responding_multiple_attempts,
                        outstation_purchase, plan_cancelled, wrong_number, service, insurance, booked, ringing, not_reachable, switched_off,
                        others, lost_to_competitor_brand, budget_issue, negative_feedback, duplicate_entry, busy, lead_transfer_to_other_process
                      ],
                      color: {
                        linearGradient: {
                          x1: 0,
                          x2: 0,
                          y1: 0,
                          y2: 1
                        },
                        stops: [
                          [0, '#8dd0dc'],
                          [1, '#dfebe5']
                        ]
                      },
                    }]
                  });
                </script>

                <style>
                  #container3 {
                    height: auto;
                  }
                </style>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- eof lead type analysis  -->

      <br>


      <div class="row">
        <!-- start fuel_type flow chart -->
        <div class="col-xl-6 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <figure class="highcharts-figure">
                  <div id="container4"></div>
                </figure>

                <?php
                $query_cng = $this->db->query("SELECT fuel_type FROM lead_master WHERE fuel_type='CNG' ");
                $lead_cng =  $query_cng->num_rows();

                $query_petrol = $this->db->query("SELECT fuel_type FROM lead_master WHERE  fuel_type='Petrol'");
                $lead_petrol =  $query_petrol->num_rows();
                ?>

                <script>                 

                  // Build the chart
                  Highcharts.chart('container4', {
                    chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                    },
                    title: {
                      text: 'Fuel type Analysis'
                    },
                    tooltip: {
                      pointFormat: '{series.name}: <b>{point.y}</b>'
                    },
                    credits: {
                      enabled: false
                    },
                    accessibility: {
                      point: {
                        valueSuffix: ' '
                      }
                    },
                    plotOptions: {
                      pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '<b>{point.name}</b>: {point.y} ',
                          connectorColor: 'silver'
                        }
                      }
                    },
                    series: [{
                      name: 'Fuel Type',
                      colorByPoint: true,                  
                      colors: ['#1A7EEF', '#44C754'],
                      data: [{
                          name: 'Petrol',
                          y: <?php echo $lead_cng; ?>
                        },
                        {
                          name: 'CNG',
                          y: <?php echo $lead_petrol; ?>
                        }
                      ]
                    }]
                  });
                </script>

                <style>
                  #container4 {
                    height: 400px;
                  }
                </style>
              </div>
            </div>
          </div>
        </div>
        <!-- eof fuel_type flow chart -->

        <!-- start Stock Enquiry flow chart -->
        <div class="col-xl-6 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <figure class="highcharts-figure">
                  <div id="container5"></div>
                </figure>

                <?php
                $query_yes = $this->db->query("SELECT stock FROM lead_master WHERE stock LIKE 'yes' ");
                $lead_yes =  $query_yes->num_rows();

                $query_no = $this->db->query("SELECT stock FROM lead_master WHERE  stock LIKE 'no'");
                $lead_no =  $query_no->num_rows();           

                ?>

                <script>
                  // Highcharts.setOptions({
                  //   colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                  //     return {
                  //       radialGradient: {
                  //         cx: 0.5,
                  //         cy: 0.3,
                  //         r: 0.7
                  //       },
                  //       stops: [
                  //         [0, color],
                  //         [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                  //       ]
                  //     };
                  //   })
                  // });

                  // Build the chart
                  Highcharts.chart('container5', {
                    chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                    },
                    title: {
                      text: 'Stock Enquiry'
                    },
                    tooltip: {
                      pointFormat: '{series.name}: <b>{point.y}</b>'
                    },
                    credits: {
                      enabled: false
                    },
                    accessibility: {
                      point: {
                        valueSuffix: ' '
                      }
                    },
                    plotOptions: {
                      pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '<b>{point.name}</b>: {point.y} ',
                          connectorColor: 'silver'
                        }
                      }
                    },
                    series: [{
                      name: 'Stock Enquiry',
                      colorByPoint: true,                  
                      colors: ['#F58713', '#FAF30B'],
                      data: [{
                          name: 'Yes',                       
                          y: <?php echo $lead_yes; ?>
                        },
                        {
                          name: 'No',                         
                          y: <?php echo $lead_no; ?>
                        }
                      ]
                    }]
                  });
                </script>

                <style>
                  #container5 {
                    height: 400px;
                  }
                </style>
              </div>
            </div>
          </div>
        </div>
        <!-- eof stock point -->
      </div>

      <br>

      <!-- start sourcewise analysis -->
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="row">
              <div class="col">
                <figure class="highcharts-figure">
                  <div id="container6"></div>
                </figure>

                <?php

                $carwale_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Carwale'");
                $carwale =  $carwale_q->num_rows();

                $cardekho_API_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Cardekho API'");
                $cardekho_API =  $cardekho_API_q->num_rows();

                $chat360_bot_API_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Chat360 Bot API'");
                $chat360_bot_API =  $chat360_bot_API_q->num_rows();

                $evaluation_data_showroom_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Evaluations Data Showroom'");
                $evaluation_data_showroom =  $evaluation_data_showroom_q->num_rows();

                $facebook_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Facebook'");
                $facebook =  $facebook_q->num_rows();

                $facebook_sprinklr_comment_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Facebook Sprinklr Comment'");
                $facebook_sprinklr_comment =  $facebook_sprinklr_comment_q->num_rows();

                $gaadibaazar_web_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Gaadibaazar Web'");
                $gaadibaazar_web =  $gaadibaazar_web_q->num_rows();

                $hyperlocal_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Hyperlocal'");
                $hyperlocal =  $hyperlocal_q->num_rows();

                $hyperlocal_facebook_lead_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'HYPERLOCAL FACEBOOK LEADS'");
                $hyperlocal_facebook_lead =  $hyperlocal_facebook_lead_q->num_rows();

                $hyperlocal_feedback_contact_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'HYPERLOCAL FEEDBACK AND CONTACT'");
                $hyperlocal_feedback_contact =  $hyperlocal_feedback_contact_q->num_rows();

                $web_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'Web'");
                $web =  $web_q->num_rows();

                $yocc_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'YOCC'");
                $yocc =  $yocc_q->num_rows();

                $yocc_api_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'YOCC API'");
                $yocc_api =  $yocc_api_q->num_rows();

                $yocc_api_q = $this->db->query("SELECT lead_source FROM lead_master WHERE lead_source = 'YOCC API'");
                $yocc_api =  $yocc_api_q->num_rows();
                ?>
              

                <script>
                  let carwale = <?php echo $carwale ?>;
                  let cardekho_API = <?php echo $cardekho_API ?>;
                  let chat360_bot_API = <?php echo $chat360_bot_API ?>;
                  let evaluation_data_showroom = <?php echo $evaluation_data_showroom ?>;
                  let facebook = <?php echo $facebook ?>;
                  let facebook_sprinklr_comment = <?php echo $facebook_sprinklr_comment ?>;
                  let gaadibaazar_web = <?php echo $gaadibaazar_web ?>;
                  let hyperlocal = <?php echo $hyperlocal ?>;
                  let hyperlocal_facebook_lead = <?php echo $hyperlocal_facebook_lead ?>;
                  let hyperlocal_feedback_contact = <?php echo $hyperlocal_feedback_contact ?>;
                  let web = <?php echo $web ?>;
                  let yocc = <?php echo $yocc ?>;
                  let yocc_api = <?php echo $yocc_api ?>;
                  // let facebook = <?php echo $facebook ?>;
                  // let facebook = <?php echo $facebook ?>;
                  // let facebook = <?php echo $facebook ?>;


                  Highcharts.chart('container6', {
                    chart: {
                      type: 'column'
                    },
                    title: {
                      text: 'Source Wise Analysis '
                    },
                    xAxis: {
                      categories: ['Carwale', 'Cardekho API', 'Chat360 Bot API', 'Evaluations Data Showroom', 'Facebook',
                        'Facebook Sprinklr Comment', 'Gaadibaazar Web', 'Hyperlocal', 'Hyperlocal Facebook Lead', 'Hyperlocal Feedback and Contact',
                        'Web', 'YOCC', 'YOCC API'

                      ],

                      title: {
                        text: null
                      }
                    },
                    tooltip: {
                      headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                      footerFormat: '</table>',
                      shared: true,
                      useHTML: true
                    },
                    credits: {
                      enabled: false
                    },
                    plotOptions: {
                      column: {
                        dataLabels: {
                          enabled: true
                        },
                        pointPadding: 0.2,
                        borderWidth: 0
                      }
                    },
                    series: [{
                      name: 'Source Wise Analysis',

                      // ********************* Diifernt colors can be added to individual column with this code *****************************

                      // colorByPoint: true,
                      // colors: ['#700639','#8dd0dc', '#2596be', '#e16528', '#f6d08c', '#033269', '#ec9a6c', '#a54220', '#8ad3e1', '#70066e',
                      //   '#8dd0dc', '#dfebe5', '#2596be', '#e16528', '#f6d08c', '#033269', '#ec9a6c', '#a54220', '#8ad3e1', '#70066e',
                      //   '#8dd0dc', '#dfebe5', '#2596be', '#e16528', '#f6d08c', '#033269'
                      // ],

                      data: [carwale, cardekho_API, chat360_bot_API, evaluation_data_showroom, facebook, facebook_sprinklr_comment,
                        gaadibaazar_web, hyperlocal, hyperlocal_facebook_lead, hyperlocal_feedback_contact, web, yocc, yocc_api

                      ],
                      color: {
                        linearGradient: {
                          x1: 0,
                          x2: 0,
                          y1: 0,
                          y2: 1
                        },
                        stops: [
                          [0, '#8dd0dc'],
                          [1, '#dfebe5']
                        ]
                      },
                    }]
                  });
                </script>
                <style>
                  #container6 {
                    height: 400px;
                  }

                  .highcharts-figure,
                  .highcharts-data-table table {
                    min-width: 200px;
                    max-width: auto;
                    /* margin: 1em auto; */
                  }
                </style>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- eof sourcewise analysis -->
      <br>

    </div>
  </div>
</div>