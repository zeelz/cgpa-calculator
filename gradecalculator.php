<?php 
function credit_unit($course){
	$two_units = ["csc180","csc182","csc183","csc281","csc282","csc283","csc284","csc285","csc286","csc287","csc288","csc382","csc482","csc483","csc491","csc492","csc493","csc495","csc496","csc497","ges101","ges102","ges103","ges300","ges400","mth224", "phy102"];

	$three_units = ["chm130","csc280","csc394","csc395","csc480","csc481","csc486","csc494","csc498","csc396","csc397","fsb101","ges100","mth124","mth114","mth120","mth210","mth250","mth270","phy101","phy351","phy112","sta160","sta260","sta262","sta370"];
// phy102 > 2 cu
	$cu;
	if ($course == "fsc2c1" || $course == "phy103") {	
		$cu = 1;
	} else if (in_array($course, $two_units)) {		
		$cu = 2;
	} else if (in_array($course, $three_units)) {		
		$cu = 3;
	} else if ($course == "mth110") {		
		$cu = 4;
	} else if ($course == "csc470") {		
		$cu = 6;
	} else if ($course == "csc300") {		
		$cu = 9;
	}
	return $cu;
}

function quality_point($course, $grade){


	$gp;
	switch(true){
		case ($grade >= 70):
			$gp = 5; 
			break; 
		case ($grade >= 60):
			$gp = 4;
			break; 
		case ($grade >= 50):
			$gp = 3;
			break; 
		case ($grade >= 45):
			$gp = 2;
			break; 
		case ($grade >= 40):
			$gp = 1;
			break;
		default:
			$gp = 0;
			break;
	}
	return credit_unit($course) * $gp;
}

function total_credit_units($courses){
	$tcu = 0;
	foreach ($courses as $key => $value) {
		$course_grade = explode("-", $value);
		$tcu += credit_unit($course_grade[0]);
	}
	return $tcu;
}

$courses = $_POST['courseScoreData'];

$total_qp = 0;
// foreach ($courses as $key => $value) {
// 	$course_grade = explode("-", $value);
// 	$total_qp += quality_point($course_grade[0], (int)$course_grade[1]);
// }
for($i = 0; $i <= count($courses); $i++) {
	$course_grade = explode("-", $courses[$i]);
	$total_qp += quality_point($course_grade[0], (int)$course_grade[1]);
}
$cgpa =  $total_qp / total_credit_units($courses);
echo number_format((float)$cgpa, 2, ".", ""); // Print 2dp

?>