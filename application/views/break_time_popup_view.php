<!-- Custom CSS -->
<style>
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .5);
        z-index: 11;
    }

    .popup-form {
        left: 50%;
        margin-top: 20%;   
        transform: translate(-50%, -50%);
        border-radius: 5px;
        display: block;
        position: absolute;
        width: 30%;
        padding: 20px;
        background: #fff;
        border: 1px solid #ccc;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        z-index: 12;
    }

    .breakl {
        margin: 1%;
    }

    @media screen and (max-width: 768px) {
        .popup-form {
            width: 100%;
            margin-top: 50%;
        }
    }
</style>




<!-- Pop-up Form -->
<div id="popupForm" class="popup-form">


    <h2 style="text-align:center; margin:2%">Break Time</h2>
    <hr>
    <form action="<?php echo site_url(); ?>break_time/insert" method="post">

        <!-- Lunch Break Time -->
        <div class="row breakl">
            <div class="col-md-4 col-sm-2 col-xs-4">
                <label for="lunch">Lunch:</label>
            </div>

            <div class="col-md-4 col-sm-2 col-xs-4">
                <div class="form-check">
                    <?php
                    if (count($break_time) != 0) {
                        $lunchStart = $break_time[0]->start_lunchbreak;
                    } else {
                        $lunchStart = '00:00:00';
                    }
                    if ($lunchStart != '00:00:00') { ?>
                        <input class="form-check-input" type="checkbox" id="lunchStart" name="lunchStart" checked=checked disabled>
                    <?php } else { ?>
                        <input class="form-check-input" type="checkbox" id="lunchStart" name="lunchStart" value="<?php echo date("h:i:s"); ?>">
                    <?php } ?>
                    <label class="form-check-label" for="lunchStart">Start</label>
                </div>
            </div>

            <div class="col-md-4 col-sm-2 col-xs-4">
                <div class="form-check">
                    <?php
                    if (count($break_time) != 0) {
                        $lunchStart = $break_time[0]->start_lunchbreak;
                        $lunchEnd = $break_time[0]->end_lunchbreak;
                    } else {
                        $lunchEnd = '00:00:00';
                    }
                    if ($lunchStart == '00:00:00' || $lunchStart == "") { ?>
                        <input class="form-check-input" type="checkbox" id="lunchEnd" name="lunchEnd" disabled>
                    <?php } elseif ($lunchEnd != "00:00:00") { ?>
                        <input class="form-check-input" type="checkbox" id="lunchEnd" name="lunchEnd" checked=checked disabled>
                    <?php } else { ?>
                        <input class="form-check-input" type="checkbox" id="lunchEnd" name="lunchEnd" value="<?php echo date("h:i:s"); ?>">
                    <?php } ?>
                    <label class="form-check-label" for="lunchEnd">End</label>
                </div>
            </div>
        </div>
        <!-- ENd Lunch Break Time -->


        <hr>
        <!-- Tea Break timeS -->
        <div class="row breakl">
            <div class="col-md-4  col-xs-4">
                <label for="tea">Tea:</label>
            </div>

            <div class="col-md-4  col-xs-4">
                <div class="form-check">
                    <?php
                    if (count($break_time) != 0) {
                        $teaStart = $break_time[0]->start_teabreak;
                    } else {
                        $teaStart = '00:00:00';
                    }
                    if ($teaStart != '00:00:00') { ?>
                        <input class="form-check-input" type="checkbox" id="teaStart" name="teaStart" checked=checked disabled>
                    <?php } else { ?>
                        <input class="form-check-input" type="checkbox" id="teaStart" name="teaStart" value="<?php echo date("h:i:s"); ?>">
                    <?php } ?>
                    <label class="form-check-label" for="teaStart">Start</label>
                </div>
            </div>

            <div class="col-md-4  col-xs-4">
                <div class="form-check">
                    <?php
                    if (count($break_time) != 0) {
                        $teaEnd = $break_time[0]->end_teabreak;
                        $teaStart = $break_time[0]->start_teabreak;
                    } else {
                        $teaEnd = '00:00:00';
                    }
                    if ($teaStart == "00:00:00" || $teaStart == "") { ?>
                        <input class="form-check-input" type="checkbox" id="teaEnd" name="teaEnd" disabled>
                    <?php } elseif ($teaEnd != "00:00:00") { ?>
                        <input class="form-check-input" type="checkbox" id="teaEnd" name="teaEnd" checked=checked disabled>
                    <?php } else { ?>
                        <input class="form-check-input" type="checkbox" id="teaEnd" name="teaEnd" value="<?php echo date("h:i:s"); ?>">
                    <?php } ?>
                    <label class="form-check-label" for="teaEnd">End</label>
                </div>
            </div>
        </div>
        <!-- End Tea Break timeS -->


        <hr>
        <!-- Emergency Break Time -->
        <div class="row breakl">
            <div class="col-md-4  col-xs-4">
                <label for="emergency">Emergency:</label>
            </div>

            <div class="col-md-4  col-xs-4">
                <div class="form-check">
                    <?php

                    if (count($break_time) != 0) {
                        foreach ($break_time as $row) {
                            $em_break_start_1 = $row->em_break_start_1;
                            $em_break_end_1 = $row->em_break_end_1;
                            $em_break_start_2 = $row->em_break_start_2;
                            $em_break_end_2 = $row->em_break_end_2;
                            $em_break_start_3 = $row->em_break_start_3;
                            $em_break_end_3 = $row->em_break_end_3;
                            $em_break_start_4 = $row->em_break_start_4;
                            $em_break_end_4 = $row->em_break_end_4;
                            $em_break_start_5 = $row->em_break_start_5;
                            $em_break_end_5 = $row->em_break_end_5;
                            $em_break_start_6 = $row->em_break_start_6;
                            $em_break_end_6 = $row->em_break_end_6;
                            $em_break_start_7 = $row->em_break_start_7;
                            $em_break_end_7 = $row->em_break_end_7;
                            $em_break_start_8 = $row->em_break_start_8;
                            $em_break_end_8 = $row->em_break_end_8;
                            $em_break_start_9 = $row->em_break_start_9;
                            $em_break_end_9 = $row->em_break_end_9;
                            $em_break_start_10 = $row->em_break_start_10;
                            $em_break_end_10 = $row->em_break_end_10;
                        }
                    } else {
                        $em_break_start_1 = '00:00:00';
                    }
                    if (
                        !isset($em_break_start_1)  && !isset($em_break_end_1) || !isset($em_break_start_2)  && !isset($em_break_end_2)
                        || !isset($em_break_start_3)  && !isset($em_break_end_3) || !isset($em_break_start_4)  && !isset($em_break_end_4)
                        || !isset($em_break_start_5)  && !isset($em_break_end_5) || !isset($em_break_start_6)  && !isset($em_break_end_6)
                        || !isset($em_break_start_7)  && !isset($em_break_end_7) || !isset($em_break_start_8)  && !isset($em_break_end_8)
                        || !isset($em_break_start_9)  && !isset($em_break_end_9) || !isset($em_break_start_10)  && !isset($em_break_end_10)
                    ) { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyStart" name="emergencyStart" value="<?php echo date("h:i:s"); ?>">
                    <?php } elseif (
                        $em_break_start_1 != '00:00:00' && $em_break_end_1 == '00:00:00' || $em_break_start_2 != '00:00:00' && $em_break_end_2 == '00:00:00'
                        || $em_break_start_3 != '00:00:00' && $em_break_end_3 == '00:00:00' || $em_break_start_4 != '00:00:00' && $em_break_end_4 == '00:00:00'
                        || $em_break_start_5 != '00:00:00' && $em_break_end_5 == '00:00:00' || $em_break_start_6 != '00:00:00' && $em_break_end_6 == '00:00:00'
                        || $em_break_start_7 != '00:00:00' && $em_break_end_7 == '00:00:00' || $em_break_start_8 != '00:00:00' && $em_break_end_8 == '00:00:00'
                        || $em_break_start_9 != '00:00:00' && $em_break_end_9 == '00:00:00' || $em_break_start_10 != '00:00:00' && $em_break_end_10 == '00:00:00'
                    ) { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyStart" name="emergencyStart" checked=checked disabled>
                    <?php } else { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyStart" name="emergencyStart" value="<?php echo date("h:i:s"); ?>">
                    <?php }
                    ?>
                    <label class="form-check-label" for="emergencyStart">Start</label>
                </div>
            </div>

            <div class="col-md-4  col-xs-4">
                <div class="form-check">
                    <?php
                    if (count($break_time) != 0) {
                        foreach ($break_time as $row) {
                            $em_break_start_1 = $row->em_break_start_1;
                            $em_break_end_1 = $row->em_break_end_1;
                            $em_break_start_2 = $row->em_break_start_2;
                            $em_break_end_2 = $row->em_break_end_2;
                            $em_break_start_3 = $row->em_break_start_3;
                            $em_break_end_3 = $row->em_break_end_3;
                            $em_break_start_4 = $row->em_break_start_4;
                            $em_break_end_4 = $row->em_break_end_4;
                            $em_break_start_5 = $row->em_break_start_5;
                            $em_break_end_5 = $row->em_break_end_5;
                            $em_break_start_6 = $row->em_break_start_6;
                            $em_break_end_6 = $row->em_break_end_6;
                            $em_break_start_7 = $row->em_break_start_7;
                            $em_break_end_7 = $row->em_break_end_7;
                            $em_break_start_8 = $row->em_break_start_8;
                            $em_break_end_8 = $row->em_break_end_8;
                            $em_break_start_9 = $row->em_break_start_9;
                            $em_break_end_9 = $row->em_break_end_9;
                            $em_break_start_10 = $row->em_break_start_10;
                            $em_break_end_10 = $row->em_break_end_10;
                        }
                    } else {
                        $em_break_end_1 = '00:00:00';
                    }
                    if (
                        !isset($em_break_start_1)  && !isset($em_break_end_1) || !isset($em_break_start_2)  && !isset($em_break_end_2)
                        || !isset($em_break_start_3)  && !isset($em_break_end_3) || !isset($em_break_start_4)  && !isset($em_break_end_4)
                        || !isset($em_break_start_5)  && !isset($em_break_end_5) || !isset($em_break_start_6)  && !isset($em_break_end_6)
                        || !isset($em_break_start_7)  && !isset($em_break_end_7) || !isset($em_break_start_8)  && !isset($em_break_end_8)
                        || !isset($em_break_start_9)  && !isset($em_break_end_9) || !isset($em_break_start_10)  && !isset($em_break_end_10)
                    ) { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyEnd" name="emergencyEnd" disabled>
                    <?php } elseif (
                        $em_break_start_1 != '00:00:00' && $em_break_end_1 == '00:00:00' || $em_break_start_2 != '00:00:00' && $em_break_end_2 == '00:00:00'
                        || $em_break_start_3 != '00:00:00' && $em_break_end_3 == '00:00:00' || $em_break_start_4 != '00:00:00' && $em_break_end_4 == '00:00:00'
                        || $em_break_start_5 != '00:00:00' && $em_break_end_5 == '00:00:00' || $em_break_start_6 != '00:00:00' && $em_break_end_6 == '00:00:00'
                        || $em_break_start_7 != '00:00:00' && $em_break_end_7 == '00:00:00' || $em_break_start_8 != '00:00:00' && $em_break_end_8 == '00:00:00'
                        || $em_break_start_9 != '00:00:00' && $em_break_end_9 == '00:00:00' || $em_break_start_10 != '00:00:00' && $em_break_end_10 == '00:00:00'
                    ) { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyEnd" name="emergencyEnd" value="<?php echo date("h:i:s"); ?>">
                    <?php } elseif (
                        $em_break_start_1 != '00:00:00' && $em_break_end_1 != '00:00:00' || $em_break_start_2 != '00:00:00' && $em_break_end_2 != '00:00:00'
                        || $em_break_start_3 != '00:00:00' && $em_break_end_3 != '00:00:00' || $em_break_start_4 != '00:00:00' && $em_break_end_4 != '00:00:00'
                        || $em_break_start_5 != '00:00:00' && $em_break_end_5 != '00:00:00' || $em_break_start_6 != '00:00:00' && $em_break_end_6 != '00:00:00'
                        || $em_break_start_7 != '00:00:00' && $em_break_end_7 != '00:00:00' || $em_break_start_8 != '00:00:00' && $em_break_end_8 != '00:00:00'
                        || $em_break_start_9 != '00:00:00' && $em_break_end_9 != '00:00:00' || $em_break_start_10 != '00:00:00' && $em_break_end_10 != '00:00:00'
                    ) { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyEnd" name="emergencyEnd" disabled>
                    <?php } else { ?>
                        <input class="form-check-input" type="checkbox" id="emergencyEnd" name="emergencyEnd" disabled>
                    <?php }
                    ?>
                    <label class="form-check-label" for="emergencyEnd">End</label>
                </div>
            </div>
        </div>
        <!-- End Emergency Break Time -->

        <hr>
        <div class="row breakl" style="display: flex; justify-content: center;">
            <button type="submit" class="btn btn-info" style="margin:2%">Submit</button>
            <button type="button" id="closePopupBtn" style="margin:2%" class="btn btn-primary"><a href="<?php echo site_url(); ?>notification" style="text-decoration:none; color:#fff">Close</a></button>
        </div>
    </form>

</div>

<!-- Overlay to darken the background -->
<div id="overlay" class="overlay"></div>





<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        // Show pop-up form
        $("#showPopupBtn").click(function() {
            $("#popupForm").fadeIn();
            $("#overlay").fadeIn();
        });

        // Close pop-up form
        $("#closePopupBtn, #overlay").click(function() {
            $("#popupForm").fadeOut();
            $("#overlay").fadeOut();
        });
    });
</script>