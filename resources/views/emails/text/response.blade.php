<h1>Text Reply</h1>


<article>
	@foreach($request as $key => $value) 
		<p>{{ $value }}</p>
	@endforeach
</article>