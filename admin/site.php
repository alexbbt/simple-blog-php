<?php
  $pageTitle = 'Site Settings';
  $config = parse_ini_file('../assets/config/config.ini');  
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
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-0">
        <legend><?=$pageTitle?></legend>
      
        <div class="row">
          <div class="form-group col-xs-12">
            <label for="">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Blog Title" value="<?=$config['title']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Tagline</label>
            <input type="text" class="form-control" id="tagline" placeholder="Little bit longer almost a description" value="<?=$config['tagline']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Base Blog URL</label>
            <input type="text" class="form-control" id="blogUrl" placeholder="The Base URL for your blog" value="<?=$config['blogUrl']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Twitter URL</label>
            <input type="text" class="form-control" id="twitter" placeholder="Link to your Twitter account" value="<?=$config['twitter']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Facebook URL</label>
            <input type="text" class="form-control" id="facebook" placeholder="Link to your Facebook account" value="<?=$config['facebook']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Github URL</label>
            <input type="text" class="form-control" id="github" placeholder="Link to your Github account" value="<?=$config['github']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Copyright Name</label>
            <input type="text" class="form-control" id="copyrightName" placeholder="Descriptive name for your site" value="<?=$config['copyrightName']?>">
          </div>
          <div class="form-group col-xs-12">
            <label for="">Copyright URL</label>
            <input type="text" class="form-control" id="copyrightUrl" placeholder="site url" value="<?=$config['copyrightUrl']?>">
          </div>
          <div class="form-group col-xs-12">
            <a type="button" class="btn btn-warning" href="<?=$config[blogUrl]?>/admin">Cancel</a>
            <button type="button" class="btn btn-success save">Save</button>
          </div>
        </div>
      </div>
  </div>
  
  <script>
    $('.save').click(function() {
      // Post to save file
      $.post( "<?=$config[blogUrl]?>/admin/save.php?site=true", 
        { 
          title: $('#title').val(),
          tagline: $('#tagline').val(),
          blogUrl: $('#blogUrl').val(),
          twitter: $('#twitter').val(),
          facebook: $('#facebook').val(),
          github: $('#github').val(),
          copyrightName: $('#copyrightName').val(),
          copyrightUrl: $('#copyrightUrl').val()
        }, 
        function( data ) {
          // redirect to admin page
          window.location.replace('<?=$config[blogUrl]?>/admin');
      });
    });
  </script>
</body>
</html>