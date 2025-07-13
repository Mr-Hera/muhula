<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function(){
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "showDuration": "5000",
	  "hideDuration": "5000",
	  "timeOut": "5000",
	  "extendedTimeOut": "5000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	@if(Session::has('success'))
	// Display a success toast, with no title
		toastr.success('{!!Session::get('success')!!}');
	@endif
	@if(Session::has('error'))
		// Display a error toast, with no title
		toastr.error('{!!Session::get('error')!!}');
	@endif
	@if(Session::has('warning'))
	// Display a warning toast, with no title
		toastr.warning('{!!Session::get('warning')!!}')
	@endif

});
</script>