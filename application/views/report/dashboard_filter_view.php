<?php if ($_SESSION['process_id'] == 6) { ?>

  <?php

  if (isset($select_leads)) {
    if (count($select_leads) > 0) {
  ?>
      <div class="col-md-12">


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
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;
          }
        </style>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet">

        <div class="main-content">

          <div class="container-fluid">
            <div class="header-body">
              <div class="row">
                <?php
                $total_assign = 0;
                $total_pending_new_lead = 0;
                $total_pending_followup = 0;
                $total_lead = 0;
                $total_gap_between_lead_assign_to_call = 0;
                $total_average_gap_between_followups = 0;
                foreach ($select_leads as $row) {
                  $total_lead += $row['total_call'];
                  $total_assign += $row['assign_lead'];
                  $total_pending_new_lead += $row['pending_new_leads'];
                  $total_pending_followup += $row['pending_followup_leads'];
                  $lead_created_on_date_time = $row['lead_created_date_time'];
                  $lead_assign_to_dse_date_time = $row['lead_assign_to_dse'];
                  $lead_followup_date_time = $row['lead_followup_date'];
                  $lead_assign_date = json_encode($lead_created_on_date_time);
                  $lead_assign_date1 = json_decode($lead_assign_date);
                } ?>

                <script>
                  const targetDiv = document.getElementById("gap");
                  var tag = '<?php echo $totalHoursDiff1; ?>';
                  var tgbl = '<?php echo $lead_assign_to_dse_date_time; ?>';

                  if (tag != '' || tgbl != '') {
                    targetDiv.style.display = "block";
                  } else {
                    targetDiv.style.display = "none";
                  }
                </script>



                <br>

                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h4>Total Leads</h4>
                          <span class="h3 font-weight-bold mb-0"><?php echo $total_lead; ?></span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="fas fa-chart-bar"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h4>Leads Assigned</h4>
                          <span class="h3 font-weight-bold mb-0">
                            <?php echo $total_assign; ?></span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                            <i class="fas fa-chart-pie"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h4>Pending New Lead</h4>
                          <span class="h3 font-weight-bold mb-0"><?php echo $total_pending_new_lead; ?></span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                            <i class="fas fa-users"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h4>Pending Follow Up Leads</h4>
                          <span class="h3 font-weight-bold mb-0"><?php echo $total_pending_followup; ?></span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                            <i class="fas fa-percent"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page content -->
        <br>
        <!--<div class="main-content" id="gap">-->
        <!--  <div class="container-fluid">-->
        <!--    <div class="header-body">-->
        <!--      <div class="row">-->
        <!--        <div class="col-xl-3 col-lg-6">-->
        <!--          <div class="card card-stats mb-4 mb-xl-0">-->
        <!--            <div class="card-body">-->
        <!--              <div class="row">-->
        <!--                <div class="col">-->
        <!--                  <h4>Gap Between Lead Assigned To First Call</h4>-->
                          <!-- <span class="h3 font-weight-bold mb-0"><?php echo $totalHoursDiff1; ?></span> -->
        <!--                </div>-->
        <!--                <div class="col-auto">-->
        <!--                  <div class="icon icon-shape bg-danger text-white rounded-circle shadow">-->
        <!--                    <i class="fas fa-chart-bar"></i>-->
        <!--                  </div>-->
        <!--                </div>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->
        <!--        <div class="col-xl-3 col-lg-6">-->
        <!--          <div class="card card-stats mb-4 mb-xl-0">-->
        <!--            <div class="card-body">-->
        <!--              <div class="row">-->
        <!--                <div class="col">-->
        <!--                  <h4>Avg Gaps Between Follow-ups</h4>-->
                          <!-- <span class="h3 font-weight-bold mb-0"><?php echo $lead_assign_to_dse_date_time; ?></span> -->
        <!--                </div>-->
        <!--                <div class="col-auto">-->
        <!--                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">-->
        <!--                    <i class="fas fa-chart-pie"></i>-->
        <!--                  </div>-->
        <!--                </div>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->

        <!--      </div>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
        <!-- Page content -->

      </div>
<?php } else {
      echo "<center>No Leads Found.</center>";
    }
  }
} ?>