<?php
	print_r($_POST);

	$oldTitle = $_POST['oldTitle'];
	$oldTitle = special_repace($oldTitle);

  include './database.php';
    
  $db = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password);
		
	// If save function
	if (!empty($_GET['save'])) {
		// Return if missing param
		if(empty($_POST['title'])  		||
		   empty($_POST['author']) 		||
		   empty($_POST['url'])			||
		   empty($_POST['preview'])		||
		   empty($_POST['text']))
		   {
			echo "Something is missing!";
			return false;
	   }
		$title = html_special_repace($_POST['title']);
		$author = html_special_repace($_POST['author']);
		$authorUrl = html_special_repace($_POST['url']);
		$preview = html_special_repace($_POST['preview']);
		$saveAs = $_POST['saveAs'] == 'true'; // Boolean
		
		$text = html_special_repace($_POST['text']);

		print_r($preview);

		// Convert to url format
		$saveTitle = special_repace($title);

		// Current Timestamp
		$timestamp = time();

		// If new or changing the Blog name
		if ($oldTitle == '' || $saveAs && !empty($_POST['oldTitle']) && strcmp($saveTitle, $oldTitle) != 0) {
			echo 'new';
			$success = $db->query("INSERT INTO `alexbbt_blog`.`blogs` (`title`, `author`, `authorUrl`, `preview`, `url`, `text`) 
						VALUES ('". $title . "', '". $author ."', '". $authorUrl ."', '". $preview ."', '". $saveTitle ."', '". $text ."')"
			);
		} else {
			echo 'save';
			$success = $db->query("UPDATE `alexbbt_blog`.`blogs` 
						SET `title` = '". $title . "',
							`author` = '". $author ."',
							`authorUrl` = '". $authorUrl ."',
							`preview` = '". $preview ."',
							`url` = '". $saveTitle ."',
							`updated` = CURRENT_TIMESTAMP,
							`text` = '" . $text . "'
						WHERE `blogs`.`url` = '". $oldTitle ."'"
			);
		}		
		print_r(($success) ? 'Success' : 'Failure');
		if (!$success) {
			print_r($db->errorInfo());
		}

	// If Delete Function
	} else if (!empty($_GET['delete'])) {
		$db->query("DELETE FROM `alexbbt_blog`.`blogs` 
					WHERE `url` = '". $oldTitle ."'"
				);

	// If Site Settings Function
	} else if (!empty($_GET['publish'])) {
		// Return if missing param
		if(empty($_POST['oldTitle'])) {
			echo "Something is missing!";
			return false;
	   }
		$boolean = $_POST['boolean'];
		$success = $db->query("UPDATE `alexbbt_blog`.`blogs` 
					SET `published` = '". $boolean . "'
					WHERE `url` = '". $oldTitle ."'"
				);
		print_r(($success) ? 'Success' : 'Failure');
		if (!$success) {
			print_r($db->errorInfo());
		}

	// If Site Settings Function
	} else if (!empty($_GET['site'])) {
		// Return if missing param
		if(empty($_POST['title'])  				||
		   empty($_POST['tagline'])				||
		   empty($_POST['blogUrl'])				||
		   empty($_POST['twitter']) 			||
		   empty($_POST['facebook']) 			||
		   empty($_POST['github']) 				||
		   empty($_POST['copyrightName'])		||
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

		$sql = "UPDATE `alexbbt_blog`.`config` 
					SET `title` = '". $title ."',
						`tagline` = '". $tagline ."',
						`blogUrl` = '". $blogUrl ."',
						`twitter` = '". $twitter ."',
						`facebook` = '". $facebook ."',
						`github` = '". $github ."',
						`copyrightName` = '". $copyrightName ."',
						`copyrightUrl` = '". $copyrightUrl ."'
					WHERE `config`.`id` = 1";

		$success = $db->query($sql);
		print_r(($success) ? 'Success' : 'Failure');

	}

	// Special Character Replacing
	function special_repace($text) {
		return preg_replace('/[\[\]\^\$\.\|\?\*\+\(\)\\~`\!@#%&_+={}\'\"<>:;,\ ]{1,}/', '', str_replace(' ', '-', strtolower($text)));
	}
	// html and special Character Replacing
	function html_special_repace($text) {
		return htmlspecialchars(str_replace('', '', str_replace("'", "''", $text)));
	}
?>