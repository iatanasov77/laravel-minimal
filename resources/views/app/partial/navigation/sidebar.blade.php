<ul class="sidebar-menu">
@foreach( $nav as $item )
	<li @if( isset( $item['class'] ) )class="{{ $item['class'] }}" @endif>
		<a href="{{ $item['url'] }}">
			<i class="{{ $item['icon'] }}"></i>
			<span>{{ $item['label'] }}</span>
		</a>
	</li>
@endforeach
</ul>
