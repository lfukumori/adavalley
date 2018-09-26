<h2>Temperature Alert!</h2>

<p>
    {{ ucfirst($monitor->room) }}'s temperature has been out of range for {{ $monitor->minutes }} minutes.
</p>

<p>
    It is currently at {{ $monitor->degrees }}{{ $monitor->scale }}
</p>


<div style="margin-top:15px">
	<a 
	    style="padding:6px 10px;margin:0;background-color:salmon;border-radius:3px;" 
	    href="http://98.250.0.22/api/alerts/dismiss/{{ $monitor->id }}/{{ $name }}">
	    Dismiss Alert Remotely
	</a>

	<a 
	    style="padding:6px 10px;margin:0;background-color:salmon;border-radius:3px;margin-left:15px;" 
	    href="http://192.168.1.12/api/alerts/dismiss/{{ $monitor->id }}/{{ $name }}">
	    Dismiss Alert Locally
	</a>
</div>
