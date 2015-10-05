@extends("layout.master")
@include("_partials.html.default_meta")
@section("page") event @stop
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
					<div class="spanned_element white-background p-h-0 m-b-30">
						<div class="spanned_element white-background p-h-30 p-v-20">
							<span class="bold s-text gray-text">
								{{ $list->getTotal() }} Event{{ ($list->getTotal() == 1) ? '' : 's' }} found.
							</span>

							<a href="#" class="btn btn-default pull-right flat-it" data-target="#filterAccordion" data-toggle="myaccordion">
								Filters&nbsp;<i class="fa fa-caret-down"></i>
							</a>
						</div>
						<div class="spanned_element alt-background p-h-30 p-v-20 myaccordion" 
							 id="filterAccordion"
							 style="border-top:solid 1px #ddd;">
							<div class="row">
								<div class="col-md-6">
									
								</div>
								<div class="col-md-6">									
									<select name="" class="pull-right category-options">
										<option value="{{ URL::to('events') }}">Select Category</option>
										@foreach($categories as $category)
											<option value="{{ URL::to('events/c/'.$category->slug) }}" 
													{{ ( $selectedCategory == $category->slug ) ? ' selected ' : '' }}>
												{{ $category->name }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="container-fluid">
							<?php $i = 0; ?>
							@foreach($list as $item)
								<?php $modus = $i % 2; ?>
								<div class="row">
									<!-- Begin Large Accordion Toggler -->
									<div class="col-md-12 nopadding visible-lg visible-md">
										<div class="spanned_element p-l-20 p-r-200  bg-olay-hoverable {{ ( $modus > 0 ) ? ' secondary-background ' : ' primary-background ' }} hoverable">
											<a href="#" class="no-text-decoration alt-link" data-toggle="myaccordion" data-target="#eventAccordion{{$item->id}}" data-group="eventAccordion">
												<h4 class="white-text m-v-0 p-t-35 h-55 ellipsis">
													{{ $item->title }}
												</h4>
												<h6 class="m-v-0 h-50 p-t-5 ellipsis">
													{{ date("D dS M, Y", strtotime($item->schedule_starts)) }}
												</h6>
											</a>
											<div class="absolute w-200 h-100-percent r-0 t-0 white-text xs-text"
												 style="background:url({{ URL::to($item->category->image) }}) 0px 0px no-repeat; 
										   				background-size:cover;">
										   		<div class="black-background dark bg-olay">&nbsp;</div>
										   		<a href="{{ URL::to('events/c/'.$item->category->slug) }}">
										   			<h4 class="spanned_element capitalize m-v-0 text-center s-text white-text p-h-15 h-105 lh-105 ellipsis">
														{{ $item->category->name }}
										   			</h4>										   			
										   		</a>
											</div>
										</div>
									</div>
									<!-- End Large Accordion Toggler -->
									<!-- Begin Small Accordion Toggler -->
										<div class="col-md-12 nopadding visible-sm visible-xs">
											<div class="spanned_element p-h-20 p-v-25  bg-olay-hoverable {{ ( $modus > 0 ) ? ' secondary-background ' : ' primary-background ' }} hoverable">
												<a href="#" class="no-text-decoration alt-link" data-toggle="myaccordion" data-target="#eventAccordion{{$item->id}}" data-group="eventAccordion">
													<h4 class="white-text m-v-0">
														{{ $item->title }}
													</h4>
													<h6 class="m-v-0 p-t-5">
														{{ date("D dS M, Y", strtotime($item->schedule_starts)) }}
													</h6>
												</a>
												<h6 class="spanned_element p-t-10 m-v-0 ellipsis">
													<a href="{{ URL::to('events/c/'.$item->category->slug) }}" title="" class="white-link">
														Category: <span class="bold">{{ $item->category->name }}</span>
													</a>
												</h6>													
											</div>
										</div>
									<!-- End Small Accordion Toggler -->
									<div class="spanned_element p-h-15 myaccordion eventAccordion white-background" id="eventAccordion{{$item->id}}">
										@if(!empty($item->venue))
											<p class="spanned_element s-text bold gray2-text m-v-15 text-center">
												<i class="fa fa-map-marker"></i>
												{{ $item->venue }}
											</p>
										@endif
										@if(!empty($item->description))
											<p class="spanned_element s-text normal gray-text m-v-15 p-h-10">
												{{ $item->description }}
											</p>
										@endif
									</div>
								</div>
								<?php $i++; ?>
							@endforeach
						</div>
						@if($list->getLastPage() > 1)
							<div class="spanned_element white-background p-h-30 text-center">
								{{ $list->appends(Request::except("page"))->links(); }}
							</div>
						@endif
					</div>
				</div>
				<div class="col-md-4">					
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_flickr")
					</div>
					<div class="spanned_element white-background p-h-0 m-h-0 m-b-30 post-card">
						@include("_partials.html.sb_facebook")
					</div>	
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_twitter")
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
			eventJS.init();
		});
	</script>
@stop