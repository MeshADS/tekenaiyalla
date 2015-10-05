@extends('wcp::layout.master')
@section('jumbotron_breadcrumb')
	<ul class="breadcrumb">
	    <li>
	      <a href="{{ URL::to('admin') }}"><i class="fa fa-home"></i></a>
	    </li>
	    <li>
	      <a href="{{ URL::to('admin/accounts') }}">Accounts</a>
	    </li>
	    <li><a href="{{ Request::url() }}" class="active">Profile</a>
	    </li>
	</ul>
@stop
@section('jumbotron')
	@include('wcp::_partials.html.jumbotron')
@stop
@section("stylesheet")

	{{ HTML::style('assets/wcp/plugins/croppic/assets/css/croppic.css') }}

	<style type="text/css">
		.nopadding{
			padding: 0px 0px !important;
		}
		.nomargin{
			margin: 0px 0px !important;
		}
		#newAvatarCrop {
			width: 256px;
			height: 256px;
			position:relative; /* or fixed or absolute */
		}
		.newAvatarTriger{
			position:absolute;
			right:0px;
			top:0px;
			width:36px;
			height:36px;
			line-height:36px;
			text-align:center;
			background-color:#000;
			color:#fff;
			font-size:14px;
			text-decoration: none;
			opacity:0.5;
		}
		.newAvatarTriger:focus, .newAvatarTriger:hover, .newAvatarTriger:active{
			text-decoration: none;
			color:#fff;
			opacity: 1;
		}
		.new-element-dl-btn{
			position:absolute;
			right:0px;
			bottom:17px;
			width:30px;
			height:30px;
			line-height:30px;
			text-align:center;
			background-color: #ccc;
			color:#fff;
			border-radius:30px;
			-moz-border-radius:30px;
			-ms-border-radius:30px;
			-o-border-radius:30px;
			-webkit-border-radius:30px;
		}
		.new-element-dl-btn:hover, .new-element-dl-btn:focus, .new-element-dl-btn:visited{
			color:#fff;
		}
		.listValues >.row{
			position:relative;
			float:left;
			width:100%;
		}

		.listValues >.row .delMessage{
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: #fff;
			color: #ff0000;
			font-size: 1em;
			font-style: italic;
			opacity:0.8;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-ms-box-sizing: border-box;
			-o-box-sizing: border-box;
			display:none;
		}
	</style>

@stop
@section("bootdata")
	<script type="text/javascript">
        window.Site = window.Site || {};
        //Config
        Site.data = Site.data || {};
        Site.data.user = {{ json_encode($item) }};
    </script>
@stop
@section('content')

	{{-- Begin Edit Avatar Modal --}}
		<div class="modal fade slide-down disable-scroll" id="editAvatarModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-sm">

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="close">
							<span aria-hidden="true"><i class="fa fa-times"></i></span>
						</button>
						<h4 class="modal-title">
							New Avatar
						</h4>
					</div>

					<div class="modal-body">

						<div id="newAvatarCrop"></div>

					</div>

					<div class="modal-footer">
						<!-- Empty footer -->
					</div>
				</div>

			</div>

		</div>
	{{-- End Edit Avatar Modal --}}

	{{-- Begin Edit Account Modal --}}
		<div class="modal fade slide-down disable-scroll" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">
					{{ Form::open(["url"=>"admin/accounts/".$item->id, "role"=>"form", "method"=>"put"]) }}
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="close">
								<span aria-hidden="true"><i class="fa fa-times"></i></span>
							</button>
							<h4 class="modal-title">
								Edit Form
							</h4>
						</div>

						<div class="modal-body">

							<div class="form-group form-group-default">
								{{ Form::label("first_name", "First Name") }}
								{{ Form::text("first_name", $item->first_name, ["class"=>"form-control", "placeholder"=>"Enter first name"]) }}
							</div>

							<div class="form-group form-group-default">
								{{ Form::label("last_name", "Last Name") }}
								{{ Form::text("last_name", $item->last_name, ["class"=>"form-control", "placeholder"=>"Enter last name"]) }}
							</div>

							<div class="form-group form-group-default">
								{{ Form::label("email", "Email") }}
								{{ Form::text("email", $item->email, ["class"=>"form-control", "placeholder"=>"Enter email"]) }}
							</div>

							<div class="form-group form-group-default">
								{{ Form::label("username", "Username") }}
								{{ Form::text("username", $item->username, ["class"=>"form-control", "placeholder"=>"Enter username"]) }}
								<small class="bold">Only the following characters sets are accepted A-z, 0-9, underscores and dashes</small>
							</div>

							<div class="form-group form-group-default">
					          	{{ Form::label("group", "Group") }}
					          	{{ Form::select("group", $groups, $item->groups[0]->id, ["class"=>"form-control"]) }}
					        </div>

							<div class="form-group form-group-default">
								{{ Form::label("bio", "Bio") }}
								{{ Form::textarea("bio", $item->bio, ["class"=>"form-control", "placeholder"=>"Enter bio here"]) }}
							</div>

							<div class="form-group form-group-default">
								{{ Form::label("facebook", "Facebook") }}
								{{ Form::text("facebook", $item->facebook, ["class"=>"form-control", "placeholder"=>"Enter handle here. E.g. username"]) }}
							</div>

							<div class="form-group form-group-default">
								{{ Form::label("twitter", "Twitter") }}
								{{ Form::text("twitter", $item->twitter, ["class"=>"form-control", "placeholder"=>"Enter handle here. E.g. username"]) }}
							</div>

							<div class="form-group form-group-default">
								{{ Form::label("instagram", "Instagram") }}
								{{ Form::text("instagram", $item->instagram, ["class"=>"form-control", "placeholder"=>"Enter handle here. E.g. username"]) }}
							</div>

							<div class="form-group form-group-default">
					          	{{ Form::label("group", "Group") }}
					          	{{ Form::select("group", $groups, $item->groups[0]->id, ["class"=>"form-control"]) }}
					        </div>

						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-success pull-right">
								Save
							</button>
							<a href="#" class="btn btn-default pull-right m-r-10" data-dismiss="modal">
								Cancel
							</a>
						</div>
					{{ Form::close() }}

				</div>

			</div>

		</div>
	{{-- End Edit Account Modal --}}

	<div class="container-fluid">
		<!-- Begin Row -->
		<div class="row">
			<!-- Begin Column -->
			<div class="col-md-3">
				<!-- Avatar -->
				<div class="panel panel-transparent">
					<div class="panel-body nopadding">
						<a href="javascript:;"
							title="Change avatar" class="newAvatarTriger" id="newAvatarTriger">
							<i class="fa fa-pencil"></i>
						</a>
						<img src="{{ (!is_null($item->avatar)) ?  URL::to($item->avatar) : URL::to(Config::get('settings.avatar')) }}" alt="Avatar" id="account_avatar" class="img-responsive">
					</div>
				</div>
				<!-- Avatar -->
			</div>
			<!-- End Column -->
			<div class="col-md-9">
				<!-- Beging Basic Account Data -->
				<div class="panel panel-default" style="margin-bottom:0px;">
					<div class="panel-heading">
						<div class="panel-controls">
							<ul>
								<li>
				                	<a href="#" class="portlet-collapse" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></a>
				                </li>
				            </ul>
						</div>
					</div>
					<div class="panel-body">
						<h4 class="nomargin">
							{{ $item->first_name." ".$item->last_name }} <span class="bold" style="font-size:13px;">{{ $item->username }}</span>
						</h4>
						<h5 class="nomargin" style="font-weight:400;">{{ $item->email }}</h5>
						<ul class="list-inline">
							<li>
								<a href="{{ (!is_null($item->facebook)) ? 'https://facebook.com/'.$item->facebook : '' }}">
									<i class="fa fa-facebook"></i> {{ $item->facebook }}
								</a>
							</li>
							<li>
								<a href="{{ (!is_null($item->twitter)) ? 'https://twitter.com/'.$item->twitter : '' }}">
									<i class="fa fa-twitter"></i> {{ $item->twitter }}
								</a>
							</li>
							<li>
								<a href="{{ (!is_null($item->instagram)) ? 'https://instagram.com/'.$item->instagram : ''}}">
									<i class="fa fa-instagram"></i> {{ $item->instagram }}
								</a>
							</li>
						</ul>
						<h6 class="bold m-t-20">{{ $item->group->name }}</h6>
					</div>
				</div>
				<!-- End Basic Account Data -->
			</div>			
		</div>
		<!-- End Row -->
	</div>
	
@stop

@section("javascript")
	{{ HTML::script('assets/wcp/plugins/croppic/assets/js/jquery.mousewheel.min.js') }}
	{{ HTML::script('assets/wcp/plugins/croppic/croppic.js') }}
	{{ HTML::script("assets/wcp/plugins/boostrap-form-wizard/js/jquery.bootstrap.wizard.min.js") }}
	{{ HTML::script("assets/wcp/js/user_results.js") }}
	<script type="text/javascript">
		$(function(){
			var url = Site.Config.url;
			var user = Site.data.user;
			var cropperOptions = {
				modal:true,
				zoomFactor:20,
				rotateControls:false,
				customUploadButtonId:'newAvatarTriger',
				uploadUrl:url+'/api/user/uploadAvatar',
				cropUrl:url+'/api/user/cropAvatar',
				uploadData:{
					"user": user.id,
					"_token": Site.Config.token
				},
				cropData:{
					"user": user.id,
					"_token": Site.Config.token
				},
				onAfterImgCrop: function(data){
					$("#account_avatar").prop("src", url+"/"+data.url);
					 $('body').pgNotification({
	                    message:data.message,
	                    style:'flip',
	                    type: data.level,
	                    timeout:7000,
	                    showClose:true
	                }).show();
					resetCroper();
				},
				onError: function(errormsg){
					 $('body').pgNotification({
	                    message:errormsg,
	                    style:'flip',
	                    type: 'danger',
	                    timeout:7000,
	                    showClose:true
	                }).show();
				}
			};
			var cropper = new Croppic('newAvatarCrop', cropperOptions);

			function resetCroper(){
				cropper.reset();
			}

			user_result.init();
		});
	</script>
@stop