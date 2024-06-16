<?php

// Get all departments
$app->get('/departments', function () {
    $departments = $this->db->query('SELECT * FROM departments')->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($departments);
});

// Get a department by ID
$app->get('/departments/:id', function ($id) {
    $stmt = $this->db->prepare('SELECT * FROM departments WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $department = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($department);
});