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
									<div class="col-md-4 pull-left post-card-item">
										<div class="spanned_element white-background m-b-30 hide-overflow post-card">
											<a href="{{ URL::to('c/'.$item->slug) }}">
												<img src="{{ URL::to($item->image) }}" alt="Image" class="fullwidth">
												<h4 class="spanned_element capitalize s-text gray2-text p-h-15 bold h-50 m-v-20">
													{{ $item->name }}
												</h4>
											</a>
											<div class="spanned_element gray2-background h-55 lh-55 p-h-15 " style="border-top:solid 1px #ddd;">
												<span class="bold white-link no-text-decoration">
													{{ $item->postsCount }} Post{{ ( $item->postsCount > 1 ) ? 's' : '' }}
												</span>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>	
					<!-- Begin Pagination -->
						<div class="spanned_element p-v-20 p-h-20 text-center">
							{{ $pagination->appends(Request::except("page"))->links(); }}
						</div>
					<!-- End Pagination -->
				</div>
				<div class="col-md-4">
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.form.sb_newsletter")
					</div>
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