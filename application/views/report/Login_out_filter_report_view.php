<script>
    $(document).ready(function() {

        var table = $('#example').DataTable({

            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
        });
    });
</script>
<script>
    <?php
    $page = $this->uri->segment(4);
    if (isset($page)) {
        $page = $page + 1;
    } else {
        $page = 0;
    }
    $offset1 = 15 * $page;
    //$query=$sql->result();
    echo $c = count($select_user);
    ?>
</script>
<!-- <script type="text/javascript">
    jQuery(document).ready(function($) {
        var $table4 = jQuery("#table-4");
        $table4.DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        });
    });
</script> -->
<div class="col-md-12">
    <div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
    </div>
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <?php
                if (count($select_user) > 0) {
                ?>
                    <!-- <a href="<?php echo site_url('') ?>Login_out_report/page?id=<?php echo $id; ?>"> -->
                    <div class="table-responsive">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <!-- <table class="table table-bordered datatable table-responsive" id="table-4"> -->
                            <!-- <table id="example" class="table table-bordered datatable table-responsive " style="width: 100%"> -->
                            <table id="example" class="table" cellspacing="0" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>User Name</th>
                                        <th>Date</th>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $i = 0;
                                    if ($select_user[0] != '') {
                                        foreach ($select_user as $row) {
                                            // $user_id = $row['user_id'];
                                            // echo $user_id;

                                            $i++; ?>

                                            <tr>
                                                <td><?php echo   $i; ?></td>
                                                <!-- <td><?php echo   $row['user_id']; ?></td> -->
                                                <td><?php echo   $row['user_name']; ?></td>
                                                <td><?php echo   $row['login_date']; ?></td>
                                                <td><?php echo   $row['login_time']; ?></td>
                                                <td><?php echo   $row['logout_time']; ?></td>

                                            </tr>
                                    <?php

                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                } else {
                    echo "<center>No Data Found.</center>";
                }
                    ?>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="col-md-6" style="font-size: 14px">

                            <?php
                            $lead_count = count($select_user);
                            // echo $count_total;           
                            $total_record = 0;
                            $total_record = $lead_count;

                            //$lead_cou = $count_lead_dse_lc+$count_lead_dse;
                            echo 'Total Records :';
                            echo '<b>' . $total_record . '</b>'; ?>&nbsp;&nbsp;
                            <!-- <?php echo 'Total Pages :';
                                    $pages = $total_record / 15;
                                    echo '<b>' . $total_page = ceil($pages) . '</b>';
                                    $total_page = intval($total_page);
                                    ?> -->
                        </div>
                        <!-- <div class="col-md-6  form-group">
                            <?php

                            if ($c < 15) {
                                $last = $page - 2;
                                if ($last != -2) {
                                    // echo "1";                                                    
                                    echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . 'Login_out_report/filter_daily/page/' . $last . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">
                                    <i class='fa fa-angle-left'></i>Previous</a>";
                                    echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . 'Login_out_report/filter_daily/?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">First  
                                    <i class='fa fa-angle-right'></i></a>";
                                    $last1 = $total_page - 2;
                                    echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . 'Login_out_report/filter_daily/page/' . $last1 . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">Last  
                                    <i class='fa fa-angle-right'></i></a>";
                                }
                            } else if ($page == 0) {
                                // echo "2";   
                                echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . 'Login_out_report/filter_daily/page/' . $page . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">Next  
                                    <i class='fa fa-angle-right'></i></a>";

                                echo "<a class=' col-md-1  btn btn-info' href=" . site_url() . "Login_out_report/filter_daily/ >First  
                                    <i class='fa fa-angle-right'></i></a>";
                                $last1 = $total_page - 2;
                                echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . 'Login_out_report/filter_daily/page/' . $last1 . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">Last  
                                    <i class='fa fa-angle-right'></i></a>";
                            } else {
                                // echo "3";
                                $last = $page - 2;
                                echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . 'Login_out_report/filter_daily/page' . $last . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">
                                    <i class='fa fa-angle-left'></i>   Previous   </a> ";
                                echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . 'Login_out_report/filter_daily/page/' . $page . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">Next  
                                    <i class='fa fa-angle-right'></i></a>";

                                echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . 'Login_out_report/filter_daily/?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">First  
                                    <i class='fa fa-angle-right'></i></a>";
                                $last1 = $total_page - 2;
                                echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . 'Login_out_report/filter_daily/page' . $last1 . '?user_name=' . $user_name . '&type=' . $type . '&from_date=' . $from_date . '&to_date=' . $to_date . ">Last  
                                    <i class='fa fa-angle-right'></i></a>";
                            }

                            $page1 = $page + 1;
                            // var_dump ($id);
                            // exit;
                            ?>

                            <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;">Page No</label>
                            <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1 ?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
                            <input class="col-md-pull-1  col-md-1  btn btn-danger " style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">


                            <script>
                                function go_on_page() {

                                    var pageno = document.getElementById("pageNo").value;
                                    var total_page = '<?php echo $total_page; ?>';
                                    var total_page = parseInt(total_page);
                                    if (pageno > total_page) {
                                        alert('Please Enter Page No. Less Than Total No. of Pages');
                                        return false;
                                    } else {
                                        //	alert(pageno);
                                        var pageno1 = pageno - 2;
                                        var user_name = '<?php echo $user_name; ?>';
                                        var type = '<?php echo $type; ?>';
                                        var from_date = '<?php echo $from_date; ?>';
                                        var to_date = '<?php echo $to_date; ?>';
                                        // var_dump($user_id);
                                        //  exit;

                                        window.location = "<?php echo site_url(); ?>Login_out_report/filter_daily/page" + pageno1 + "?user_name=" + user_name + "&type=" + type + "&from_date=" + from_date + "&to_date=" + to_date ;
                                       
                                    }
                                }
                            </script> -->
                    </div>
                    </div>
            </div>

        </div>
    </div>
</div>
</div>