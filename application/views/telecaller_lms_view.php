<?php
$page = $this->uri->segment(4);
if (isset($page)) {
    $page = $page + 1;
} else {
    $page = 0;
}
$offset1 = 100 * $page;
//$query=$sql->result();
$c = count($select_lead);
//echo $c;
?>

<?php 

        // Check if session value is set
// <!--        if (!empty($sessionValue)) {-->
//             // Output session value
// <!--            echo "Session value: " . $sessionValue;-->
// <!--        } else {-->
//             // Session value not found
// <!--            echo "Session value not found!";-->
// <!--        }-->
?>
<!--<button id="openDialerButton">Open Dialer</button>-->

<!--<script type="text/javascript">-->
<!--    document.addEventListener('DOMContentLoaded', function() {-->
        <!--Find the button element-->
<!--        var openDialerButton = document.getElementById('openDialerButton');-->
        
        <!--// Add a click event listener-->
<!--        openDialerButton.addEventListener('click', function() {-->
            <!--// Your script here-->
<!--            var SessionURL = "https://crm5.cloud-connect.in/Agent_plugin/login.php?session=550448";-->
            
<!--            var CloudConnectIFrame = document.createElement("iframe");-->
<!--            CloudConnectIFrame.setAttribute("src", SessionURL);-->
<!--            CloudConnectIFrame.setAttribute("allow", "geolocation; microphone; camera");-->
<!--            CloudConnectIFrame.setAttribute("id", "CloudConnectPluginIFrame");-->
<!--            CloudConnectIFrame.setAttribute("allowfullscreen", "true");-->
<!--            CloudConnectIFrame.setAttribute("webkitallowfullscreen", "true");-->
<!--            CloudConnectIFrame.setAttribute("mozallowfullscreen", "true");-->
<!--            CloudConnectIFrame.setAttribute("scrolling", "no");-->
<!--            CloudConnectIFrame.setAttribute("frameborder", "0");-->
<!--            document.body.appendChild(CloudConnectIFrame);-->
<!--            var CloudConnectPluginIFrame = document.getElementById("CloudConnectPluginIFrame");-->
<!--            CloudConnectPluginIFrame.setAttribute("style", "bottom:0;top:0;position:right;z-index:-1;");-->
<!--            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent",-->
<!--                eventer = window[eventMethod],-->
<!--                messageEvent = "attachEvent" === eventMethod ? "onmessage" : "message";-->
<!--            eventer(messageEvent, function(e) {-->
<!--                try {-->
<!--                    var t = JSON.parse(e.data);-->
<!--                    var r = t["type"];-->
                   
<!--                    for (key in t) {-->
                        
<!--                        CloudConnectPluginIFrame && ((r == "css") ? CloudConnectPluginIFrame.style[key] = t[key] : CloudConnectPluginIFrame.setAttribute(key, t[key]))-->
<!--                    }-->
<!--                } catch (e) {-->
<!--                    return false;-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->


<!--<script type="text/javascript">    -->
<!--var sessionValue = 554336;-->
<!--var SessionURL= "https://crm5.cloud-connect.in/Agent_plugin/login.php?=" + sessionValue;var CloudConnectIFrame=document.createElement("iframe");CloudConnectIFrame.setAttribute("src",SessionURL),CloudConnectIFrame.setAttribute("allow","geolocation; microphone; camera"),CloudConnectIFrame.setAttribute("id","CloudConnectPluginIFrame"),CloudConnectIFrame.setAttribute("allowfullscreen","true"),CloudConnectIFrame.setAttribute("webkitallowfullscreen","true"),CloudConnectIFrame.setAttribute("mozallowfullscreen","true"),CloudConnectIFrame.setAttribute("scrolling","no"),CloudConnectIFrame.setAttribute("frameborder","0"),document.body.appendChild(CloudConnectIFrame);var CloudConnectPluginIFrame=document.getElementById("CloudConnectPluginIFrame");CloudConnectPluginIFrame.setAttribute("style","bottom:0;top:0;position:fixed;z-index:99999;");var eventMethod=window.addEventListener?"addEventListener":"attachEvent",eventer=window[eventMethod],messageEvent="attachEvent"===eventMethod?"onmessage":"message";eventer(messageEvent,function(e){try{var t=JSON.parse(e.data); var r = t["type"];for(key in t){CloudConnectPluginIFrame&&( (r == "css")? CloudConnectPluginIFrame.style[key]=t[key]:CloudConnectPluginIFrame.setAttribute(key,t[key]))}}catch(e){return false;}});</script>-->





<div class="row" id="leaddiv">
    <div id='replacediv'>
        <?php
        $today = date('d-m-Y');
        if (strpos($enq, '%23') !== false) {
            $enq1 = explode('%23', $enq);
            $enq2 = $enq1[1];
        } else {
            $enq2 = $enq;
        }
        $enq2 = str_replace('%20', ' ', $enq2);
        if ($enq2 == 'All') {
        ?> <h1 style="text-align:center;">All Leads</h1> <?php
                                                        } else {
                                                            ?><h1 style="text-align:center;"><?php echo $enq2; ?> Leads</h1>
            <?php if ($enq == 'Today Followup') {
            ?>
                <a href="<?php echo site_url('') ?>today_followup/?id=<?php echo $id; ?>&name=current">
                    <i class="btn btn-info entypo-doc-text-inv"> Current Followup</i>
                </a>
                <a href="<?php echo site_url('') ?>today_followup/?id=<?php echo $id; ?>">
                    <i class="btn btn-primary entypo-doc-text-inv"> Today Followup</i>
                </a>
            <?php }
            ?>


        <?php
                                                        }
                                                        if ($id != '') {
        ?>
            <a class='pull-right' href="<?php echo site_url('') ?>unassign_leads/downloadLeads?id=<?php echo $id; ?>&enq=<?php echo $enq; ?>&role=<?php echo $role; ?>&name=<?php if (isset($name)) {
                                                                                                                                                                                echo $name;
                                                                                                                                                                            } ?>" target="_blank">
                <i class="btn btn-info entypo-download"> Download</i>
            </a>
        <?php
                                                        }
        ?>
        <div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
        </div>
        

        <!--- Fetch Table Data -->
        <div class="col-md-12"> <?php echo $this->session->flashdata('message'); ?> </div>
        <div class="col-md-12"> <?php echo $this->session->flashdata('msg1'); ?> </div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <?php if ($id == '') {
                    ?>
                        <div class="col-md-offset-8 col-md-4">
                               
                            <div class="form-group">
                                <a href="<?php echo site_url();?>add_lms_user/download_data?id=1" target="_blank" class="btn btn-success">Download</a>
                                <div class="col-md-7 col-xs-12">
                                    <input type="text" placeholder="Search Contact" autocomplete="off" class="form-control col-md-4 col-xs-12" id='contact_no' required>
                                </div>
                                <a class="btn btn-success col-md-2 col-xs-12" onclick="return searchcontact()"><i class="entypo-search"></i></a>
                                <a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()'><i class="entypo-ccw"></i></a>
                                
                            </div>
                        </div>
                    <?php
                    } ?>
                    <br><br>
                    <div id='searchdiv'>
                        <div class="table-responsive">
                            <table id="example" class="table " style="width: 100%">
                                <thead>
                                    <tr>
                                        <!-- Show Select box if add followup or remark right 1 -->
                                        <th>Sr</th>
                                        <th>Interested In</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Dialer</th>
                                        <th>Lead Date</th>
                                        <?php if ($_SESSION['process_id'] == 10) { ?>
                                            <th>Location</th>
                                            <th>First Message</th>
                                            <th>Type</th>
                                        <?php } else { ?>
                                            <th style="display:none">Location</th>
                                            <th style="display:none">First Msg</th>
                                            <th style="display:none">Type</th>
                                        <?php }
                                        ?>
                                        <?php
                                        if ($_SESSION['role'] == 3 && $enq == 'New') {
                                        } else {
                                        ?>
                                            <th>Feedback Status</th>

                                            <?php if ($_SESSION['process_id'] == 10) { ?>
                                                <th style="display:none">Next Action</th>
                                            <?php } else { ?>
                                                <th>Next Action</th>
                                            <?php }
                                            ?>

                                           <?php if ($_SESSION['process_id'] == 10) { ?>
                                                <th style="display:none">Current User</th>
                                            <?php } else { ?>
                                                <th>Current User</th>
                                            <?php }
                                            ?>
                                            
                                            
                                             <?php if ($_SESSION['process_id'] == 10) { ?>
                                            <th style="display:none">Call Date</th>
                                            <th style="display:none">N.F.D</th>
                                            <th style="display:none">N.F.T</th>
                                                
                                            <?php } else { ?>
                                            <th>Call Date</th>
                                            <th>N.F.D</th>
                                            <th>N.F.T</th>
                                            <?php }
                                            ?>
                                            
                                            <th>Remark</th>
                                            
                                            
                                        <?php
                                        } ?>
                                        <?php
                                        $view = $_SESSION['view'];
                                        if (isset($_SESSION['view_poc_purchase_tracking'])) {
                                            $view_poc_purchase_tracking = $_SESSION['view_poc_purchase_tracking'];
                                        } else {
                                            $view_poc_purchase_tracking = '';
                                        }
                                        if ($view[10] == 1) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = $offset1;
                                    if (!empty($select_lead)) {
                                        foreach ($select_lead as $fetch) {
                                            $enq_id = $fetch->enq_id;

                                            $i++;
                                    ?>
                                            <tr id='t<?php echo $i; ?>'>
                                                <input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
                                                <input type="hidden" value="<?php echo $fetch->enquiry_for; ?>" id="select_enq">
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php
                                                    if ($fetch->lead_source == '') {
                                                        $lead_source = "Web";
                                                    } else {
                                                        $lead_source = $fetch->lead_source;
                                                    } ?>
                                                    <?php echo $lead_source;
                                                    if ($fetch->enquiry_for != '') {
                                                        echo " (" . $fetch->enquiry_for . ")";
                                                    } ?>
                                                </td>
                                                <td><b>

                                                        <?php if ($_SESSION['process_id'] == 5) {
                                                        ?><a href="<?php echo site_url(); ?>add_followup_accessories/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details"><?php
                                                                                                                                                                                                        } else if ($_SESSION['process_id'] == 4) {
                                                                                                                                                                                                            ?><a href="<?php echo site_url(); ?>add_followup_service/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details"><?php
                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                        /*	else if($_SESSION['process_id']=='Insurance')
												{
													?><a href="<?php echo site_url(); ?>add_followup_insurance/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}*/ else if ($_SESSION['process_id'] == 1) {
                                                                                                                                                                                                                                                                                                                                                            ?><a href="<?php echo site_url(); ?>add_followup_finance/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details"><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else if ($_SESSION['process_id'] == 6) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?><a href="<?php echo site_url(); ?>add_followup_new_car/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details"><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        //saniya code insurance
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        else if ($_SESSION['process_id'] == 10) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?><a href="<?php echo site_url(); ?>add_followup_insurance/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details">
                                                                            <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        //eof saniya code insurance
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        else if ($_SESSION['process_id'] == 7) {
                                                                            ?><a href="<?php echo site_url(); ?>add_followup_used_car/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details"><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else if ($_SESSION['process_id'] == 8) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            if ($_SESSION['sub_poc_purchase'] == 2) { ?>
                                                                                        <a href="<?php echo site_url(); ?>add_followup_evaluation_tracking/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details">

                                                                                        <?php } else { ?>
                                                                                            <a href="<?php echo site_url(); ?>add_followup_evaluation/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details">

                                                                                            <?php } ?>
                                                                                        <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                        ?><a href="<?php echo site_url(); ?>add_followup/detail/<?php echo $enq_id; ?>/<?php echo $enq; ?> " title="Customer Follow Up Details"><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                ?>
                                                                                            <?php echo $fetch->name;
                                                                                            /*if($fetch->days60_booking=='90' || $fetch->days60_booking=='>60')
													{
														?><span class="label label-success"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php 
													}
													else if($fetch->days60_booking=='30')
													{
														?><span class="label label-danger"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php 
													}
													else if($fetch->days60_booking=='60')
													{
														?><span class="label label-warning"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php 
													}
													else
													{
														?><span class="label label-success"><?php echo $fetch->days60_booking;?></span> <?php 
													}	*/
                                                                                            ?>
                                                                                            </a></b>
                                                </td>
                                                <td><?php echo $fetch->contact_no; ?></td>
                                                <td>
													<a href="<?php echo site_url('api_dialer/session_id_dialer'); ?>">
														<img src="<?php echo base_url('assets/images/dialer_1.png'); ?>" height="50%" width="60%">
													</a>
												</td>
                                                <td><?php echo $fetch->created_date; ?></td>
                                                <?php if ($_SESSION['process_id'] == 10) { ?>
                                                    <td><?php echo $fetch->customer_location; ?></td>
                                                    <td><?php echo $fetch->comment; ?></td>
                                                    <td><?php echo $fetch->insurance_type; ?></td>
                                                <?php } else { ?>
                                                    <td style="display:none"><?php echo $fetch->customer_location; ?></td>
                                                    <td style="display:none"><?php echo $fetch->comment; ?></td>
                                                    <td style="display:none"><?php echo $fetch->insurance_type; ?></td>
                                                <?php }
                                                ?>
                                                <?php if ($_SESSION['role'] == 3 && $enq == 'New') {
                                                } else { ?>


                                                     <?php if ($_SESSION['process_id'] == 10) { ?>
                                                        <td><?php echo $fetch->contactibility; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo $fetch->feedbackStatus; ?></td>
                                                    <?php }
                                                    ?>


                                                    <?php if ($_SESSION['process_id'] == 10) { ?>
                                                        <td style="display:none"><?php echo $fetch->nextAction; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo $fetch->nextAction; ?></td>
                                                    <?php }
                                                    ?>


                                                    <?php if ($_SESSION['process_id'] == 10) { ?>
                                                        <td style="display:none"></td>
                                                    <?php } else { ?>
                                                        <?php if ($fetch->assign_to_dse != 0) { ?>
                                                            <td><?php echo $fetch->dse_fname . ' ' . $fetch->dse_lname; ?></td>
                                                        <?php } elseif ($fetch->assign_to_dse_tl != 0 && $fetch->assign_to_dse == 0) { ?>
                                                            <td><?php echo $fetch->dsetl_fname . ' ' . $fetch->dsetl_lname; ?></td>
                                                        <?php } elseif ($fetch->assign_to_dse_tl == 0 && $fetch->assign_to_dse == 0) { ?>
                                                            <td><?php echo $fetch->cse_fname . ' ' . $fetch->cse_lname; ?></td>
                                                        <?php } else { ?>
                                                            <td><?php echo $fetch->csetl_fname . ' ' . $fetch->csetl_lname; ?></td>
                                                        <?php } ?>
                                                    <?php }
                                                    ?>



                                                    <?php if ($_SESSION['process_id'] == 10) { ?>
                                                    <td><?php echo $fetch->calling_remark; ?></td>
                                                <?php } else { ?>

                                                    <?php if ($fetch->dse_followup_id == 0){ ?>
                                                        <td><?php echo $fetch->cse_date; ?></td>
                                                        <td><?php echo $fetch->cse_nfd; ?></td>
                                                        <td><?php echo $fetch->cse_nftime; ?></td>
                                                        
                                                        <td><?php $comment = $fetch->cse_comment;

                                                            $string = strip_tags($comment);

                                                            if (strlen($string) > 20) {

                                                                // truncate string
                                                                $stringCut = substr($string, 0, 20);

                                                                // make sure it ends in a word so assassinate doesn't become ass...
                                                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
                                                            }
                                                            echo $string;
                                                            ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo $fetch->dse_date; ?></td>
                                                        <td><?php echo $fetch->dse_nfd; ?></td>
                                                        <td><?php echo $fetch->dse_nftime; ?></td>
                                                        <td><?php $comment = $fetch->dse_comment;

                                                            $string = strip_tags($comment);

                                                            if (strlen($string) > 20) {

                                                                // truncate string
                                                                $stringCut = substr($string, 0, 20);

                                                                // make sure it ends in a word so assassinate doesn't become ass...
                                                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
                                                            }
                                                            echo $string;
                                                            ?></td>
                                                <?php
                                                    }
                                                } ?>
                                            <?php } ?>


                                                
                                                    <?php if ($view[10] == 1) { ?>
                                                        <td><a href="<?php echo site_url(); ?>manager_remark/leads/<?php echo $fetch->enq_id; ?>/<?php echo $enq; ?>">Add Auditor Remark</a></td>
                                                    <?php } ?>
                                                
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="col-md-6" style="font-size: 14px">

                                <?php

                                if ($enq == 'New') {
                                    $url = 'new_lead/leads/';
                                    $total_record = $new_count_lead[0]->count_lead;
                                } else if ($enq == 'Pending New') {
                                    $url = 'pending/telecaller_leads_not_attended/';
                                    $total_record = $pending_new_count_lead[0]->count_lead;
                                } else if ($enq == 'Pending Followup') {
                                    $url = 'pending/telecaller_leads/';
                                    $total_record = $pending_f_count_lead[0]->count_lead;
                                } else if ($enq == 'Today Followup') {
                                    $url = 'today_followup/leads/';
                                    $total_record = $today_count_lead[0]->count_lead;
                                } else if ($enq == 'Unassigned') {
                                    $url = 'unassign_leads/leads/';
                                    $total_record = $unassign_count_lead[0]->count_lead;
                                } else if ($enq == 'Home Visit Today') {
                                    $url = 'home_visit/leads/';
                                    $total_record = $home_visit_count_lead[0]->count_lead;
                                } else if ($enq == 'Showroom Visit Today') {
                                    $url = 'showroom_visit/leads/';
                                    $total_record = $showroom_visit_count_lead[0]->count_lead;
                                } else if ($enq == 'Test Drive Today') {
                                    $url = 'test_drive/leads/';
                                    $total_record = $test_drive_count_lead[0]->count_lead;
                                } else if ($enq == 'Evaluation Today') {
                                    $url = 'evaluation/leads/';
                                    $total_record = $evaluation_count_lead[0]->count_lead;
                                } else {
                                    $url = 'website_leads/telecaller_leads/';
                                    $total_record = $all_count_lead[0]->count_lead;
                                }


                                //$lead_cou = $count_lead_dse_lc+$count_lead_dse;
                                echo 'Total Records :';
                                echo '<b>' . $total_record . '</b>';
                                //print_r($count_lead);
                                ?>
                                &nbsp;&nbsp;

                                <?php echo 'Total Pages :';
                                $pages = $total_record / 100;
                                echo '<b>' . $total_page = ceil((int)($pages)) . '</b>';


                                $total_page = intval($total_page);
                                //echo  $last1 = $t - 2;
                                ?>
                            

                            </div>

                            <div class="col-md-6  form-group">


   

                                <?php

                                if ($c < 100) {
                                    $last = $page - 2;
                                    if ($last != -2) {
                                        //echo "1";
                                        echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . $url . "page/" . $last . "/?id=" . $id . "&role=" . $role . ">
<i class='fa fa-angle-left'></i>   Previous   </a>";
                                        echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . $url . "/?id=" . $id . "&role=" . $role . ">First  
<i class='fa fa-angle-right'></i></a>";
                                        $last1 = $total_page - 2;
                                        echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . $url . "page/" . $last1 . "/?id=" . $id . "&role=" . $role . ">Last  
<i class='fa fa-angle-right'></i></a>";
                                    }
                                } else if ($page == 0) {
                                    //echo"2";
                                    echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . $url . "page/" . $page . "/?id=" . $id . "&role=" . $role . ">Next  
<i class='fa fa-angle-right'></i></a>";
                                    echo "<a class=' col-md-1  btn btn-info'  href=" . site_url()  . $url . "/?id=" . $id . "&role=" . $role . ">First  
<i class='fa fa-angle-right'></i></a>";
                                    $last1 = $total_page - 2;
                                    echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . $url . "page/" . $last1 . "/?id=" . $id . "&role=" . $role . ">Last  
<i class='fa fa-angle-right'></i></a>";
                                } else {
                                    //echo "3";
                                    $last = $page - 2;
                                    echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . $url . "page/" . $last . "/?id=" . $id . "&role=" . $role . ">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
                                    echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . $url . "page/" . $page . "/?id=" . $id . "&role=" . $role . ">Next  
<i class='fa fa-angle-right'></i></a>";

                                    echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . $url . "/?id=" . $id . "&role=" . $role . ">First  
<i class='fa fa-angle-right'></i></a>";
                                    $last1 = $total_page - 2;
                                    echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . $url . "page/" . $last1 . "/?id=" . $id . "&role=" . $role . ">Last  
<i class='fa fa-angle-right'></i></a>"; ?>


                                <?php }

                                $page1 = $page + 1;
                                ?>
                                
                             


                                <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;">Page No</label>
                                <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1 ?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
                                <input class="col-md-pull-1  col-md-1  btn btn-danger " style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">

                                
                                
                            </div>
                        </div>
                    </div>


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

                                var id = "<?php echo $id; ?>";
                                window.location = "<?php echo site_url() . $url; ?>page/" + pageno1 + "/?id=" + id;
                            }

                        }
                    </script>
                    <script>
                        function searchcontact() {
                            var contact_no = document.getElementById("contact_no").value;
                            if (contact_no == '') {
                                alert("Please enter contact number for search");
                                return false;
                            }
                            var enq = "<?php echo $enq2; ?>";
                            if (enq == 'All') {
                                var s = "website_leads/search_contact";
                            } else if (enq == 'New') {
                                var s = "new_lead/search_new";
                            } else if (enq == 'Today Followup') {
                                var s = "today_followup/search_today";
                            } else if (enq == 'Pending New') {
                                var s = "pending/search_pending_new";
                            } else if (enq == 'Pending Followup') {
                                var s = "pending/search_pending_followup";
                            }
                            $.ajax({
                                url: "<?php echo site_url(); ?>" + s,
                                type: "POST",
                                data: {
                                    contact_no: contact_no
                                },
                                success: function(result) {
                                    $("#searchdiv").html(result)
                                }
                            });
                        }

                        function reset() {
                            var enq = "<?php echo $enq2; ?>";
                            if (enq == 'All') {
                                var s = "website_leads/telecaller_leads";
                            } else if (enq == 'New') {
                                var s = "new_lead/leads";
                            } else if (enq == 'Today Followup') {
                                var s = "today_followup/leads";
                            } else if (enq == 'Pending New') {
                                var s = "pending/telecaller_leads_not_attended";
                            } else if (enq == 'Pending Followup') {
                                var s = "pending/telecaller_leads";
                            } else if (enq == 'Home Visit Today') {
                                var s = "home_visit/leads";
                            } else if (enq == 'Showroom Visit Today') {
                                var s = "Showroom_visit/leads";
                            } else if (enq == 'Test Drive Today') {
                                var s = "test_drive/leads";
                            } else if (enq == 'Evaluation Today') {
                                var s = "evaluation/leads";
                            }
                            window.location = "<?php echo site_url() ?>" + s;
                        }
                    </script>
                    <script>
                        $(document).ready(function() {
                            var enq = "<?php echo $enq; ?>";
                            if ($("#example").width() > 1308) {
                                var table = $('#example').DataTable({
                                    searching: false,
                                    scrollY: "400px",
                                    scrollX: true,
                                    scrollCollapse: true,

                                    fixedColumns: {
                                        leftColumns: 0,
                                        rightColumns: 0
                                    }
                                });
                            } else {
                                var table = $('#example').DataTable({
                                    searching: false,
                                    scrollY: "400px",
                                    scrollX: false,
                                    scrollCollapse: true,

                                    fixedColumns: {
                                        leftColumns: 0,
                                        rightColumns: 0
                                    }
                                });

                            }
                        });
                    </script>
                </div>

            </div>
            <!-- /page content -->