<?php

namespace model;

use http\Params;

class SurveyModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function save($docente, $p1, $p2, $p3, $comentarios) {
        $stmt = $this->conn->prepare(
            "INSERT INTO respuestas (docente, pregunta1, pregunta2, pregunta3, comentarios) 
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param("siiis", $docente, $p1, $p2, $p3, $comentarios);

        if ($stmt->execute()) {
            return [true, "Gracias por enviar tu evaluación."];
        } else {
            return [false, "Error al guardar los datos: " . $stmt->error];
        }
    }

    public function queryByTeacher( $teacher) {
        $sql ="
WITH valores AS (
    SELECT 1 AS valor UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4
)

-- Para cada pregunta
SELECT '1. ¿Explica claramente los temas?' AS pregunta, v.valor, COUNT(r.pregunta1) AS frecuencia
FROM valores v
LEFT JOIN respuestas r ON v.valor = r.pregunta1 AND r.docente = ?
GROUP BY v.valor

UNION ALL

SELECT '2. ¿Fomenta la participación?', v.valor, COUNT(r.pregunta2)
FROM valores v
LEFT JOIN respuestas r ON v.valor = r.pregunta2 AND r.docente = ?
GROUP BY v.valor

UNION ALL

SELECT '3. ¿Es puntual y responsable?', v.valor, COUNT(r.pregunta3)
FROM valores v
LEFT JOIN respuestas r ON v.valor = r.pregunta3 AND r.docente =?
GROUP BY v.valor;
            ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $teacher,$teacher,$teacher);
        // Ejecutar
        $stmt->execute();

        // Obtener resultado
        $result = $stmt->get_result();
        $data=[];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function queryAllTeachers() {
        $sql ="
            SELECT DISTINCT docente 
            FROM evaluacion.respuestas 
            ";
        $stmt = $this->conn->prepare($sql);
        // Ejecutar
        $stmt->execute();
        // Obtener resultado
        $result = $stmt->get_result();
        $data=[];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function delete($id){
    $stmt= $this->conn->prepare("DELETE FROM respuestas WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
    }

    public function update($id, $docente, $p1, $p2, $p3, $comentarios) {
        $stmt = $this->conn->prepare(
            "UPDATE respuestas SET docente = ?, pregunta1 = ?, pregunta2 = ?, pregunta3 = ?, comentarios = ?
             WHERE id = ?"
        );
        $stmt->bind_param("siiisi", $docente, $p1, $p2, $p3, $comentarios, $id);
        return $stmt->execute();
    }

}
