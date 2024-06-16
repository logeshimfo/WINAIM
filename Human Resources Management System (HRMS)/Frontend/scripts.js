// Get all employees
fetch('/employees')
    .then(response => response.json())
    .then(data => {
        const employeesTable = document.getElementById('employees-table');
        data.forEach(employee => {
            const row = employeesTable.insertRow();
            row.insertCell().textContent = employee.first_name + ' ' + employee.last_name;
            row.insertCell().textContent = employee.department_name;
            row.insertCell().textContent = employee.role_name;
            row.insertCell().innerHTML = `
                <button class="edit-btn">Edit</button>&nbsp;&nbsp;<button class="delete-btn">Delete</button>`;
        });
    });

// Add event listener for add employee button
document.getElementById('add-employee-btn').addEventListener('click', () => {
    // Open add employee form
    const addEmployeeForm = document.getElementById('add-employee-form');
    addEmployeeForm.style.display = 'block';
});

// Add event listener for submit button in add employee form
document.getElementById('add-employee-form').addEventListener('submit', (e) => {
    e.preventDefault();
    // Send AJAX request to add employee
    fetch('/employees', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            first_name: document.getElementById('first-name-input').value,
            last_name: document.getElementById('last-name-input').value,
            email: document.getElementById('email-input').value,
            department_id: document.getElementById('department-select').value,
            role_id: document.getElementById('role-select').value
        })
    })
    .then(response => response.json())
    .then(() => {
        alert('Employee added successfully!');
    });
});

// Handle delete employee button clicks
document.querySelectorAll('.delete-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const employeeId = btn.dataset.employeeId;
        fetch(`/employees/${employeeId}`, { method: 'DELETE' })
            .then(() => {
                btn.parentNode.parentNode.remove();
                alert('Employee deleted successfully!');
            })
            .catch(() => alert('Error deleting employee'));
    });
});