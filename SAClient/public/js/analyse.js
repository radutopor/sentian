$(function()
{
	$('#analyse').click(function()
	{
		$('#analysis_result').empty();
		$('#analysing').show();
		$('#analyse').hide();
		$.ajax(
		{
			url: '/analyse?q=' + $("#analyse_in").val(),
			success: function(result)
			{
				$('#analysing').hide();
				$('#analyse').show();
				$('#analysis_result').append(result);
			}
		});
	})
});