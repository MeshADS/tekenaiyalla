@extends("layout.master")
@include("_partials.html.default_meta")
@section("page") gallery @stop
@section("stylesheet")
	<!-- Stylesheet -->
@stop
@section("bootdata")
	<!-- Boot data -->
@stop

@section("content")

	<div class="spanned_element p-t-30">
		<div class="container">
			<div class="row">
				<div class="col-md-8 nopadding">
					<div class="spanned_element">
						<div class="container-fluid">
							<!-- Begin list -->
								<div class="row album-list" id="album-list">
									@foreach($list->photoset as $col)
										<div class="col-md-4 album-item">
											<div class="album radius m-t-30">
												<a href="{{ URL::to('gallery/'.$col->id) }}">
													<img src="https://farm{{ $col->farm }}.staticflickr.com/{{ $col->server }}/{{ $col->primary }}_{{ $col->secret }}_n.jpg" class="full-width flat-it">
													<div class="title">
														<div class="bg black-background hoverable">&nbsp;</div>
														<h5 class="uppercase xxs-text">{{ $col->title->_content }}</h5>
													</div>
												</a>
											</div>
										</div>
									@endforeach
								</div>
							@if($list->pages > 1)
								<div class="pagination-container p-v-50 text-center">
									@if($list->page > 1)
										<a href="{{ URL::to('gallery?page='.($list->page - 1)) }}" class="gray2-background hoverable m-r-20 p-v-10 p-h-10 radius bold no-text-decoration">
											<span class="white-text"><i class="fa fa-chevron-left"></i>&nbsp;Previous</span>
										</a>
									@endif
									<span class="m-r-20">
										Page {{$list->page}} of {{$list->pages}}
									</span>
									@if($list->page < $list->pages)
									<a href="{{ URL::to('gallery?page='.($list->page + 1)) }}" class="gray2-background hoverable p-v-10 p-h-10 radius bold no-text-decoration">
										<span class="white-text">Next&nbsp;<i class="fa fa-chevron-right"></i></span>
									</a>
									@endif
								</div>
							@endif
							<!-- End list -->
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="spanned_element h-30">&nbsp;</div>
					<div class="spanned_element white-background p-h-0 m-h-0 m-b-30 post-card">
						@include("_partials.html.sb_facebook")
					</div>	
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.html.sb_twitter")
					</div>
					<div class="spanned_element white-background m-b-30 post-card">
						@include("_partials.form.sb_newsletter")
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
			galleryJS.init();
		})
	</script>
@stop