
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<?php

	// loads all the courses into an array

	function sortResultsByGPA($a,$b)
	{
		return strcmp($b[2],$a[2]);
	}
	function getTextFiles()
	{
		$currentDir = getcwd() . '/TextCoursesList';
		$temp_array = preg_grep('~\.(txt)$~', scandir($currentDir));
		return $temp_array;

	}

	//some of the value of the string are to a crazy decimal place and we need to round it.
	function roundString($string)
	{

		str_replace('%','',$string);
		$float  = floatval($string);
		$float = round($float,2);
		return strval($float) . '%';
	}
	function loadCourseDB()
	{
		$CourseDB = array();
		$listOfFiles = getTextFiles();
		chdir(getcwd() . '/TextCoursesList');
		foreach ($listOfFiles as $file)
		{
			$school = substr($file,0,2);
			$lines = file($file);
			$searches = array("\r", "\n", "\r\n");
			for ($x = 0; $x < sizeof($lines); $x++) {
				$lines[$x] = str_replace($searches, "", $lines[$x]);
			}
			$CourseDB[$school] = $lines;
		}
		return $CourseDB;
	}

	//gets the college and course from the Course DB
	function getInformation($CourseDB,$course)
	{
		$foundCourseBool = False;
		$checkCollege = "";
		$checkCourse = "";
		foreach ($CourseDB as $college) {
			$test1 = strtoupper($course);
			$foundCourseBool = in_array(strtoupper($course), $college);
			if ($foundCourseBool) {
				$checkCollege = array_search($college, $CourseDB);
				$checkCourse = array_search(strtoupper($course), $college);
				break;
			}
		}
		return array($checkCollege,$checkCourse);
	}

	$CourseDB = loadCourseDB();
	$course = $_POST['my_html_input_tag'];
	$courseNumber = $_POST['my_html_input_tag1'];
	$sortBy = $_POST['SortBy'];
	$fullCourse = strtoupper($course) . '-' . $courseNumber;
	$errorBool = false;
	//error checking
	if (strlen($course) != 4){
		echo '<h1>Bad Course Code</h1><br>';
		$errorBool = True;
	}
	if((floatval($courseNumber) < 100) or (floatval($courseNumber) > 1000) or ($courseNumber == ''))
	{
		echo '<h1> Bad Course Number </h1><br>';
		$errorBool = True;
	}
	if(!$errorBool) {
		$returnArray = getInformation($CourseDB, $course);
		$checkCollege = $returnArray[0];
		$checkCourse = $returnArray[1];

		chdir(getcwd() . '/..' . '/MasterDBs');

		$resultsArray = array();

		$endOfCourseBool = False;

		// if we have something
		if ($checkCollege != "") {
			//load the csv for the correct course
			$csvFileName = $checkCollege . 'MasterDB.csv';
			$csv = array_map("str_getcsv", file($csvFileName));
			for ($x = 0; $x < sizeof($csv); $x++) {
				$testing = $csv[$x][0];
				$test = $fullCourse == $csv[$x][0];
				if ($fullCourse == $csv[$x][0]) {
					$x++;
					while (True) {
						$test = ($csv[$x + 1][0] != "") and ($csv[$x + 1][1] != "");
						if ($test)
							break;
						array_push($resultsArray, $csv[$x]);
						$x++;
					}
				}
			}
		}
		if (count($resultsArray) == 0){
			echo '<h1>Could Not Find Course</h1><br>';

			return 0;
		}

		if ($sortBy == 1)
			usort($resultsArray,"sortResultsByGPA");

		$headerArray = $csv[0];
		array_splice($headerArray,0,1);
		$finalHTML = '';
		foreach ($resultsArray as $teacherInfo) {
			array_splice($teacherInfo,0,1);

			$nr_elm = count($teacherInfo);        // gets number of elements in $aray

			// Create the beginning of HTML table, and of the first row
			$html_table = '<table class="center" border="1 cellspacing="0" cellpadding="2""><tr>';
			// create headers
			foreach ($headerArray as $header)
			{
				$html_table .= "<th>$header</th>";
			}
			$html_table .= "</tr><br><tr>";
			$nr_col = 8;       // Sets the number of columns

			// If the array has elements
			if ($nr_elm > 0) {
				// Traverse the array with FOR
				for ($i = 0; $i < $nr_elm; $i++) {

					if($i > 1 && $i < 7)
					{
						$teacherInfo[$i] = roundString($teacherInfo[$i]);
					}

					$html_table .= '<td align="center">' . $teacherInfo[$i] . '</td>';       // adds the value in column in table

					// If the number of columns is completed for a row (rest of division of ($i + 1) to $nr_col is 0)
					// Closes the current row, and begins another row
					$col_to_add = ($i + 1) % $nr_col;
					if ($col_to_add == 0) {
						$html_table .= '</tr><tr>';
					}
				}

				// Adds empty column if the current row is not completed
				if ($col_to_add != 0) $html_table .= '<td colspan="' . ($nr_col - $col_to_add) . '">&nbsp;</td>';
			}

			$html_table .= '</tr></table>';         // ends the last row, and the table

			// Delete possible empty row (<tr></tr>) which cand be created after last column
			$html_table = str_replace('<tr></tr>', '', $html_table);
			$finalHTML .= $html_table;
			//echo $html_table;        // display the HTML table

//			for ($x = 0; $x < sizeof($teacherInfo); $x++) {
//				if ($x == 8)
//				{
//					echo $csv[0][$x] . ': ';
//					echo $teacherInfo[$x];
//					echo '<br>';
//				}
//				elseif ($x > 2) {
//					echo $csv[0][$x] . ': ';
//					echo number_format(round($teacherInfo[$x]), 2) . '%';
//					echo '<br>';
//				} else {
//					if ($x != 0)
//					{
//						echo $csv[0][$x] . ': ';
//						echo $teacherInfo[$x];
//						echo '<br>';
//					}
//				}
//			}
//			echo '<br>';
		}
		echo $finalHTML;
	}

?>
</html>
