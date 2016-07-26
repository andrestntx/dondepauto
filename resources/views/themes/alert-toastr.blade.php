@foreach ($messages as $msg)
    <span id="messaget" data-message="{{ $msg['message'] }}" data-details="{{ $msg['details'] }}"></span>
@endforeach

<script type="text/javascript"> 
  toastr.success($("#messaget").data("details"), $("#messaget").data("message"));
</script>