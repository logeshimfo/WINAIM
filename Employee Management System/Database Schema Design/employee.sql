-- Create the employees table
CREATE TABLE employees (
    employee_id INT PRIMARY KEY,          -- Unique identifier for each employee
    first_name VARCHAR(50),               -- Employee's first name
    last_name VARCHAR(50),                -- Employee's last name
    department_id INT,                    -- Foreign key to the departments table
    hire_date DATE,                       -- Date the employee was hired
    FOREIGN KEY (department_id) REFERENCES departments(department_id)  -- Establishes the relationship with the departments table
);
