<?php

// Create a new performance review
$app->post('/performance-reviews', function () {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $this->db->prepare('INSERT INTO performance_reviews SET 
        employee_id = :employee_id, 
        review_date = :review_date, 
        feedback = :feedback, 
        rating = :rating');
    $stmt->execute([
        'employee_id' => $data['employee_id'],
        'review_date' => date_create($data['review_date'])->format('Y-m-d'),
        'feedback' => addslashes($data['feedback']),
        'rating' => floatval($data['rating'])
    ]);
    echo json_encode(['message' => 'Performance review created successfully']);
});