<h1>Text Reply</h1>


<article>
	<p>A reply to a text was recieved from <strong>{{ $recipient->name }}</strong>.</p>
	<p>{{ $recipient->notes }}</p>
	<p>Contact information is:</p>
	<ul>
		<li>Email: {{ $recipient->email }}</li>
		<li>Phone: {{ $recipient->phone }}</li>
	</ul>
</article>