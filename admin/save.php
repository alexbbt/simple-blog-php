<?php

	$oldTitle = $_POST['oldTitle'];
	$oldTitle = str_replace(' ', '-', strtolower($oldTitle));
	
	$blogsFile = '../assets/blogs/blogs.ini';
	$configFile = '../assets/config/config.ini';

	$blogs = parse_ini_file($blogsFile);
	
	// If save function
	if (!empty($_GET['save'])) {
		// Return if missing param
		if(empty($_POST['title'])  		||
		   empty($_POST['subtitle'])	||
		   empty($_POST['author']) 		||
		   empty($_POST['url'])				||
		   empty($_POST['text']))
		   {
			echo "Something is missing!";
			return false;
	   }
		$title = $_POST['title'];
		$subtitle = $_POST['subtitle'];
		$author = $_POST['author'];
		$authorUrl = $_POST['url'];
		$saveAs = $_POST['saveAs'] == 'true'; // Boolean
		
		$text = $_POST['text'];

		// Convert to url format
		$saveTitle = str_replace(' ', '-', strtolower($title));

		// Current Timestamp
		$timestamp = time();

		// If changing the Blog name
		if (!$saveAs && !empty($_POST['oldTitle']) && strcmp($saveTitle, $oldTitle) != 0) {
			$timestamp = $blogs[$oldTitle]['timestamp'];
			$blogs = delete($blogs, $oldTitle);
		}

		// Write blog to array
		$blogs[$saveTitle] = array(
			"title" => $title,
			"subtitle" => $subtitle,
			"author" => $author,
			"authorUrl" => $authorUrl,
			"timestamp" => $timestamp,
			"url" => $saveTitle
		);
		// Write out Blogs file
		write_ini_file($blogs, $blogsFile, TRUE);

		// Save Blog HTML File
		file_put_contents('../assets/blogs/'.$saveTitle.'.html', $text);

	// If Delete Function
	} else if (!empty($_GET['delete'])) {

		$blogs = delete($blogs, $oldTitle);
		write_ini_file($blogs, $blogsFile, TRUE);

	// If Site Settings Function
	} else if (!empty($_GET['site'])) {
		// Return if missing param
		if(empty($_POST['title'])  				||
		   empty($_POST['tagline'])				||
		   empty($_POST['blogUrl'])				||
		   empty($_POST['twitter']) 			||
		   empty($_POST['facebook']) 			||
		   empty($_POST['github']) 				||
		   empty($_POST['copyrightName'])	||
		   empty($_POST['copyrightUrl']))
		   {
			echo "Something is missing!";
			return false;
	   }
		$title = $_POST['title'];
		$tagline = $_POST['tagline'];
		$blogUrl = $_POST['blogUrl'];
		$twitter = $_POST['twitter'];
		$facebook = $_POST['facebook'];
		$github = $_POST['github'];
		$copyrightName = $_POST['copyrightName'];
		$copyrightUrl = $_POST['copyrightUrl'];

		// Recreate Config Array
		$config = array(
			"title" => $title,
			"tagline" => $tagline,
			"blogUrl" => $blogUrl,
			"twitter" => $twitter,
			"facebook" => $facebook,
			"github" => $github,
			"copyrightName" => $copyrightName,
			"copyrightUrl" => $copyrightUrl
		);

		// Write out config file
		write_ini_file($config, $configFile, FALSE);
	}
	
	// Delete given blog
	function delete($blogs, $blog) {
		print_r($blogs);
		print_r($blog);
		print_r($blogs[$blog]);
		unset($blogs[$blog]);
		print_r($blogs);
		unlink('../assets/blogs/'.$blog.'.html');
		return $blogs;
	}

	// Write out INI File
	function write_ini_file($assoc_arr, $path, $has_sections=FALSE) { 
	    $content = ""; 
	    if ($has_sections) { 
	        foreach ($assoc_arr as $key=>$elem) { 
	            $content .= "[".$key."]\n"; 
	            foreach ($elem as $key2=>$elem2) { 
	                if(is_array($elem2)) 
	                { 
	                    for($i=0;$i<count($elem2);$i++) 
	                    { 
	                        $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
	                    } 
	                } 
	                else if($elem2=="") $content .= $key2." = \n"; 
	                else $content .= " ".$key."[".$key2."] = \"".$elem2."\"\n"; 
	            } 
	        } 
	    } 
	    else { 
	        foreach ($assoc_arr as $key=>$elem) { 
	            if(is_array($elem)) 
	            { 
	                for($i=0;$i<count($elem);$i++) 
	                { 
	                    $content .= $key."[] = \"".$elem[$i]."\"\n"; 
	                } 
	            } 
	            else if($elem=="") $content .= $key." = \n"; 
	            else $content .= $key." = \"".$elem."\"\n"; 
	        } 
	    } 

	    if (!$handle = fopen($path, 'w')) { 
	        return false; 
	    }

	    $success = fwrite($handle, $content);
	    fclose($handle); 

	    return $success; 
	}
?>