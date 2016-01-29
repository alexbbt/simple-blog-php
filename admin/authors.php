<?php
  $pageTitle = 'Author List';

  include './database.php';
    
  $db = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password);

  $config = $db->query('SELECT * FROM config')->fetch(PDO::FETCH_ASSOC); 
  $authors = $db->query('SELECT * FROM authors')->fetchAll(PDO::FETCH_ASSOC);  

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
</head>
<body>
  <div class="container" style="padding-top:50px;">
    <div class="row">
      <div class="col-xs-12">
        <legend><?=$pageTitle?></legend>
        <table class="table table-striped table-condensed">
          <thead>
            <th>Author</th>
            <th>Author Website</th>
            <th>Edit</th>
            <th>Delete</th>
          </thead>
<?php
    // Loop over each blog
    $authors = $db->query('SELECT * FROM `authors`')->fetchAll(PDO::FETCH_ASSOC);
    foreach($authors as $author) {
?>
            <tr id="authorID<?=$author[authorID]?>" data-name="<?=$author[authorName]?>" data-url="<?=$author[authorURL]?>">
              <td><?=$author[authorName]?></td>
              <td><?=$author[authorURL]?></td>
              <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button onclick="edit('<?=$author[authorID]?>')" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></button></p></td>
              <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button onclick="deleteAuthor('<?=$author[authorID]?>')" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span></button></p></td>    
            </tr>
<?php
    }
?>
            <tr>
              <td><input type="text" class="form-control" id="authorName" placeholder="Author Name"></td>
              <td><input type="text" class="form-control" id="authorURL" placeholder="Author Website"></td>
              <td></td>
              <td><button type="button" class="btn btn-success add">Add</button></td>    
            </tr>
        </table>
        <a href="<?=$config[blogUrl]?>admin" type="button" class="btn btn-primary">back</a>
      </div>
    </div>
  </div>
  
  <script>
    var editing = false;
    $('.add').click(function() {
      // Post to save file
      $.post( "<?=$config[blogUrl]?>/admin/save.php?author=true", 
        { 
          authorName: $('#authorName').val(),
          authorURL: $('#authorURL').val()
        }, 
        function( data ) {
          // refresh
          window.location.replace('<?=$config[blogUrl]?>admin/authors');
      });
    });
    var edit = function(authorID) {
      if (editing) {window.location.replace('<?=$config[blogUrl]?>admin/authors');};
      editing = true;
      var row = $('#authorID' + authorID);
      var authorName = row.data()['name'];
      var authorURL = row.data()['url'];
      row.html('');
      row.append($('<td>').html($('<input type="text" class="form-control" id="editAuthorName" placeholder="Author Name" value="'+authorName+'">')));
      row.append($('<td>').html($('<input type="text" class="form-control" id="editAuthorURL" placeholder="Author Website" value="'+authorURL+'">')));
      row.append($('<td>'));
      row.append($('<td>').html($('<button type="button" class="btn btn-success update">Update</button>').click(function() {
        $.post( "<?=$config[blogUrl]?>/admin/save.php?author=true", 
          { 
            authorID: authorID,
            authorName: $('#editAuthorName').val(),
            authorURL: $('#editAuthorURL').val()
          }, 
          function( data ) {
            // refresh
            window.location.replace('<?=$config[blogUrl]?>admin/authors');
        });
      })));
    }
    var deleteAuthor = function(authorID) {
      // Post to save file
      $.post( "<?=$config[blogUrl]?>/admin/save.php?author=true&deleteAuthor=true", 
        { 
          authorID: authorID
        }, 
        function( data ) {
          // refresh
          window.location.replace('<?=$config[blogUrl]?>admin/authors');
      });
    }
  </script>
</body>
</html>