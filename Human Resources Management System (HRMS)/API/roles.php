<?php

// Get all roles
$app->get('/roles', function () {
    $roles = $this->db->query('SELECT * FROM roles')->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($roles);
});

// Get a role by ID
$app->get('/roles/:id', function ($id) {
    $stmt = $this->db->prepare('SELECT * FROM roles WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($role);
});