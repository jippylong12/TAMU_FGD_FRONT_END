<?php

class ResultsGenerator
{
    function generate()
    {
        $course = strtoupper(trim($_POST['course']));
        $courseNumber = trim($_POST['course_number']);
        $sortBy = $_POST['sort_by'];

        echo "<input type=\"hidden\" id=\"course\" value=\"" . $course . "\"></input>";
        echo "<input type=\"hidden\" id=\"number\" value=\"" . $courseNumber . "\"></input>";
        echo "<input type=\"hidden\" id=\"sort_by\" value=\"" . $sortBy . "\"></input>";

        $fullCourse = $course . '-' . $courseNumber;
        $errorBool = $this->hasErrors($course, $courseNumber);

        if (!$errorBool) {
            $data = $this->readDBData($fullCourse, $sortBy);
            $html_table = $this->buildTable($data['header'], $data['results']);
            echo $html_table;
        }
    }

    private function buildTable($headerArray, $resultsArray) {
        $nr_col = 9;       // Sets the number of columns

        // Create the beginning of HTML table, and of the first row
        $html_table = '<div class="table-responsive-md"><table class="table mt-2 mb-2"><thead class="sticky-top"><tr>';
        // create headers
        foreach ($headerArray as $header) {
            $html_table .= "<th>$header</th>";
        }

        $html_table .= "</tr></thead>";

        foreach ($resultsArray as $teacherInfo) {
            $html_table .= "<tr>";
            array_splice($teacherInfo, 0, 1);

            $nr_elm = count($teacherInfo);        // gets number of elements in $aray

            $honors_class = false;
            // if this is honors
            if (strpos($teacherInfo[0], '*')) {
                $honors_class = true;
                $teacherInfo[0] = str_replace('*', '', $teacherInfo[0]);
            }
            // If the array has elements
            if ($nr_elm > 0) {
                // Traverse the array with FOR
                for ($i = 0; $i < $nr_elm; $i++) {

                    if ($i > 1 && $i < 8) {
                        $teacherInfo[$i] = $this->roundString($teacherInfo[$i]);
                    }

                    // if this is honors
                    if ($honors_class) {
                        if($i == 0){
                            $html_table .= '<td align="center" class="honors text-light"><div class="shimmer">' . $teacherInfo[$i] . '</div></td>';       // adds the value in column in table

                        } else {
                            $html_table .= '<td align="center" class="honors text-light">' . $teacherInfo[$i] . '</td>';       // adds the value in column in table
                        }
                    } else {
                        $html_table .= '<td align="center">' . $teacherInfo[$i] . '</td>';       // adds the value in column in table
                    }

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

            $html_table .= '</tr>';         // ends the last row, and the table

            // Delete possible empty row (<tr></tr>) which cand be created after last column
            $html_table = str_replace('<tr></tr>', '', $html_table);
        }

        $html_table .= '</table></div>';

        return $html_table;
    }

    private function readDBData($fullCourse, $sortBy) {
        // if we have something
        //load the csv for the correct course
        $resultsArray = [];
        $csvFileName = 'MasterDBs/MasterDB.csv';
        $csv = array_map("str_getcsv", file($csvFileName));
        for ($x = 0; $x < sizeof($csv); $x++) {
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
        if (count($resultsArray) == 0) {
            echo '<h1>Could Not Find Course</h1><br>';
            return 0;
        }

        if ($sortBy == 1)
            usort($resultsArray, "sortResultsByGPA");

        # remove course header
        array_splice( $csv[0], 0, 1);


        return [
            'header' => $csv[0],
            'results' => $resultsArray,
        ];
    }

    private function hasErrors($course, $courseNumber ) {
        if (strlen($course) != 4) {
            echo '<h1>Bad Course Code</h1><br>';
            return True;
        }
        if ((floatval($courseNumber) < 100) or (floatval($courseNumber) > 10000) or ($courseNumber == '')) {
            echo '<h1> Bad Course Number </h1><br>';
            return True;
        }
        return False;
    }

    //some of the value of the string are to a crazy decimal place and we need to round it.
    private function roundString($string)
    {

        str_replace('%','',$string);
        $float  = floatval($string);
        $float = round($float,2);
        return strval($float) . '%';
    }
}

// USED TO SORT THE RESULTS BY GPA
function sortResultsByGPA($a,$b)
{
    return strcmp($b[2],$a[2]);
}

