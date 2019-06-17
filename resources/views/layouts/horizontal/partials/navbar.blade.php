<header id="topnav">
	<div class="topbar-main">
		<div class="container clearfix">
			<div class="topbar-left">
				<a href="{{ url('/') }}" class="logo">
					<i class="zmdi zmdi-dialpad"></i>
					<span>Management global des stocks {!! App::environment('local', 'testing') ? "<span>" . App::environment() . "</span>" : "" !!}</span>
				</a>
			</div>
		</div>
	</div>
	@include('layouts/horizontal/partials/sub-navbar')
</header>