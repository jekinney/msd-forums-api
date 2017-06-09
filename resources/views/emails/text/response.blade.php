@component('mail::message')
<h1>Text Reply</h1>

<p>A reply to a text was recieved from <strong>{{ $name }}</strong>.</p>
<p>{{ $text }}</p>
<p>Contact information is:</p>
<ul>
	<li>Email: {{ $email }}</li>
	<li>Phone: {{ $phone }}</li>
</ul>

Thank You,<br>
Your Friendly Mid-States Distributing IT Department
@endcomponent