<script>
    function copyToClipboard(element) 
    {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $("#copy_to_clipboard").text("Copied!");
        $("#copy_to_clipboard").removeClass("btn btn-info");
        $("#copy_to_clipboard").addClass("btn btn-success");
        setTimeout(
          	function() 
          	{
          		$("#copy_to_clipboard").text('Copy to clipboard');
          		$("#copy_to_clipboard").removeClass("btn btn-success");
          		$("#copy_to_clipboard").addClass("btn btn-info");
          	}, 1000);
    }
</script>