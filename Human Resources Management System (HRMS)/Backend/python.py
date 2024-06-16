from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///hrms.db"
db = SQLAlchemy(app)

class Employee(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    first_name = db.Column(db.String(255), nullable=False)
    last_name = db.Column(db.String(255), nullable=False)
    email = db.Column(db.String(255), nullable=False, unique=True)
    password = db.Column(db.String(255), nullable=False)
    role_id = db.Column(db.Integer, db.ForeignKey("roles.id"))
    department_id = db.Column(db.Integer, db.ForeignKey("departments.id"))

class Department(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False)

class Role(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False)

class PerformanceReview(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    employee_id = db.Column(db.Integer, db.ForeignKey("employees.id"))
    review_date = db.Column(db.Date, nullable=False)
    rating = db.Column(db.Integer, nullable=False)
    comments = db.Column(db.Text)

@app.route("/employees", methods=["GET"])
def get_employees():
    employees = Employee.query.all()
    return jsonify([{"id": e.id, "first_name": e.first_name, "last_name": e.last_name} for e in employees])

@app.route("/employees/<int:employee_id>", methods=["GET"])
def get_employee(employee_id):
    employee = Employee.query.get(employee_id)
    if employee is None:
        return jsonify({"error": "Employee not found"}), 404
    return jsonify({"id": employee.id, "first_name": employee.first_name, "last_name": employee.last_name})

@app.route("/employees", methods=["POST"])
def create_employee():
    data = request.get_json()
    employee = Employee(first_name=data["first_name"], last_name=data["last_name"], email=data["email"], password=data["password"], role_id=data["role_id"], department_id=data["department_id"])
    db.session.add(employee)
    db.session.commit()
    return jsonify({"id": employee.id}), 201

@app.route("/employees/<int:employee_id>", methods=["PUT"])
def update_employee(employee_id):
    employee = Employee.query.get(employee_id)
    if employee is None:
        return jsonify({"error": "Employee not found"}), 404
    data = request.get_json()
    employee.first_name = data["first_name"]
    employee.last_name = data["last_name"]
    employee.email = data["email"]
    employee.password = data["password"]
    employee.role_id = data["role_id"]
    employee.department_id = data["department_id"]
    db.session.commit()
    return jsonify({"id": employee.id})

@app.route("/employees/<int:employee_id>", methods=["DELETE"])
def delete_employee(employee_id):
    employee = Employee.query.get(employee_id)
    if employee is None:
        return jsonify({"error": "Employee not found"}), 404
    db.session.delete(employee)
    db.session.commit()
    return jsonify({"message": "Employee deleted"})

if __name__ == "__main__":
    app.run(debug=True)