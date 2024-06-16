-- Create the salaries table
CREATE TABLE salaries (
    employee_id INT,                      -- Foreign key to the employees table
    salary DECIMAL(10, 2),                -- Employee's salary
    from_date DATE,                       -- Start date of the salary
    to_date DATE,                         -- End date of the salary
    PRIMARY KEY (employee_id, from_date), -- Composite primary key
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)  -- Establishes the relationship with the employees table
);
