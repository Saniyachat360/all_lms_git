<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Neon Admin Panel" />
		<meta name="author" content="Laborator.co" />
		<link rel="icon" href="https://demo.neontheme.com/assets/images/favicon.ico">
		<title>Neon | Modals</title>
	
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/bootstrap.css" id="style-resource-4">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/neon-core.css" id="style-resource-5">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/neon-theme.css" id="style-resource-6">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/neon-forms.css" id="style-resource-7">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/custom.css" id="style-resource-8">
		<script src="https://demo.neontheme.com/assets/js/jquery-1.11.3.min.js"></script>
		<!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
		<!-- TS1530178786: Neon - Responsive Admin Template created by Laborator -->
	</head>
	<body class="page-body" data-url="https://demo.neontheme.com">
		<!-- TS15301787861122: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
		<div class="page-container">

			<div class="main-content">

				<hr />
				dfsdfsdffffffffffff<br />
				dfsdfsdffffffffffffsdfsdfsdf<br />
				sfdsdfsdfsdf<br />
				fdsdfsdf<br />
				sdfsdfsdf<br />
				sdfsdfsdfsdfsdfsdv<br />
				sdfsdfsdffsd<br />
				fsdf<br />
				sdfsdfsdfsdfsdfsdsd<br />
				fsdffsd<br />
				fsdffsdfsd<br />
				fadedf<br />
				sdfsdfsdffsdfsd<br />
				fsdffsdsdf<br />
				sdfsdfsdfsdfsdfsdfs<br />
				dfsdfsdffffffffffffsdfsdfsdfsdf<br />
				sdfsdfsdfsdfsdfsddf<br />
				sdfsdfsdf<br />
				sdfsdfsdfsdfsdfsdsdfsd<br />
				fadesf<br />
				sample-user-123fsd<br />
				fadesdf<br />
				sfdsdfsdfsdfsd<br />
				fadesdfsd<br />
				fscanfdsfd<br />
				fadesf<br />
				sdfsdfsdfsdfsdfsdsdfsdfsd<br />
				fadesdffsd<br />
				sdfsdfsdfsdfsdfsdsdfsdfsdsf
				<br /><br /><br />
				sdfsdfsdffsdd<br />
				sdfsdfsdfsdfsdfsd<br />
				<h2>Modals Triggering</h2>
				<br />
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="panel-title">
									Modals Examples
								</div>
							</div>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="30%">Modal Type</th><th>Example</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="middle-align">Basic</td><td><a href="javascript:;" onclick="jQuery('#modal-1').modal('show');" class="btn btn-default">Show Me</a></td>
									</tr>
									<tr>
										<td class="middle-align">Custom Width</td><td><a href="javascript:;" onclick="jQuery('#modal-2').modal('show');" class="btn btn-default">Show Me</a></td>
									</tr>
									<tr>
										<td class="middle-align">Full Width</td><td><a href="javascript:;" onclick="jQuery('#modal-3').modal('show');" class="btn btn-default">Show Me</a></td>
									</tr>
									<tr>
										<td class="middle-align">Confirm to Close</td><td><a href="javascript:;" onclick="jQuery('#modal-4').modal('show', {backdrop: 'static'});" class="btn btn-default">Show Me</a></td>
									</tr>
									<tr>
										<td class="middle-align">Long Modal</td><td><a href="javascript:;" onclick="jQuery('#modal-5').modal('show', {backdrop: 'static'}); jQuery('#modal-5').css('max-height', jQuery(window).height());" class="btn btn-default">Show Me</a></td>
									</tr>
									<tr>
										<td class="middle-align">Responsive Modal</td><td><a href="javascript:;" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="btn btn-default">Show Me</a></td>
									</tr>
									<tr>
										<td class="middle-align">Ajax Modal</td><td><a href="javascript:;" onclick="showAjaxModal();" class="btn btn-default">Show Me</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					fscanfdsfd<br />
				fadesf<br />
				sdfsdfsdfsdfsdfsdsdfsdfsd<br />
				fadesdffsd<br />
				sdfsdfsdfsdfsdfsdsdfsdfsdsf
				<br /><br /><br />
				sdfsdfsdffsdd<br />
				sdfsdfsdfsdfsdfsd<br />
				<h2>Modals Triggering</h2>
				<br />
				fscanfdsfd<br />
				fadesf<br />
				sdfsdfsdfsdfsdfsdsdfsdfsd<br />
				fadesdffsd<br />
				sdfsdfsdfsdfsdfsdsdfsdfsdsf
				<br /><br /><br />
				sdfsdfsdffsdd<br />
				sdfsdfsdfsdfsdfsd<br />
				<h2>Modals Triggering</h2>
				<br />
				</div>
				<script type="text/javascript">
					function showAjaxModal() {
						jQuery('#modal-7').modal('show', {
							backdrop : 'static'
						});
						jQuery.ajax({
							url : "https://demo.neontheme.com/data/ajax-content.txt",
							success : function(response) {
								jQuery('#modal-7 .modal-body').html(response);
							}
						});
					}
				</script><!-- TS153017878613609: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
				<!-- Footer -->
				<footer class="main">
					<div class="pull-right">
						<a href="https://themeforest.net/item/neon-bootstrap-admin-theme/6434477?ref=Laborator" target="_blank"><strong>Purchase this theme for $25</strong></a>
					</div>
					&copy; 2018 <strong>Neon</strong> Admin Theme by <a href="https://laborator.co/" target="_blank">Laborator</a>
				</footer>
			</div>
			<!-- TS153017878613625: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
			<div id="chat" class="fixed" data-current-user="Art Ramadani" data-order-by-status="1" data-max-chat-history="25">
				<div class="chat-inner">
					<h2 class="chat-header"><a href="#" class="chat-close"><i class="entypo-cancel"></i></a><i class="entypo-users"></i> Chat <span class="badge badge-success is-hidden">0</span></h2>
					<div class="chat-group" id="group-1">
						<strong>Favorites</strong><a href="#" id="sample-user-123" data-conversation-history="#sample_history"><span class="user-status is-online"></span> <em>Catherine J. Watkins</em></a><a href="#"><span class="user-status is-online"></span> <em>Nicholas R. Walker</em></a><a href="#"><span class="user-status is-busy"></span> <em>Susan J. Best</em></a><a href="#"><span class="user-status is-offline"></span> <em>Brandon S. Young</em></a><a href="#"><span class="user-status is-idle"></span> <em>Fernando G. Olson</em></a>
					</div>
					<div class="chat-group" id="group-2">
						<strong>Work</strong><a href="#"><span class="user-status is-offline"></span> <em>Robert J. Garcia</em></a><a href="#" data-conversation-history="#sample_history_2"><span class="user-status is-offline"></span> <em>Daniel A. Pena</em></a><a href="#"><span class="user-status is-busy"></span> <em>Rodrigo E. Lozano</em></a>
					</div>
					<div class="chat-group" id="group-3">
						<strong>Social</strong><a href="#"><span class="user-status is-busy"></span> <em>Velma G. Pearson</em></a><a href="#"><span class="user-status is-offline"></span> <em>Margaret R. Dedmon</em></a><a href="#"><span class="user-status is-online"></span> <em>Kathleen M. Canales</em></a><a href="#"><span class="user-status is-offline"></span> <em>Tracy J. Rodriguez</em></a>
					</div>
				</div>
				<!-- conversation template -->
				<div class="chat-conversation">
					<div class="conversation-header">
						<a href="#" class="conversation-close"><i class="entypo-cancel"></i></a><span class="user-status"></span><span class="display-name"></span><small></small>
					</div>
					<ul class="conversation-body"></ul>
					<div class="chat-textarea">
						<textarea class="form-control autogrow" placeholder="Type your message"></textarea>
					</div>
				</div>
			</div>
			<!-- Chat Histories -->
			<ul class="chat-history" id="sample_history">
				<li>
					<span class="user">Art Ramadani</span>
					<p>
						Are you here?
					</p>
					<span class="time">09:00</span>
				</li>
				<li class="opponent">
					<span class="user">Catherine J. Watkins</span>
					<p>
						This message is pre-queued.
					</p>
					<span class="time">09:25</span>
				</li>
				<li class="opponent">
					<span class="user">Catherine J. Watkins</span>
					<p>
						Whohoo!
					</p>
					<span class="time">09:26</span>
				</li>
				<li class="opponent unread">
					<span class="user">Catherine J. Watkins</span>
					<p>
						Do you like it?
					</p>
					<span class="time">09:27</span>
				</li>
			</ul>
			<!-- Chat Histories -->
			<ul class="chat-history" id="sample_history_2">
				<li class="opponent unread">
					<span class="user">Daniel A. Pena</span>
					<p>
						I am going out.
					</p>
					<span class="time">08:21</span>
				</li>
				<li class="opponent unread">
					<span class="user">Daniel A. Pena</span>
					<p>
						Call me when you see this message.
					</p>
					<span class="time">08:27</span>
				</li>
			</ul>
		</div>
		<!-- TS15301787863943: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
		<!-- Modal 1 (Basic)-->
		<div class="modal fade" id="modal-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Basic Modal</h4>
					</div>
					<div class="modal-body">
						Hello I am a Modal!
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal 2 (Custom Width)-->
		<div class="modal fade custom-width" id="modal-2">
			<div class="modal-dialog" style="width: 60%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Custom Width Modal</h4>
					</div>
					<div class="modal-body">
						Any type of width can be applied.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal 3 (Custom Width)-->
		<div class="modal fade custom-width" id="modal-3">
			<div class="modal-dialog" style="width: 96%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Full width</h4>
					</div>
					<div class="modal-body">
						Its about 100%
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal 4 (Confirm)-->
		<div class="modal fade" id="modal-4" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Confirm Modal</h4>
					</div>
					<div class="modal-body">
						You can close this modal when you click on button only!
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal">
							Continue
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal 5 (Long Modal)-->
		<div class="modal fade" id="modal-5">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Long Height Modal</h4>
					</div>
					<div class="modal-body">
						<img src="https://demo.neontheme.com/assets/images/burjkhalifa.jpg" alt="" class="img-responsive" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal 6 (Long Modal)-->
		<div class="modal fade" id="modal-6">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Modal Content is Responsive</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-1" class="control-label">Name</label>
									<input type="text" class="form-control" id="field-1" placeholder="John">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-2" class="control-label">Surname</label>
									<input type="text" class="form-control" id="field-2" placeholder="Doe">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="field-3" class="control-label">Address</label>
									<input type="text" class="form-control" id="field-3" placeholder="Address">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="field-4" class="control-label">City</label>
									<input type="text" class="form-control" id="field-4" placeholder="Boston">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="field-5" class="control-label">Country</label>
									<input type="text" class="form-control" id="field-5" placeholder="United States">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="field-6" class="control-label">Zip</label>
									<input type="text" class="form-control" id="field-6" placeholder="123456">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group no-margin">
									<label for="field-7" class="control-label">Personal Info</label>									<textarea class="form-control autogrow" id="field-7" placeholder="Write something about yourself"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal 7 (Ajax Modal)-->
		<div class="modal fade" id="modal-7">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Dynamic Content</h4>
					</div>
					<div class="modal-body">
						Content is loading...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<script src="https://demo.neontheme.com/assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
		<script src="https://demo.neontheme.com/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
		<script src="https://demo.neontheme.com/assets/js/bootstrap.js" id="script-resource-3"></script>
		<script src="https://demo.neontheme.com/assets/js/joinable.js" id="script-resource-4"></script>
		<script src="https://demo.neontheme.com/assets/js/resizeable.js" id="script-resource-5"></script>
		<script src="https://demo.neontheme.com/assets/js/neon-api.js" id="script-resource-6"></script>
	
		<!-- JavaScripts initializations and stuff -->
		<script src="https://demo.neontheme.com/assets/js/neon-custom.js" id="script-resource-9"></script>
		<!-- Demo Settings -->
		<script src="https://demo.neontheme.com/assets/js/neon-demo.js" id="script-resource-10"></script>
		
		<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-28991003-7']);
_gaq.push(['_setDomainName', 'demo.neontheme.com']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
		</script>
	</body>
</html>