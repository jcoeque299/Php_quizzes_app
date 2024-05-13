<?php

class Quiz {
    private $preguntas;
    
    public function __construct() {
        $this->preguntas = array();
    }

    public function anadirPregunta($pregunta, $respuestaCorrecta) {
        $this->preguntas[] = array('pregunta' => $pregunta, 'respuestaCorrecta' => $respuestaCorrecta);
    }

    public function calcularPuntuacion($respuestasUsuario) {
        $score = 0;

        foreach ($this->preguntas as $index => $q) {
            if (isset($respuestasUsuario[$index]) && $respuestasUsuario[$index] == $q['respuestaCorrecta']) {
                $score++;
            }
        }

        return $score;
    }

    public function mostrarErrores() {
        $errores = array();

        foreach ($this->preguntas as $index => $q) {
            $errores[] = "Pregunta " . ($index + 1) . ": " . $q['pregunta'] . " - Respuesta correcta: " . $q['respuestaCorrecta'];
        }

        return $errores;
    }
}