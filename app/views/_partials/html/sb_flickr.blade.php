<div class="spanned_element white-background sb_flickr">
	<h4 class="spanned_element p-v-10 p-h-15 m-v-0 alt-background">
		<img src="{{ URL::to('assets/site/img/Flickr-logo.png') }}" alt="flickr-logo" class="w-60">
	</h4>
	<div class="spanned_element p-v-40 p-h-15 text-center gray-text xs-text" id="loader">Loading...</div>
	<div class="spanned_element white-background gray-text text-center p-t-55 p-b-50" id="reload">
		<h4 class="spanned_element s-text">
			<a href="#" id="reload-btn" class="no-text-decoration primary-link">
				<i class="fa fa-refresh"></i>&nbsp;Reload
			</a>			
		</h4>
		<p class="spanned_element xs-text">
			An error occured while loading photo stream.
		</p>
	</div>
	<div class="spanned_element p-v-15 p-h-15 text-center gray-text xs-text" id="flickr_photos"></div>
</div>