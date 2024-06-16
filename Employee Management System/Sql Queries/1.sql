-- Query to find employees hired in the last year
SELECT employee_id, first_name, last_name, hire_date
FROM employees
WHERE hire_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR);  -- Subtracts one year from the current date
