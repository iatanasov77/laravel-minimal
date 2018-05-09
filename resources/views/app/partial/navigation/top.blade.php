<ul class="nav pull-right top-menu">
	<li class="dropdown">
		<a data-toggle="dropdown" class="dropdown-toggle" href="#"> 
			<span class="profile-ava">
				<img alt="{{ $user->email }}" 
					src="{{ get_uploaded_file( 'um_users', 'image', $user->id ) }}" 
					height="33"
				/>
			</span>
			<span class="username">{{ $user->name }} {{ $user->last_name }}</span> <b class="caret"></b>
		</a>
		<ul class="dropdown-menu extended logout">
			<div class="log-arrow-up"></div>
			<li class="eborder-top"><a href="{{ route( 'app.profile.show-form' ) }}"><i class="icon_profile"></i>My Profile</a></li>
			<li><a href="{{ route( 'app.auth.logout' ) }}"><i class="icon_key_alt"></i> Log Out</a></li>
		</ul>
	</li>
	<!-- user login dropdown end -->
</ul>
