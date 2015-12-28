<?php



// This function scans the files folder recursively, and builds a large array

function scan($dir){

	$files = array();
	

	// Is there actually such a folder/file?

	if(file_exists($dir)){
	
		$scanned = scandir($dir);
		
		//get a directory listing
		$scanned = array_diff (scandir ($dir),
			//folders / files to ignore
			array ('.', '..', '.DS_Store', 'Thumbs.db')
		);
		
		//sort folders first, then by type, then alphabetically
		usort ($scanned, create_function ('$a,$b', '
			return	is_dir ($a)
				? (is_dir ($b) ? strnatcasecmp ($a, $b) : -1)
				: (is_dir ($b) ? 1 : (
					strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION)) == 0
					? strnatcasecmp ($a, $b)
					: strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION))
				))
			;
		'));
	
		foreach($scanned as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}

			if(is_dir($dir . '/' . $f)) {

				// The path is a folder

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
				);
			}
			
			else {

				// It is a file

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"ext" => pathinfo($f, PATHINFO_EXTENSION),
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
			}
		}
	
	}

	return $files;
}


function debug() {
        $trace = debug_backtrace();
        $rootPath = dirname(dirname(__FILE__));
        $file = str_replace($rootPath, '', $trace[0]['file']);
        $line = $trace[0]['line'];
        $var = $trace[0]['args'][0];
        $lineInfo = sprintf('<div><strong>%s</strong> (line <strong>%s</strong>)</div>', $file, $line);
        $debugInfo = sprintf('<pre>%s</pre>', print_r($var, true));
        print_r($lineInfo.$debugInfo);
}


// Output the directory listing as JSON

/*
header('Content-type: application/json');


$results[] = array(
	"name" => "files",
	"type" => "folder",
	"path" => $dir,
	"items" => $response
);
*/