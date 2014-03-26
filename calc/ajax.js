function send()
{
	var postdata = $("#myform").serialize();
       $.ajax({
                type: "POST",
                url: "SendData.php",
                data: postdata,
				cache: false,
                success: function(html) {

                        $("#result").empty();

                        $("#result").append(html);
                }
        });

}