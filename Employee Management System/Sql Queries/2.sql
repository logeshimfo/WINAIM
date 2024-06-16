-- Query to calculate total salary expenditure per department
SELECT d.department_id, d.department_name, SUM(s.salary) AS total_salary_expenditure
FROM departments d
JOIN employees e ON d.department_id = e.department_id  -- Join departments with employees
JOIN salaries s ON e.employee_id = s.employee_id  -- Join employees with salaries
WHERE s.to_date = '9999-01-01'  -- Considering '9999-01-01' as the end date for current salaries
GROUP BY d.department_id, d.department_name;  -- Group by department to aggregate salary expenditure
