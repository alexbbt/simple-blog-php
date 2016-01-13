<?php
    // set your timezone
    date_default_timezone_set('UTC');

    // config files
    $config = parse_ini_file('./assets/config/config.ini');
    $blogs = parse_ini_file('./assets/blogs/blogs.ini');

    // get the chosen blog, could be empty if it is the home page
    $blogTitle = $_GET['blog'];
    
    // if the blog was specified but does not excist, then redirect to home
    if ($blogTitle != '' && !file_exists('./assets/blogs/'.$blogTitle.'.html')) {
        header( 'Location: ./' ) ;
    }

    // sort function by timestamp
    function cmp($a, $b) {
        if ($a[timestamp] == $b[timestamp]) {
                return 0;
        }
        return ($a[timestamp] > $b[timestamp]) ? -1 : 1;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

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
        usort($blogs,"cmp");
?>


        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
<?php
        // Loop over each blog
        foreach ($blogs as $blog) {
?>
                <article class="blog-post">
                    <div class="blog-post-body">
                        <h2><a href="./<?=$blog[url]?>"><?=$blog[title]?></a></h2>
                        <div class="post-meta"><span>by <a href="./<?=$blog[authorUrl]?>"><?=$blog[author]?></a></span>/<span><i class="fa fa-clock-o"></i><?=date('F  d, Y', $blog[timestamp])?></span></div>
                        <p>
<?php
        // Get first paragraph of the current blog
        $text = file_get_contents('./assets/blogs/'. $blog[url] .'.html');
        if ($text != '') {
            $doc = new DOMDocument;
            $doc -> loadHTML($text);
            $xml = simplexml_import_dom($doc);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            echo ($array[body][p][0]);
        }
?>
                        </p>
                        <div class="read-more"><a href="./<?=$blog[url]?>">Continue Reading</a></div>
                    </div>
                </article>
<?php
        }
        if (count($blogs)==0) {
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
        $blog = $blogs[$blogTitle];
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
                                <span><i class="fa fa-clock-o"></i><?=date('F  d, Y', $blog[timestamp])?></span></div>
                            <div class="blog-post-text">
<?php
        // Get blog content and put on page
        echo file_get_contents('./assets/blogs/'.$blogTitle.'.html');

?>
                            </div>
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
                <i class="fa fa-copyright"></i> Copyright &copy; <a href="<?=$config[copyrightUrl]?>"><?=$config[copyrightName]?></a> 2014, <a href="./admin">Admin</a>
            </div>
        </footer>
    </div> <!-- Container -->
</body>

</html>