<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $preguntas = array("q1", "q2", "q3", "q4", "q5", "q6", "q7", "q8", "q9", "q10");
    $respuestasVacias = array();
    foreach ($preguntas as $pregunta) {
        if (empty($_POST[$pregunta])) {
            $respuestasVacias[] = $pregunta;
        }
    }

    if (!empty($respuestasVacias)) {
        echo "<h1>No se pueden enviar preguntas vacias</h1>";
        echo "<p>Preguntas sin respuesta: " . implode(", ", $respuestasVacias) . "</p>";
    } else {
        echo "<h1>Respuestas enviadas</h1>";
    }
} else {
    header("Location: index.php");
    exit();
}