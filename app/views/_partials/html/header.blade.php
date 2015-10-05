<header class="sticky">
	@yield("top-notification")
	<div class="menu">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="menu-list">
						<li class="lg-menu-logo visible-lg visible-md">
							<a href="{{ URL::to('') }}">
								<img src="{{ URL::to($basicdata->logo) }}" alt="Logo">
							</a>
						</li>
					</ul>
					<ul class="menu-list visible-lg visible-md">
						@foreach($menus as $menu)
							<li class="menu-item {{ ( count($menu->submenus) > 0 ) ? 'has-sub' : ' ' }} {{ ($page->slug == $menu->slug) ? ' active ' : '' }}">
								<a href="{{ ( count($menu->submenus) > 0 ) ? 'javascript:;' : $menu->url }}" class="menu-link" target="{{ ( $menu->ext > 0 ) ? '_blank' : '_self' }}">
									{{ $menu->title }} {{ ( count($menu->submenus) > 0 ) ? '<i class="fa fa-caret-down"></i>' : '' }}
								</a>
								@if( count($menu->submenus) > 0 )
									<div class="sub">
										<ul class="submenu-list">
											@foreach($menu->submenus as $submenu)
												<li class="submenu-item">
													<a href="{{ $submenu->url }}" target="{{ ( $submenu->ext > 0 ) ? '_blank' : '_self' }}">
														{{ $submenu->title }}
													</a>
												</li>
											@endforeach
										</ul>										
									</div>
								@endif
							</li>
						@endforeach
					</ul>
					<ul class="menu-list visible-sm visible-xs">
						<li class="alt-menu-item active">
							<a href="javascript:;" id="mobile-menu-toggler" class="menu-link text-center m-text p-h-0 p-v-0 h-40 w-40 lh-40 flat-it">
								<i class="fa fa-bars m-l-0"></i>
							</a>
						</li>
					</ul>
					<ul class="menu-list right">
						<li class="menu-item">
							{{ Form::open(["url"=>$searchIn, "method"=>"get"]) }}
								<input type="text" name="search" value="{{ $searchVal }}" placeholder="Search here..." class="searchField" required>
							{{ Form::close() }}
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Begin Small Menu Logo -->
			<div class="sm-menu-logo visible-sm visible-xs">
				<a href="{{ URL::to('') }}">
					<img src="{{ URL::to($basicdata->logo) }}" alt="Logo">
				</a>
			</div>
		<!-- End Small Menu Logo -->
		<!-- Begin Mobile Menu -->
			<div class="mobile_menu visible-sm visible-xs">
				<ul class="mobile-menu-list">
						@foreach($menus as $menu)
							<li class="menu-item {{ ( count($menu->submenus) > 0 ) ? 'has-sub' : ' ' }} {{ ($page->slug == $menu->slug) ? ' active ' : '' }}">
								<a href="{{ ( count($menu->submenus) > 0 ) ? 'javascript:;' : $menu->url }}" class="menu-link" target="{{ ( $menu->ext > 0 ) ? '_blank' : '_self' }}">
									{{ $menu->title }} {{ ( count($menu->submenus) > 0 ) ? '<i class="fa fa-caret-right"></i>' : '' }}
								</a>
								@if( count($menu->submenus) > 0 )
									<div class="sub">
										<ul class="submenu-list">
											@foreach($menu->submenus as $submenu)
												<li class="submenu-item">
													<a href="{{ $submenu->url }}" target="{{ ( $submenu->ext > 0 ) ? '_blank' : '_self' }}">
														{{ $submenu->title }}
													</a>
												</li>
											@endforeach
										</ul>										
									</div>
								@endif
							</li>
						@endforeach
					</ul>
			</div>
		<!-- End Mobile Menu -->
	</div>
</header>