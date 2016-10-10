<?php
/*
	upload.php
	/srv/Sites/Vortex/html/php/upload.php
	Nathan Denig
	nathan@denig.me

	upload.php has the user select the video file for upload and chose the title and description which it posts to video_upload.php.
*/
	
	//Builds form in HTML
	$nl = "\n";
	$tab = "             ";
	$f1 = '      <div class="container center-block">' . $nl . '          <form enctype="multipart/form-data" form action="/php/video_upload.php" method="post">';
	$f2 = "    	   	<div class=form-group>\n $tab <h1>Video Upload</h1><br>\n $tab <h4>Please Enter a Title for the Uploaded Video:</h4><br>\n";
    $f3 = $tab . '<textarea class="form-control" rows="1" id="comment" name="title"></textarea><br><br>			<h4>Now Describe the Video in 140 Characters or Less:</h4><br>';
	$f4 = $nl . $tab . '<textarea class="form-control" rows="2" id="comment" name="description"></textarea><br><br>' . $nl . $tab . '<h4>Video:</h4><br>' . $nl . $tab . '<input type="file" name="uploaded_video"';
	$f5 = ' id="uploaded_video">' . $nl . $tab . '<input type="submit" value="Upload Video" class="btn btn-default btn-" name="submit">' . $nl;
	$f6 = "          </div>\n          </form>\n      </div>";

	$form_builder = $f1 . $f2 . $f3 . $f4 . $f5 . $f6;

	//Outputs page for user input
	require("header.php");

	echo $form_builder;

	require("footer.php");
?>

