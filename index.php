<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ASIN Scraper</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    </head>
    <body>
	<form method="get">
	    <label>ASIN: <input name="asin"></label>
	</form>
	<?php
	    $asin = filter_input(INPUT_GET, 'asin');
	    if(!empty($asin)) {
		echo "<hr>";

		$baseURL = 'http://www.amazon.com/gp/product/';
		$html = file_get_contents($baseURL . $asin);
		$isMatched = preg_match('!"priceblock_ourprice".*\$(.*)<!', $html, $match);
		$price = 0;
		if($isMatched && isset($match[1])) {
		    $price = $match[1];
		}

		$isMatched = preg_match_all('!"hiRes":"(http://ecx\.images-amazon\.com/images/I/[^"]+\.jpg)"!', $html, $matches);
		if($isMatched && isset($matches[1])) {
			foreach($matches[1] as $img) {
				echo "<img src='{$img}' width='300'><br/>\n";
		   }
		}

echo "<pre>";
print_r($matches);
echo "</pre>";
	    }
	    echo "<h1>{$price}</h1>";


	?>
    </body>
</html>
