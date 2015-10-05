@extends("layout.master")
@include("_partials.html.default_meta")
@section("page") home @stop
@section("stylesheet")
	<!-- Stylesheet -->
@stop
@section("bootdata")
	<script type="text/javascript">
		window.Site = window.Site || {};
		//Config
		Site.Config = Site.Config || {};
		Site.Config.env = "{{ App::environment() }}";
		Site.Config.url = "{{ Config::get('app.url') }}";
		Site.Config.apiUrl = Site.Config.url+"/api/";
	</script>
@stop

@section("content")
	@if( count($headers) > 0 && ( is_null($searchVal) || strlen(trim($searchVal)) < 1 ) )
		<!-- Begin slider -->
		<div class="heroslider-container">
			<div class="container">
				<div class="col-md-12 nopadding">
					<div class="heroslider-nav">

						<a href="#" class="nav-item prev flat-it"><span class="icon white-text"><i class="fa fa-chevron-left"></i></span></a>

						<a href="#" class="nav-item next flat-it"><span class="icon white-text"><i class="fa fa-chevron-right"></i></span></a>

					</div>
					<ul class="heroslider">
						@foreach($headers as $header)
							<li class="heroslider-item">
								@if(!empty($header->link_url) && empty($header->link_title))
								<a href="{{ $header->link_url }}">
									<img src="{{ URL::to($header->image) }}" class="heroslider-image  {{ (!empty($header->mobile_image)) ? 'visible-lg visible-md' : '' }}">
									@if(!empty($header->mobile_image))
										<img src="{{ URL::to($header->mobile_image) }}" class="heroslider-image visible-sm visible-xs">
									@endif
								</a>
								@else
									<img src="{{ URL::to($header->image) }}" class="heroslider-image {{ (!empty($header->mobile_image)) ? 'visible-lg visible-md' : '' }}">
									@if(!empty($header->mobile_image))
										<img src="{{ URL::to($header->mobile_image) }}" class="heroslider-image visible-sm visible-xs">
									@endif
								@endif
								
								@if(!empty($header->caption) || !empty($header->link_title))
								<div class="heroslider-caption">
									<ul>
										@if(!empty($header->title))
											<a href="{{ (!empty($header->link_url)) ? $header->link_url : 'javascript:;' }}" class="xs-text">
												<li class="bold s-text primary-text visible-lg visible-md capitalize">{{ $header->title }}</li>
												<li class="bold s-text primary-text visible-sm visible-xs capitalize">{{ $header->title }}</li>
											</a>
										@endif
										@if(!empty($header->caption))
											<li class="caption thin-font xs-text visible-lg visible-md">{{ $header->caption }}</li>
											<li class="caption thin-font xxs-text visible-sm visible-xs">{{ $header->caption }}</li>
										@endif
										@if(!empty($header->link_url))
											<li class="link">
												@if( $header->link_type == 1 )
													<a href="{{ $header->link_url }}" class="xs-text">
														<span class="white-text">{{ $header->link_title }}</span>
														<i class="fa fa-caret-right primary-text"></i>
													</a>
												@else
													<a href="{{ $header->link_url }}" class="btn primary-background hoverable flat-it white-link btn-sm">
														{{ $header->link_title }}
														<i class="fa fa-caret-right"></i>
													</a>
												@endif
											</li>
										@endif
									</ul>
									<div class="dark bg-olay black-background">&nbsp;</div>
								</div>
								@endif
								<div class="black-background bg-olay heroslider-item-mask">&nbsp;</div>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<!-- End slider -->
	@endif

	<div class="spanned_element p-t-30">
		<div class="container">
			<div class="row">
				<div class="col-md-8 nopadding">
					<div class="spanned_element white-background p-v-30 p-h-30">
						<p>
							{{ $pagedata["about"]["tekena"]["body"] }}							
						</p>
						<p class="spanned_element">
							{{ $pagedata["about"]["posts"]["body"] }}
						</p>
						@if(strlen(@$pagedata["about"]["socials"]["body_notags"]) > 0)
								<?php
									$socials = explode("|", $pagedata["about"]["socials"]["body_notags"]);
								?>
							<ul class="list-inline m-t-20">
								@foreach($socials as $social)
									<?php 
										$social = trim($social);
										$social = explode("-", $social);
									?>
									<li>
										<a href="{{ trim($social[1]) }}" title="{{ trim($social[0]) }}" target="_blank" class="spanned_element w-30 h-30 lh-30 round white-link text-center primary-background hoverable">
											<i class="fa fa-{{ trim(strtolower($social[0])) }}"></i>													
										</a>
									</li>
								@endforeach
							</ul>
						@endif
					</div>
				</div>
				<div class="col-md-4">
					<div class="spanned_element white-background p-h-0 m-h-0 m-b-30 post-card">
						@include("_partials.html.sb_facebook")
					</div>	
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_twitter")
					</div>
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_flickr")
					</div>
				</div>
			</div>		
		</div>
	</div>

@stop

@section("javascript")
	{{ HTML::script('assets/site/plugins/countdown/dest/jquery.countdown.min.js') }}
	<!-- Javascript -->
	<script type="text/javascript">
		$(function(){
			homeJS.init();
		});
	</script>
@stop