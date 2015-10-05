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
	@if(is_null($searchVal) || strlen(trim($searchVal)) < 1)
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
				<div class="col-md-8">
					@if(!is_null($searchVal) && strlen(trim($searchVal)) > 0)
						<div class="spanned_element m-b-20">
							<h4 class="gray-text l-text normal">
								Serach For: <span class="bold">"{{ $searchVal }}"</span>
							</h4>	
							<h6 class="">
								<a href="{{ URL::to($searchIn) }}" class="xs-text">Clear Search</a>
							</h6>
						</div>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 nopadding">
					<div class="spanned_element">
						<div class="container-fluid">
							<div class="row" id="post-card-container">
								@foreach($list as $item)
									<div class="col-md-6 pull-left post-card-item">
										<div class="spanned_element white-background m-b-30 hide-overflow post-card">
											<a href="{{ URL::to(date('Y/m/d', strtotime($item->created_at))).'/'.$item->slug }}">
												<img src="{{ URL::to($item->thumbnail) }}" alt="Image" class="fullwidth">
												<h4 class="spanned_element capitalize s-text gray2-text p-h-15 bold h-50 m-v-20">
													{{ $item->title }}
												</h4>
											</a>
											<p class="spanned_element xs-text p-h-15 gray-text h-70">
												{{ $item->caption."..." }}
												<a href="{{ URL::to(date('Y/m/d', strtotime($item->created_at))).'/'.$item->slug }}" 
													class="primary-link no-text-decoration bold">
													Read&nbsp;<i class="fa fa-caret-right"></i>
												</a>
											</p>
											<h6 class="spanned_element gray-text h-10 lh-10 p-h-15 xxs-text bold text-right" data-livestamp="{{ strtotime($item->created_at) }}">&nbsp;</h6>
											<div class="spanned_element gray2-background h-55 lh-55 p-h-15 " style="border-top:solid 1px #ddd;">
												<a href="{{ URL::to('c/'.$item->category->slug) }}" class="bold white-link no-text-decoration">
													<img src="{{ URL::to($item->category->image) }}" title="" class="w-30">
													&nbsp;{{ $item->category->name }}													
												</a>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					@if($list->getLastPage() > 1)
						<!-- Begin Pagination -->
							<div class="spanned_element p-v-20 p-h-20 text-center">
								{{ $list->appends(Request::except("page"))->links(); }}
							</div>
						<!-- End Pagination -->
					@endif
				</div>
				<div class="col-md-4">
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_soundcloud")
					</div>
					<div class="spanned_element white-background p-h-0 m-h-0 m-b-30 post-card">
						@include("_partials.html.sb_facebook")
					</div>	
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_twitter")
					</div>
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.form.sb_newsletter")
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