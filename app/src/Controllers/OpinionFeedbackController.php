<?php

namespace App\Controllers;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;
require_once __DIR__ . '/../Helpers/session_helper.php';

class OpinionFeedbackController extends AbstractController {
    public function process(Request $request): Response {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost($request);
        }

        return $this->render('opinion-feedback', [
            'title' => 'Opinion Feedback',
        ]);
    }

    private function handlePost(Request $request) {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        $db = new \PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
        $stmt = $db->prepare("INSERT INTO feedback (rating, comment) VALUES (:rating, :comment)");
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();

        header('Location: /opinion-feedback?success=1');
        exit();
    }
}