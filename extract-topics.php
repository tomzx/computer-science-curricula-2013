<?php

$content = file_get_contents('content.txt');
$lines = preg_split('/\r\n|\r|\n/', $content);

$output = '';
$inTopic = false;
foreach ($lines as $lineNumber =>$line) {
	if (stripos($line, 'Topics:') !== false) {
		$inTopic = true;
		// Find [
		for ($i = $lineNumber; $i >= 0; --$i) {
			if (stripos($lines[$i], '[') === 0) {
				$output .= $lines[$i-1].PHP_EOL;
				$output .= $lines[$i].PHP_EOL;
				break;
			}
		}
		continue;
	}

	if ($inTopic) {
		if (stripos($line, 'Learning Outcomes:') !== false) {
			$inTopic = false;
			$output .= PHP_EOL;
			continue;
		}

		$line = preg_replace('/^• /', '- [ ] ', $line);
		$line = preg_replace('/^o /', '    - [ ] ', $line);
		$output .= $line.PHP_EOL;
	}
}

echo $output;
