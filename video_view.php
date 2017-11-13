<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT id, title, url, thumbnail FROM videos WHERE id = :id');
$stmt->execute(array(':id' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['id'] == ''){
	header('Location: ./');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Video |  - <?php echo $row['title'];?></title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
	<script type='text/javascript' src='https://content.jwplatform.com/libraries/4KeoCAkM.js'></script>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#"><img src="images/upslogo.jpg" /></a>
        
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <h1 class="content-title text-center text-lg-left">Video Gallery</h1>

      <div class="row text-center text-lg-left">
	  
	  <div id="video-container">Loading the player...</div>

        
      </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; UPS Corporate video 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type='text/javascript'>
jwplayer('video-container').setup({
  flashplayer: 'jwplayer/player.swf',
  file:'videos/clipcanvas_preview_85418.mp4',
  height: 200,
  width: 400,
  autostart: true,
  'playlist.position': 'right',
  'playlist.size': 80
  })

</script>

  </body>

</html>