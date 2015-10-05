@extends("layout.master")
@include("_partials.html.default_meta")
@section("page") post @stop
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
		Site.data.post = {{ json_encode($item) }};
	</script>
@stop

@section("content")
	<!-- Begin slider -->
	<div class="spanned_element">
		<div class="container">
			<div class="row">
				<div class="col-md-12 nopadding">
					<div class="spanned_element parallax-window post-header" data-parallax="scroll" data-image-src="{{ URL::to($item->image) }}">
						<div class="post-title">
							<h4 class="white-text l-text capitalize p-h-30 m-t-60 m-b-20">
								{{ $item->title }}
							</h4>
						</div>					
					</div>
				</div>				
			</div>
		</div>
	</div>
	<!-- End slider -->

	<div class="spanned_element">
		<div class="container">
			<div class="row">
				<div class="col-md-8 nopadding">
					<div class="spanned_element p-t-20 p-b-10 p-h-30 alt-background post-meta" style="border-bottom: solid 1px #ddd;">
						<ul class="list-inline m-b-0">
							<li class="m-b-10 bold">
								<a href="{{ URL::to('a/'.($item->author->username)) }}" 
									title="{{ $item->author->first_name.' '.$item->author->last_name }}" 
									class="primary-link bold xs-text capitalise no-text-decoration">
									<img src="{{ URL::to($item->author->avatar) }}" class="w-25 h-25 round m-r-5">
								</a>
								<span class="primary-text">By:</span>
								<a href="{{ URL::to('a/'.($item->author->username)) }}" 
									title="{{ $item->author->first_name.' '.$item->author->last_name }}" 
									class="gray-text bold xs-text capitalise no-text-decoration">
									{{ $item->author->first_name." ".$item->author->last_name }}
								</a>
							</li>
							<li class="m-b-10">
								<a href="{{ URL::to('c/'.$item->category->slug) }}" 
									title="{{ $item->category->name }}" 
									class="gray-text bold xs-text capitalise no-text-decoration">
									<img src="{{ URL::to($item->category->image) }}" class="w-25 h-25 round">
									{{ $item->category->name }}
								</a>
							</li>
							<li class="m-b-10">
								<i class="fa fa-calendar"></i>
								<a href="{{ URL::to(date('Y/m/d', strtotime($item->created_at))) }}" 
									title="Posted on {{ date('D dS M, Y', strtotime($item->created_at)) }}" 
									class="gray-text bold xs-text capitalise no-text-decoration">
									{{ date('D dS M, Y', strtotime($item->created_at)) }}
								</a>
							</li>
						</ul>
					</div>
					<div class="spanned_element p-t-30 p-h-30 white-background gray-text">
						<span class="bold uppercase gray-text"><i class="fa fa-thumbs-up"></i> Share It</span>
						<ul class="list-inline m-b-0 m-t-10">
							<li class="text-center bold" title="Tweet this">
								<div class="spanned_element m-v-5">{{ $item->twitterCount }}</div>
								<a href="https://twitter.com/intent/tweet?original_referer={{ urlencode(Request::url()) }}&text={{ urlencode($item->title)}}&tw_p=tweetbutton&url={{ urlencode(Request::url()) }}"
								style="display:inline-block;"
								class="twitter-background s-text hoverable round m-text no-text-decoration w-35 h-35 lh-35 text-center" target="_blank">
									<i class="fa fa-twitter white-text"></i>
								</a>
							</li>
							<li class="text-center bold" title="Share on Facebook">
								<div class="spanned_element m-v-5">{{ $item->facebookCount }}</div>
								<a href="http://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" 
								style="display:inline-block;"
								class="facebook-background s-text hoverable round m-text no-text-decoration w-35 h-35 lh-35 text-center" target="_blank">
									<i class="fa fa-facebook white-text"></i>
								</a>
							</li>
							<li class="text-center bold" title="Share on Google Plus">
								<div class="spanned_element m-v-5">{{ $item->plusCount }}</div>
								<a href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}" 
								style="display:inline-block;"
								class="red-background s-text round hoverable m-text no-text-decoration w-35 h-35 lh-35 text-center" target="_blank">
									<i class="fa fa-google-plus white-text"></i>
								</a>
							</li>
							<li class="text-center bold" title="Email a friend">
								<div class="spanned_element m-v-5">&nbsp;</div>
								<a href="mailto:?subject={{ $item->title }}&body={{ $item->caption.'... Read more at '.Request::url() }}"
								style="display:inline-block;"
								class="primary-background s-text round hoverable m-text no-text-decoration w-35 h-35 lh-35 text-center" target="_blank">
									<i class="fa fa-envelope-o white-text"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="spanned_element p-v-30 p-h-30 white-background gray-text">
						{{ $item->body }}
					</div>
					<!-- Begin Author bio -->
						<div class="spanned_element p-b-20 p-l-90 p-r-30 alt-background gray-text" style="border-top:solid 1px #eee;">
							<img src="{{ URL::to($item->author->avatar) }}" alt="" class="w-70 l-0 t-0" style="position:absolute;">
							<div class="row">
								<div class="col-xs-12">
									<h4 class="spanned_elements m-t-20 bold m-text">
										<a href="{{ URL::to('a/'.($item->author->username)) }}" class="black-text bold">
											{{ $item->author->first_name." ".$item->author->last_name }}
										</a>
									</h4>
									<p class="spanned_elements m-b-0">
										{{ $item->author->bio }}
									</p>
									<ul class="list-inline m-t-15 m-b-0">
										@if(!is_null($item->author->facebook))
											<li>
												<a href="{{ 'https://facebook.com/'.$item->author->facebook }}" target="_blank" class="spanned_element w-30 h-30 lh-30 round white-link text-center primary-background hoverable">
													<i class="fa fa-facebook"></i>													
												</a>
											</li>
										@endif
										@if(!is_null($item->author->twitter))
											<li>
												<a href="{{ 'https://twitter.com/'.$item->author->twitter }}" target="_blank" class="spanned_element w-30 h-30 lh-30 round white-link text-center primary-background hoverable">
													<i class="fa fa-twitter"></i>													
												</a>
											</li>
										@endif
										@if(!is_null($item->author->instagram))
											<li>
												<a href="{{ 'https://instagram.com/'.$item->author->instagram }}" target="_blank" class="spanned_element w-30 h-30 lh-30 round white-link text-center primary-background hoverable">
													<i class="fa fa-instagram"></i>													
												</a>
											</li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					<!-- Ens Author Bio -->
					<!-- Begin comments -->
						<!-- <h4 class="spanned_element alt-text gray2-background s-text uppercase p-h-30 m-v-0 p-v-20">
							Comments(0)
						</h4>
						<div class="spanned_element p-v-30 p-h-30 white-background gray-text">
							
						</div> -->
					<!-- End comments -->
				</div>
				<div class="col-md-4">					
					<div class="spanned_element h-30">&nbsp;</div>
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.form.sb_newsletter")
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
	<!-- Javascript -->
	<script type="text/javascript">
		$(function(){
			postJS.init();
		});
	</script>
@stop