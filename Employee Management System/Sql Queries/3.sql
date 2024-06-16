-- Query to find the top 5 highest-paid employees and their department names
SELECT e.employee_id, e.first_name, e.last_name, d.department_name, s.salary
FROM employees e
JOIN departments d ON e.department_id = d.department_id  -- Join employees with departments
JOIN (SELECT employee_id, MAX(salary) AS salary  -- Subquery to find the highest current salary for each employee
      FROM salaries
      WHERE to_date = '9999-01-01'  -- Considering '9999-01-01' as the end date for current salaries
      GROUP BY employee_id) s ON e.employee_id = s.employee_id  -- Join subquery with employees
ORDER BY s.salary DESC  -- Order by salary in descending order
LIMIT 5;  -- Limit to top 5 results
