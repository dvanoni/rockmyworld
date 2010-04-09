<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Hello World - Google AJAX Search API Sample</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"
        type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			$("#youtube-query").submit(function() {
				var form_data = $(this).serialize();
				$.post("request.php", form_data, function(data) {
					$("#youtube-result").html(data);
				}, "html");
				return false;
			});
		});
	</script>
  </head>
  <body>
    <form id="youtube-query">
		<input type="text" name="query"/>
		<input type="submit"/>
	</form>
	<div id="youtube-result"></div>
  </body>
</html>