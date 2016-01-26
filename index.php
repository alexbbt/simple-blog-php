<?php
    // get the chosen blog, could be empty if it is the home page
    $blogTitle = $_GET['blog'];

    include './admin/database.php';
    
    $db = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password);

    $config = $db->query('SELECT * FROM config')->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="./assets/images/light-bulb.png">

    <title><?=$config[title]?></title>

    <!-- Bootstrap Core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./assets/css/theme.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container">
        <header>
            <a href="<?=$config[blogUrl]?>">
                <div class="blog-title">
                    <h1><?=$config[title]?></h1>
                    <span class="subheading"><?=$config[tagline]?></span>
                </div>
            </a>
        </header>

<?php
    // True if home page
    if ($blogTitle == '') {
?>


        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
<?php
        // Loop over each blog
        $blogs = $db->query('SELECT * FROM blogs WHERE `published` = 1')->fetchAll(PDO::FETCH_ASSOC);
        foreach($blogs as $blog) {
?>
                <article class="blog-post">
                    <div class="blog-post-body">
                        <h2><a href="./<?=$blog[url]?>"><?=$blog[title]?></a></h2>
                        <div class="post-meta"><span>by <a href="<?=$blog[authorUrl]?>"><?=$blog[author]?></a></span>/<span><i class="fa fa-clock-o"></i><?=date('F  d, Y', strtotime($blog[timestamp]))?></span></div>
                        <p><?=htmlspecialchars_decode($blog[preview])?></p>
                        <div class="read-more"><a href="./<?=$blog[url]?>">Continue Reading</a></div>
                    </div>
                </article>
<?php
        }
        if (count($blogs) == 0) {
?>
                <article class="blog-post">
                    <div class="blog-post-body">
                        <p>There are no blog enteries at this time</p>
                    </div>
                </article>
<?php
        }
?>
            </div>
        </div>
<?php

    // If blog is specified
    } else {
        // Get blog data from array
        $blog = $db->query("SELECT * FROM blogs WHERE url = '" . $blogTitle . "'")->fetch(PDO::FETCH_ASSOC);
?>
    
    <!-- Post Content -->
        <article>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <article class="blog-post">
                        <div class="blog-post-body">
                            <h2><?=$blog[title]?></h2>
                            <div class="post-meta">
                                <span>by <a href="<?=$blog[authorUrl]?>"><?=$blog[author]?></a></span>
                                /
                                <span><i class="fa fa-clock-o"></i><?=date('F  d, Y', strtotime($blog[timestamp]))?></span></div>
                            <div class="blog-post-text"><?=htmlspecialchars_decode($blog[text])?></div>
                        </div>
                    </article>
                </div>
            </div>
        </article>

        <!-- Home button -->
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="pager">
                    <li class="previous">
                        <a href="<?=$config[blogUrl]?>"><span aria-hidden="true">&larr;</span> Back to home</a>
                    </li>
                </ul>
            </div>
        </div>
<?php
    }
?>

        <!-- Footer -->
        <footer class="footer">

            <div class="footer-socials">
                <a href="<?=$config[facebook]?>"><i class="fa fa-facebook"></i></a>
                <a href="<?=$config[twitter]?>"><i class="fa fa-twitter"></i></a>
                <a href="<?=$config[github]?>"><i class="fa fa-github"></i></a>
            </div>

            <div class="footer-bottom">
                <i class="fa fa-copyright"></i> Copyright &copy; <a href="<?=$config[copyrightUrl]?>"><?=$config[copyrightName]?></a> 2016, <a href="./admin">Admin</a>
            </div>
        </footer>
    </div> <!-- Container -->
</body>

</html>