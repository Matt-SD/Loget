<!DOCTYPE html>
<html>
<head>
 <title><?php echo $config['title']; ?></title>
 <meta charset="UTF-8">
 <style type="text/css">
  * {margin:0;padding:0;}
  img {border:0;}
  
  body {
   color: #333;
   font: 65% Verdana,sans-serif;
   margin: 10px;
   width: 600px;
  }
  a { color: #00F; }
  a:hover { color: #66F; }
  
  .post {
   margin: 15px 0;
   padding: 5px;
  }
  .post:nth-child(even) {
   background: #F0F0F0;
   border-radius: 5px;
  }
  p.info { color: #888; }
  .entry {
   padding: 5px;
  }
 </style>
</head>
<body>
<div id="header">
 <h1><?php echo $config['title']; ?></h1>
</div>
<div id="content">
<?php foreach($posts as $post): ?>
 <div class="post" id="post-<?php echo $post['id']; ?>">
  <h3><a href="./?view=<?php echo $post['slug']; ?>&id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h3>
  <p class="info">Posted <?php echo date($config['dateformat'],$post['timestamp']); ?></p>
  <div class="entry">
   <?php echo $post['content']; ?>
  </div>
 </div>
<?php endforeach; ?>
</div>
<div id="footer">
 <p>Copyright &copy; <?php echo date("Y"); ?> by <?php echo $config['title']; ?> | Powered by <a href="http://github.com/Matt-SD/Loget" title="Loget on GitHub">Loget</a></p>
</div>
</body>
</html>
