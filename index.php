<?php
	define('DEFAULT_COLS', 5);
	define('DEFAULT_ROWS', 5);
	
	if(get_magic_quotes_gpc()) {
		array_walk_recursive($_POST, create_function('&$val', '$val = stripslashes($val);'));
	}
	
	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$rules = isset($_POST['rules']) ? $_POST['rules'] : '';
	$rulesAreHtml = (isset($_POST['rules-are-html']) && $_POST['rules-are-html'] != '') ? true : false;
	$cols = isset($_POST['cols']) ? intval($_POST['cols']) : DEFAULT_COLS;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : DEFAULT_ROWS;
	$tunes = isset($_POST['tunes']) ? explode(',', $_POST['tunes']) : array();
	
	$tuneCount = count($tunes);
	
	$sanitisedTunes = array();
	
	for($i = 0; $i < $tuneCount; ++$i) {
	
		$tune = trim($tunes[$i]);
		
		if($tune) {
			$sanitisedTunes[] = $tune;
		}
	}
	
	$tunes = $sanitisedTunes;
	$tuneCount = count($sanitisedTunes);
	
	sort($tunes);
	
	$edit = isset($_POST['edit']);
	$submitted = $edit ? false : isset($_POST['submitted']);
	$valid = ($tuneCount >= $cols * $rows);
?>
<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo strtoupper($_SERVER['SERVER_NAME']{0}); ?>usical Bingo Generator</title>
	<meta name="description" content="A musical bingo generator">
	<meta name="author" content="Alan Shaw">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<link rel="stylesheet" href="css/style.css?v=2">
	<script src="js/libs/modernizr-1.7.min.js"></script>
</head>
<body>
<?php
	if(!$submitted || $submitted && !$valid) {
	
		if($submitted && !$valid) {
			echo '<p>Not enough tunes! Need at least ' . ($cols * $rows) . '! You only entered ' . $tuneCount . '.</p>';
		}
?>
	<div id="form-wrap">
<?php
		if(!$edit) {
?>
		<header id="hd-big">
			<h1><?php echo strtoupper($_SERVER['SERVER_NAME']{0}); ?>usical<br/>Bingo<br/>Generator</h1>
		</header>
<?php
		} else {
?>
		<header id="hd-small">
			<img id="vinyl" src="img/vinyl.png" alt="Vinyl" />
			<h1><a href="/"><?php echo strtoupper($_SERVER['SERVER_NAME']{0}); ?>usical Bingo Generator</a></h1>
		</header>
<?php
		}
?>
		<div id="form">
			<form action="" method="post">
				<div>
					<div class="field">
						<label>
							Title:
							<input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required/>
						</label>
					</div>
					<div class="field clearfix">
						<label>
							Rules:
							<textarea name="rules"><?php echo htmlspecialchars($rules); ?></textarea>
						</label>
						<label for="rules-are-html" title="Allow HTML in the box above"><input id="rules-are-html" type="checkbox" name="rules-are-html" value="1"<?php echo $rulesAreHtml ? ' checked' : ''; ?>/> HTML</label>
					</div>
					<div class="field">
						<label>Columns: <input type="number" name="cols" value="<?php echo htmlspecialchars($cols); ?>" required/></label>
						<label>Rows: <input type="number" name="rows" value="<?php echo htmlspecialchars($rows); ?>" required/></label>
					</div>
					<div class="field">
						<label>
							Tunes (comma separated):
							<textarea name="tunes" required><?php echo htmlspecialchars(implode(', ', $tunes)); ?></textarea>
						</label>
					</div>
					<a href="#" class="btn" onclick="if(validate()) $('form').first().submit();return false;">Generate the bingo</a>
					<input type="hidden" name="submitted" value="1"/>
				</div>
			</form>
		</div>
	</div><!--/#form-wrap-->
<?php
	
	} else {
?>
	<header id="hd-small">
			<img id="vinyl" src="img/vinyl.png" alt="Vinyl" />
			<h1><a href="/"><?php echo strtoupper($_SERVER['SERVER_NAME']{0}); ?>usical Bingo Generator</a></h1>
	</header>
	<div id="bingo-wrap" class="clearfix">
		<form action="" method="post">
			<div id="controls">
				<input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>"/>
				<input type="hidden" name="rules" value="<?php echo htmlspecialchars($rules); ?>"/>
				<input type="hidden" name="rules-are-html" value="<?php echo $rulesAreHtml ? '1' : ''; ?>"/>
				<input type="hidden" name="cols" value="<?php echo htmlspecialchars($cols); ?>"/>
				<input type="hidden" name="rows" value="<?php echo htmlspecialchars($rows); ?>"/>
				<input type="hidden" name="tunes" value="<?php echo htmlspecialchars(implode(', ', $tunes)); ?>"/>
				<input type="hidden" name="submitted" value="1"/>
				<a href="#" class="btn" title="Print this grid" onclick="window.print();">Print</a>
				<a href="#" class="btn" title="Generate another bingo grid" onclick="$('form').first().submit();return false;">Another</a>
				<a href="#" class="btn" title="Edit this musical bingo" onclick="editSubmit();return false;">Edit</a>
			</div>
		</form>
<?php
	
		if($title) {
	
?>
		<h2><?php echo $title; ?></h2>
<?php
		}
?>
		<br/>

		<table id="grid" cellpadding="0" cellspacing="0">
<?php

		shuffle($tunes);
		
		$t = 0;
		
		for($r = 0; $r < $rows; ++$r) {
		
			echo '<tr>';
		
			for($c = 0; $c < $cols; ++$c) {
			
				echo '<td>' . htmlspecialchars($tunes[$t]) . '</td>';
				
				++$t;
			}
			
			echo '</tr>';
		}
	
?>
		</table>
		<h3>Rules</h3>
<?php

		if($rulesAreHtml) {
		
			echo $rules;
			
		} else {
		
			echo '<p>' . str_replace("\n", '<br/>', htmlspecialchars($rules)) . '</p>';
		}
?>
	</div><!--/#bingo-wrap-->
<?php

	}
	
?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>
	<!--[if lt IE 7 ]>
	<script src="js/libs/dd_belatedpng.js"></script>
	<script> DD_belatedPNG.fix('img, .png_bg');</script>
	<![endif]-->
</body>
</html>