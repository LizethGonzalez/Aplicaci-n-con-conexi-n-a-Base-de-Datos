<?php

namespace controllers;

use core\TemplateEngine;
use model\Database;
use model\SurveyModel;

class SurveyController {
    private $conn;

    // Constructor que acepta la conexión como parámetro
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public static function save() {
        $docente = $_POST['docente'] ?? '';
        $p1 = (int) ($_POST['pregunta1'] ?? 0);
        $p2 = (int) ($_POST['pregunta2'] ?? 0);
        $p3 = (int) ($_POST['pregunta3'] ?? 0);
        $comentarios = $_POST['comentarios'] ?? '';
        $conn = Database::getConnection();
        $surveyModel = new SurveyModel($conn);
        [$success, $message] = $surveyModel->save($docente, $p1, $p2, $p3, $comentarios);

        $response = (object)[
            'success' => $success,
            'message' => $message,
            'data' => []
        ];

        TemplateEngine::render("response", ['response' => $response]);
    }

    public static function add() {
        TemplateEngine::render("survey_add");
    }

    public static function graph() {
        $conn = Database::getConnection();
        $surveyModel = new SurveyModel($conn);
        $teachers = $surveyModel->queryAllTeachers();
        TemplateEngine::render("survey_graph", ['teachers' =>$teachers]);
    }
    public static function statistics() {
        //--- Obtener el cuerpo crudo de la solicitud POST
        $rawData = file_get_contents("php://input");

        //--- Decodificar el JSON
        $data = json_decode($rawData, true); //--- true para obtener un array asociativo

        //--- Acceder al parámetro 'teacher'
        $teacher = $data['teacher'] ?? "Ambrosio Cardoso";

        $conn = Database::getConnection();
        $surveyModel = new SurveyModel($conn);
        $data = $surveyModel->queryByTeacher($teacher);

        $response = json_encode([
            'success' => count($data) > 0,
            'message' => count($data) > 0?'Datos recuperados':'No hay datos',
            'data' => $data
        ]);
        header('Content-Type: application/json');
        echo $response;
    }

    public static function delete() {
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $id = $data['id'] ?? null;

        if ($id === null) {
            echo json_encode(['success' => false, 'message' => "ID no especificado"]);
            return;
        }

        $conn = Database::getConnection();
        $surveyModel = new SurveyModel($conn);
        $success = $surveyModel->delete((int)$id);

        $message = $success ? "Evaluación eliminada correctamente." : "Error al eliminar.";

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
    }


    public static function edit() {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            echo "ID no especificado";
            return;
        }

        $conn = Database::getConnection();
        $surveyModel = new SurveyModel($conn);
        $stmt = $conn->prepare("SELECT * FROM respuestas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        TemplateEngine::render("survey_edit", ['data' => $data]);
    }

    public static function update() {
        $id = (int)($_POST['id'] ?? 0);
        $docente = $_POST['docente'] ?? '';
        $p1 = (int) ($_POST['pregunta1'] ?? 0);
        $p2 = (int) ($_POST['pregunta2'] ?? 0);
        $p3 = (int) ($_POST['pregunta3'] ?? 0);
        $comentarios = $_POST['comentarios'] ?? '';

        $conn = Database::getConnection();
        $surveyModel = new SurveyModel($conn);
        $success = $surveyModel->update($id, $docente, $p1, $p2, $p3, $comentarios);

        $message = $success ? "Evaluación actualizada correctamente." : "Error al actualizar.";
        TemplateEngine::render("response", ['response' => (object)[
            'success' => $success,
            'message' => $message
        ]]);
    }

}
