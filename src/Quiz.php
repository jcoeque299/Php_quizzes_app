<?php

class Quiz {
    private $questions;
    public function __construct() {
        $this->questions = array();
    }
    public function addQuestion($question, $correctAnswer) {
        $this->questions[] = array('question' => $question, 'correctAnswer' => $correctAnswer);
    }
    public function calculateScore($userAnswers) {
        $score = 0;
        foreach ($this->questions as $index => $q) {
            $questionKey = "q" . ($index + 1);
            if (isset($userAnswers[$questionKey]) && $userAnswers[$questionKey] == $q['correctAnswer']) {
                $score++;
            }
        }
        return $score;
    }
    public function generateFeedback() {
        $feedback = array();
        foreach ($this->questions as $index => $q) {
            $feedback[] = "Pregunta " . ($index + 1) . ": " . $q['question'] . " - Respuesta correcta: " . $q['correctAnswer'];
        }
        return $feedback;
    }
    public function getCorrectAnswer($index) {
        return $this->questions[$index]['correctAnswer'];
    }
}