<script>
  function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $("#referral_btn").text('Copied!');
    $("#referral_btn").removeClass("btn btn-primary");
    $("#referral_btn").addClass("btn btn-success");
    setTimeout(
	function() 
	{
		$("#referral_btn").text('Copy to clipboard');
		$("#referral_btn").removeClass("btn btn-success");
		$("#referral_btn").addClass("btn btn-primary");
	}, 1000);
  }
</script>