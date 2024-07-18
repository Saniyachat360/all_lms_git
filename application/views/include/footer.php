<!-- Footer -->
<footer class="main" style="margin-top: 20px;border-top: none;">
	<!--&copy; 2016 <strong>All Right Reserved | Autovista</strong>-->
	<div id="chat" class="fixed" data-current-user="Art Ramadani" data-order-by-status="1" data-max-chat-history="25">
		<div class="chat-inner">
			<h2 class="chat-header"><a href="#" class="chat-close"><i class="entypo-cancel"></i></a><i class="entypo-users"></i>
		</div>
	</div>
</footer>

</div>
</div>


<script>

	$(document).ready(function() {
		$('.datett').daterangepicker({
			singleDatePicker : true,
			showDropdowns: true,
			format : 'YYYY-MM-DD',
			calender_style : "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
	}); 
	$(document).ready(function(){
    $('#timet').timepicker({
        timeFormat: 'hh:mm:ss p',
       // minTime: '11:45:00', // 11:45:00 AM,
       // maxHour: 20,
      // maxMinutes: 30,
       scrollbar: true,
        startTime: new Date(0,0,0,0,0,0), // 3:00:00 PM - noon
        interval: 30 // 15 minutes
    });
	$('#appointment_time').timepicker({
        timeFormat: 'hh:mm:ss p',
       // minTime: '11:45:00', // 11:45:00 AM,
       // maxHour: 20,
      // maxMinutes: 30,
       scrollbar: true,
        startTime: new Date(0,0,0,0,0,0), // 3:00:00 PM - noon
        interval: 30 // 15 minutes
    });
});
</script>

<script  src="<?php echo base_url(); ?>assets/js/bootstrap.js" id="script-resource-3"></script>



<!-- daterangepicker -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/new/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/new/dataTables.fixedColumns.min.js" type="text/javascript"></script>
<script src="https://demo.neontheme.com/assets/js/resizeable.js"></script>
<script src="https://demo.neontheme.com/assets/js/gsap/TweenMax.min.js"></script>
<script src="https://demo.neontheme.com/assets/js/neon-custom.js" id="script-resource-9"></script>
</div>
<style>
 .daterangepicker.dropdown-menu .calendar .calendar-date table .active {
    background: #303641;
    color: #fff;
}</style>
</body> </html>