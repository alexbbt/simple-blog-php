<?php
  $pageTitle = 'Blog Admin Page';
  
  include './database.php';
    
  $db = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password);

  $config = $db->query('SELECT * FROM config')->fetch(PDO::FETCH_ASSOC);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
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
      <div class="col-xs-12">
        <legend>All Blog Enties</legend>
        <table class="table table-striped table-condensed">
          <thead>
            <th>Published</th>
            <th>Title</th>
            <th>Author</th>
            <th>Author Website</th>
            <th>Created</th>
            <th>Updated</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
          </thead>
<?php
    // Loop over each blog
    $blogs = $db->query('SELECT * FROM blogs')->fetchAll(PDO::FETCH_ASSOC);
    foreach($blogs as $blog) {
?>
            <tr>
              <td><input onclick="publish('<?=$blog[url]?>', <?=($blog[published]) ? '0' : '1'?>)" type="checkbox" <?=($blog[published]) ? 'checked' : ''?>></td>
              <td><?=$blog[title]?></td>
              <td><?=$blog[author]?></td>
              <td><?=$blog[authorUrl]?></td>
              <td><?=date('F  d, Y @ H:i:s', strtotime($blog[timestamp]))?></td>
              <td><?=date('F  d, Y @ H:i:s', strtotime($blog[updated]))?></td>
              <td><p data-placement="top" data-toggle="tooltip" title="View"><a href="<?=$config[blogUrl]?>/<?=$blog[url]?>" class="btn btn-success btn-xs" data-title="View" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span></a></p></td>
              <td><p data-placement="top" data-toggle="tooltip" title="Edit"><a href="./edit/<?=$blog[url]?>" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></button></p></td>
              <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button onclick="deleteBlog('<?=$blog[url]?>')" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span></button></p></td>    
            </tr>
<?php
    }
?>
        </table>
        <a href="<?=$config[blogUrl]?>" type="button" class="btn btn-default">Home</a>
        <a href="<?=$config[blogUrl]?>/admin/site" type="button" class="btn btn-primary">Site Config</a>
        <a href="<?=$config[blogUrl]?>/admin/new" type="button" class="btn btn-success">New</a>
      </div>
    </div>
  </div>

  <script>
    var deleteBlog = function(blog, then) {
      then = then || function() {
        window.location.replace('./');
      }
      $.post( "<?=$config[blogUrl]?>/admin/save.php?delete=true", 
        { 
          oldTitle: blog
        }, 
        function( data ) {
          then();
      });
    }
    var publish = function(blog, boolean) {
      $.post( "<?=$config[blogUrl]?>/admin/save.php?publish=true", 
        { 
          oldTitle: blog,
          boolean: boolean
        }, 
        function( data ) {
          window.location.replace('./');
      });
    }
  </script>

</body>
</html>
