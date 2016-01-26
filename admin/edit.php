<?php
  $method = $_GET['method'];
  
  include './database.php'
    
  $db = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', ''. $username .'', ''. $password .'');


  $config = $db->query('SELECT * FROM config')->fetch(PDO::FETCH_ASSOC);  

  if ($method == 'edit') {
    $pageTitle = 'Edit Blog Entry';
    $blogTitle = $_GET['blog'];
    $blog = $db->query("SELECT * FROM blogs WHERE url = '" . $blogTitle . "'")->fetch(PDO::FETCH_ASSOC);
  } else {
    $pageTitle = 'New Blog Entry';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title><?=$pageTitle?></title>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
  <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.7.1/summernote.css" rel="stylesheet">
  <script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.7.1/summernote.js"></script>
  <!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/to-markdown/1.3.0/to-markdown.js"></script> -->
</head>
<body>
  <div class="container" style="padding-top:50px;">
    <div class="row">
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-0">
        <legend><?=$pageTitle?></legend>
      
        <div class="row">
          <div class="form-group col-xs-12">
            <label for="">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Blog Title" value="<?=$blog['title']?>">
          </div>
          <div class="form-group col-xs-12 col-sm-6">
            <label for="">Author</label>
            <input type="text" class="form-control" id="author" placeholder="John Appleseed" value="<?=$blog['author']?>">
          </div>
          <div class="form-group col-xs-12 col-sm-6">
            <label for="">Author Website</label>
            <input type="text" class="form-control" id="url" placeholder="www.apple.com" value="<?=$blog['authorUrl']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Preview Text</label>
            <textarea id="preview" class="form-control" rows="3"><?=$blog['preview']?></textarea>
          </div>
<?php
    if ($method == 'edit') {
?>
          <div class="form-group col-xs-12">
            <label>Save As? <input type="checkbox" id="saveAs"> <small>(Must have different Title!)</small></label>
          </div>
<?php
    }
?>        
          <div class="form-group col-xs-12 hidden-xs hidden-sm">
<?php
    if ($method == 'edit') {
?>
            <button type="button" class="btn btn-danger delete">Delete</button>
<?php
    }
?> 
            <a type="button" class="btn btn-warning" href="<?=$config[blogUrl]?>/admin/">Cancel</a>
            <button type="button" class="btn btn-success save">Save</button>
          </div>
        </div>
        
      </div>
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-0">
        <div id="summernote">
<?php
    if ($method == 'edit') {
      echo htmlspecialchars_decode($blog[text]);
    }
?>
        </div>
      </div>
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 hidden-md hidden-lg">
<?php
    if ($method == 'edit') {
?>
        <button type="button" class="btn btn-danger delete">Delete</button>
<?php
    }
?> 
        <a type="button" class="btn btn-warning" href="<?=$config[blogUrl]?>/admin">Cancel</a>
        <button type="button" class="btn btn-success save">Save</button>
      </div>
    </div>
  </div>
  
  <script>
    $(document).ready(function() {
      $('#summernote').summernote({
        placeholder: 'write your blog here...',
        height: 300
      });
    });
    $('.save').click(function() {
      // Post to save file
      $.post( "<?=$config[blogUrl]?>/admin/save.php?save=true", 
        { 
          title: $('#title').val(),
          author: $('#author').val(),
          preview: $('#preview').val(),
          url: $('#url').val(),
          saveAs: $('#saveAs').is(':checked'),
          oldTitle: "<?=$blog['title']?>",
          text: $('#summernote').summernote('code')
        }, 
        function( data ) {
          console.log( data );
          window.location.replace('<?=$config[blogUrl]?>/admin');
      });
    });
    $('.delete').click(function() {
      deleteBlog("<?=$blog['title']?>", function() {
        window.location.replace('../');
      });
    });
    var deleteBlog = function(blog, then) {
      then = then || function() {
        window.location.replace('./');
      }
      // Post to save file
      $.post( "<?=$config[blogUrl]?>/admin/save.php?delete=true", 
        { 
          oldTitle: blog,
        }, 
        function( data ) {
          then();
      });
    }
  </script>
</body>
</html>
