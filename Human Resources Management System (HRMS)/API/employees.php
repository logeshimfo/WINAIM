<?php

// Get all employees
$app->get('/employees', function () {
    $employees = $this->db->query('SELECT * FROM employees')->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($employees);
});

// Get an employee by ID
$app->get('/employees/:id', function ($id) {
    $stmt = $this->db->prepare('SELECT * FROM employees WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($employee);
});

// Create a new employee
$app->post('/employees', function () {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $this->db->prepare('INSERT INTO employees SET 
        first_name = :first_name, 
        last_name = :last_name, 
        email = :email, 
        password = :password, 
        department_id = :department_id, 
        role_id = :role_id');
    $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'password' => password_hash($data['password'], PASSWORD_BCRYPT),
        'department_id' => $data['department_id'],
        'role_id' => $data['role_id']
    ]);
    echo json_encode(['message' => 'Employee created successfully']);
});

// Update an employee
$app->put('/employees/:id', function ($id) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $this->db->prepare('UPDATE employees SET 
        first_name = :first_name, 
        last_name = :last_name, 
        email = :email, 
        department_id = :department_id, 
        role_id = :role_id 
        WHERE id = :id');
    $stmt->execute([
        'id' => $id,
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'department_id' => $data['department_id'],
        'role_id' => $data['role_id']
    ]);
    echo json_encode(['message' => 'Employee updated successfully']);
});

// Delete an employee
$app->delete('/employees/:id', function ($id) {
    $stmt = $this->db->prepare('DELETE FROM employees WHERE id = :id');
    $stmt->execute(['id' => $id]);
    echo json_encode(['message' => 'Employee deleted successfully']);
});