<?php                                                                                                                                                                                                                
function basePage($heading, $para)                                                                                                                                                                                   
{                                                                                                                                                                                                                    
?>                                                                                                                                                                                                                   
<!DOCTYPE html>                                                                                                                                                                                                      
<html>                                                                                                                                                                                                               
<head>                                                                                                                                                                                                               
  <meta charset="UTF-8">
  <title>Vigilant Video</title>

  <!-- Bootstrap 3 - Latest compiled and minified CSS -->
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">

  <!-- JQuery 2.x -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
          integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
          crossorigin="anonymous">
  </script>
</head>                                                                                                                                                                                                              
<body>                                                                                                                                                                                                               
    <div class="container">                                                                                                                                                                                              
        <section>                                                                                                                                                                                                    
            <h1><?php echo($heading);?></h1>                                                                                                                                                           
            <p>                                                                                                                                                                                        
                <?php echo($para);?>                                                                                                                                                                                 
            </p>                                                                                                                                                                                                     
        </section>                                                                                                                                                                                                   
    </div>                                                                                                                                                                                                           
</body>                                                                                                                                                                                                              
</html>                                                                                                                                                                                                              
<?php                                                                                                                                                                                                                
}                                                                                                                                                                                                                    
?>      
