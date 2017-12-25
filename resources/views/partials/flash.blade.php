@if (session()->has('flash_message'))
	<script>
		swal({   
			title: "{{ session('flash_message.title') }}",   
			text: "{{ session('flash_message.message') }}",   
			type: "{{ session('flash_message.level') }}", 
			icon: "{{ session('flash_message.level') }}",
			timer: 2000,
			button: 'OK'
		});
	</script>
@endif

@if (session()->has('flash_message_overlay'))
	<script>
		swal({   
			title: "{{ session('flash_message_overlay.title') }}",   
			text: "{{ session('flash_message_overlay.message') }}",   
			type: "{{ session('flash_message_overlay.level') }}", 
			icon: "{{ session('flash_message_overlay.level') }}",   
			buttons: true
		});
	</script>
@endif