<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title><?php echo $siteTitle; ?> | <?php echo $subTitle; ?></title>
	
	<link href="<?php echo $path; ?>assets/css/style.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/x-icon" href="<?php echo $path; ?>assets/images/favicon.png">
	
</head>

<body>

	<div id="outline">
		
        <div id="title">

			<h1><?php echo $siteTitle ?></h1>

			<form id="search" name="search" method="GET" action="<?php echo $path; ?>pages/search/search_result.php">
				<label>Search:</label>
				<input type="search" id="txt_search" name="txt_search" placeholder="Tree ID e.g. '00305'" />
				<button type="submit">Search</button>
			</form>			

		</div>