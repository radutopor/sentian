<div class="well well-sm" style="margin-top:50px;">
	<h4>General results:</h4>
	<div class="progress progress-striped active">
		<div class="progress-bar progress-bar-danger" style="width: {{{$analysisResult->general->likelihood->NEG*100}}}%">
			<span><strong>{{{round($analysisResult->general->likelihood->NEG*100)}}}% Negative</strong></span></div>
		<div class="progress-bar progress-bar-warning" style="width: {{{$analysisResult->general->likelihood->NEU*100}}}%">
			<span><strong>{{{round($analysisResult->general->likelihood->NEU*100)}}}% Neutral</strong></span></div>
		<div class="progress-bar progress-bar-success" style="width: {{{$analysisResult->general->likelihood->POS*100}}}%">
			<span><strong>{{{round($analysisResult->general->likelihood->POS*100)}}}% Positive</strong></span></div>
	</div>
</div>

<div class="well well-sm">
	<h4>Tag results:</h4>
	@foreach ($analysisResult->tags as $tagName => $tag)
	<h5>{{{$tagName}}}</h5>
	<div class="progress">
		<div class="progress-bar progress-bar-danger" style="width: {{{$tag->likelihood->NEG*100}}}%">
			<span><strong>{{{round($tag->likelihood->NEG*100)}}}% Negative</strong></span></div>
		<div class="progress-bar progress-bar-warning" style="width: {{{$tag->likelihood->NEU*100}}}%">
			<span><strong>{{{round($tag->likelihood->NEU*100)}}}% Neutral</strong></span></div>
		<div class="progress-bar progress-bar-success" style="width: {{{$tag->likelihood->POS*100}}}%">
			<span><strong>{{{round($tag->likelihood->POS*100)}}}% Positive</strong></span></div>
	</div>
	@endforeach
</div>

<div class="well well-sm">
	<h4>Samples:</h4>
	@foreach ($analysisResult->posts as $post)
	<h5>{{{'"'.$post->data['text'].'"'}}}</h5>
	<div class="progress">
		<div class="progress-bar progress-bar-danger" style="width: {{{$post->result->likelihood->NEG*100}}}%">
			<span><strong>{{{round($post->result->likelihood->NEG*100)}}}% Negative</strong></span></div>
		<div class="progress-bar progress-bar-warning" style="width: {{{$post->result->likelihood->NEU*100}}}%">
			<span><strong>{{{round($post->result->likelihood->NEU*100)}}}% Neutral</strong></span></div>
		<div class="progress-bar progress-bar-success" style="width: {{{$post->result->likelihood->POS*100}}}%">
			<span><strong>{{{round($post->result->likelihood->POS*100)}}}% Positive</strong></span></div>
	</div>
	@endforeach
</div>