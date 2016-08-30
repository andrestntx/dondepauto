@if(! $publisher->hasLogo())
    <h1 id="publisher-company">{{ $publisher->company }}</h1>                     
@endif

<form class="logo-upload" action="{{ route('medios.logo.upload', $publisher) }}" enctype="multipart/form-data" style="display: inline-block; vertical-align: middle;">
    <label for="file-input-logo">
        <img src="{{ $publisher->logo }}" id="image-upload-logo" style="max-height: 50px; cursor: pointer; margin-bottom: 10px; margin-top: 10px;" />
    </label>

    <input id="file-input-logo" type="file" name="logo" style="display: none;" />
</form>

<div style="display: inline-block; vertical-align: middle;">
	<div class="sk-spinner sk-spinner-circle" id="sk-spinner-logo" style="display: none;">
	    <div class="sk-circle1 sk-circle"></div>
	    <div class="sk-circle2 sk-circle"></div>
	    <div class="sk-circle3 sk-circle"></div>
	    <div class="sk-circle4 sk-circle"></div>
	    <div class="sk-circle5 sk-circle"></div>
	    <div class="sk-circle6 sk-circle"></div>
	    <div class="sk-circle7 sk-circle"></div>
	    <div class="sk-circle8 sk-circle"></div>
	    <div class="sk-circle9 sk-circle"></div>
	    <div class="sk-circle10 sk-circle"></div>
	    <div class="sk-circle11 sk-circle"></div>
	    <div class="sk-circle12 sk-circle"></div>
	</div>	
</div>
