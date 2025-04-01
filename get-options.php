<?php
require_once 'secure.php';

$type = $_GET['type'] ?? '';
$response = [];

switch ($type) {
    case 'teacher':
        $response = (new TeacherMap())->arrTeachers();
        break;
    case 'subject':
        $response = (new SubjectMap())->arrSubjects();
        break;
    case 'classroom':
        $response = (new ClassroomMap())->arrClassrooms();
        break;
    case 'group':
        $response = (new GruppaMap())->arrGruppas();
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
