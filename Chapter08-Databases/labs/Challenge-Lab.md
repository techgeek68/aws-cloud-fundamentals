## Challenge Lab (Optional): Create a complete, production-ready JavaScript full-stack app that replicates the PHP student-registration app from earlier.

- **Backend:** Node.js (Express)
- **Database:** MySQL (connect to AWS RDS)
- **Frontend:** React (single-page app)
- **API:** RESTful
- **Features:** Add, search, edit, and delete students
- **Security:** Basic input validation, CORS enabled


## Hints: 

---

**Directory structure:**
```
/var/www/html/frontend/
├── package.json
├── public/
│   └── index.html
├── src/
│   ├── App.js
│   └── index.js
```
---
---

## 1. **Backend (Node.js/Express)**

Create a folder called `backend/`, and add the following files:

---

### `backend/package.json`
```json name=backend/package.json
{
  "name": "student-db-backend",
  "version": "1.0.0",
  "main": "server.js",
  "scripts": {
    "start": "node server.js"
  },
  "dependencies": {
    "cors": "^2.8.5",
    "express": "^4.18.2",
    "mysql2": "^3.5.2"
  }
}
```

---

### `backend/db.js`
```javascript name=backend/db.js
const mysql = require('mysql2/promise');

const pool = mysql.createPool({
  host: 'lab-db.cr0s8miyua9l.us-east-1.rds.amazonaws.com', // RDS endpoint
  user: 'admin', // RDS username
  password: 'lab-password', // RDS password
  database: 'lab', // Database name
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

module.exports = pool;
```

---

### `backend/server.js`
```javascript name=backend/server.js
const express = require('express');
const cors = require('cors');
const pool = require('./db');

const app = express();
app.use(cors());
app.use(express.json());

// Ensure table exists
(async () => {
  try {
    const sql = `CREATE TABLE IF NOT EXISTS students (
      id INT AUTO_INCREMENT PRIMARY KEY,
      first_name VARCHAR(50) NOT NULL,
      last_name VARCHAR(50) NOT NULL,
      age INT,
      college_name VARCHAR(100),
      program_name VARCHAR(100),
      year INT,
      semester VARCHAR(20)
    )`;
    const conn = await pool.getConnection();
    await conn.query(sql);
    conn.release();
  } catch (err) {
    console.error('Error creating students table:', err);
  }
})();

// Add student
app.post('/api/students', async (req, res) => {
  try {
    const { first_name, last_name, age, college_name, program_name, year, semester } = req.body;
    if (!first_name || !last_name) {
      return res.status(400).json({ error: 'First name and last name are required.' });
    }
    const [result] = await pool.query(
      'INSERT INTO students (first_name, last_name, age, college_name, program_name, year, semester) VALUES (?, ?, ?, ?, ?, ?, ?)',
      [first_name, last_name, age, college_name, program_name, year, semester]
    );
    res.json({ id: result.insertId });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Get all students
app.get('/api/students', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM students ORDER BY id DESC');
    res.json(rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Search student by first and last name
app.get('/api/students/search', async (req, res) => {
  try {
    const { first_name, last_name } = req.query;
    const [rows] = await pool.query(
      'SELECT * FROM students WHERE first_name = ? AND last_name = ? LIMIT 1',
      [first_name, last_name]
    );
    if (rows.length === 0) return res.status(404).json({ error: 'No student found.' });
    res.json(rows[0]);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Edit student
app.put('/api/students/:id', async (req, res) => {
  try {
    const { id } = req.params;
    const { first_name, last_name, age, college_name, program_name, year, semester } = req.body;
    const [result] = await pool.query(
      'UPDATE students SET first_name=?, last_name=?, age=?, college_name=?, program_name=?, year=?, semester=? WHERE id=?',
      [first_name, last_name, age, college_name, program_name, year, semester, id]
    );
    res.json({ success: result.affectedRows > 0 });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Delete student
app.delete('/api/students/:id', async (req, res) => {
  try {
    const { id } = req.params;
    const [result] = await pool.query('DELETE FROM students WHERE id=?', [id]);
    res.json({ success: result.affectedRows > 0 });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

const PORT = process.env.PORT || 4000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
```

---

## 2. **Frontend (React)**

Create a folder called `frontend/`, and add the following files:

---

### `frontend/package.json`
```json name=frontend/package.json
{
  "name": "student-db-frontend",
  "version": "1.0.0",
  "private": true,
  "scripts": {
    "start": "react-scripts start",
    "build": "react-scripts build"
  },
  "dependencies": {
    "react": "^18.3.0",
    "react-dom": "^18.3.0",
    "react-scripts": "^5.0.1",
    "axios": "^1.6.7"
  }
}
```

---

### `frontend/src/App.js`
```javascript name=frontend/src/App.js
import React, { useState, useEffect } from "react";
import axios from "axios";

const API = "http://localhost:4000/api/students";

function App() {
  const [students, setStudents] = useState([]);
  const [form, setForm] = useState({
    first_name: "",
    last_name: "",
    age: "",
    college_name: "",
    program_name: "",
    year: "",
    semester: ""
  });
  const [editId, setEditId] = useState(null);
  const [searchForm, setSearchForm] = useState({
    first_name: "",
    last_name: ""
  });
  const [searchResult, setSearchResult] = useState(null);
  const [msg, setMsg] = useState("");

  useEffect(() => {
    fetchStudents();
  }, []);

  const fetchStudents = async () => {
    const res = await axios.get(API);
    setStudents(res.data);
  };

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };
  const handleSearchChange = (e) => {
    setSearchForm({ ...searchForm, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (editId) {
      await axios.put(`${API}/${editId}`, form);
      setMsg("Student updated successfully!");
      setEditId(null);
    } else {
      await axios.post(API, form);
      setMsg("Student added successfully!");
    }
    setForm({
      first_name: "",
      last_name: "",
      age: "",
      college_name: "",
      program_name: "",
      year: "",
      semester: ""
    });
    fetchStudents();
  };

  const handleEdit = (student) => {
    setEditId(student.id);
    setForm(student);
    setMsg("");
  };

  const handleDelete = async (id) => {
    if (window.confirm("Delete this student?")) {
      await axios.delete(`${API}/${id}`);
      setMsg("Student deleted successfully!");
      fetchStudents();
    }
  };

  const handleSearch = async (e) => {
    e.preventDefault();
    try {
      const res = await axios.get(`${API}/search`, { params: searchForm });
      setSearchResult(res.data);
    } catch (err) {
      setSearchResult(null);
      setMsg("No student found.");
    }
  };

  return (
    <div style={{ fontFamily: "Arial, sans-serif", margin: 40 }}>
      <h1>Student Database Web App</h1>
      {msg && <div style={{ color: "green" }}>{msg}</div>}

      <h2>{editId ? "Edit Student" : "Add New Student"}</h2>
      <form onSubmit={handleSubmit} style={{ marginBottom: 20, padding: 15, border: "1px solid #ccc", width: 350 }}>
        <label>First Name: <input type="text" name="first_name" required value={form.first_name} onChange={handleChange} /></label><br /><br />
        <label>Last Name: <input type="text" name="last_name" required value={form.last_name} onChange={handleChange} /></label><br /><br />
        <label>Age: <input type="number" name="age" required value={form.age} onChange={handleChange} /></label><br /><br />
        <label>College Name: <input type="text" name="college_name" required value={form.college_name} onChange={handleChange} /></label><br /><br />
        <label>Program Name: <input type="text" name="program_name" required value={form.program_name} onChange={handleChange} /></label><br /><br />
        <label>Year: <input type="number" name="year" required value={form.year} onChange={handleChange} /></label><br /><br />
        <label>Semester: <input type="text" name="semester" required value={form.semester} onChange={handleChange} /></label><br /><br />
        <button type="submit">{editId ? "Update Student" : "Add Student"}</button>
        {editId && <button type="button" onClick={() => { setEditId(null); setForm({ first_name: "", last_name: "", age: "", college_name: "", program_name: "", year: "", semester: "" }); }}>Cancel</button>}
      </form>

      <h2>Search Student</h2>
      <form onSubmit={handleSearch} style={{ marginBottom: 20, padding: 15, border: "1px solid #ccc", width: 350 }}>
        <label>First Name: <input type="text" name="first_name" required value={searchForm.first_name} onChange={handleSearchChange} /></label><br /><br />
        <label>Last Name: <input type="text" name="last_name" required value={searchForm.last_name} onChange={handleSearchChange} /></label><br /><br />
        <button type="submit">Search</button>
      </form>
      {searchResult && (
        <div>
          <h3>Student Found:</h3>
          <ul>
            <li>First Name: {searchResult.first_name}</li>
            <li>Last Name: {searchResult.last_name}</li>
            <li>Age: {searchResult.age}</li>
            <li>College Name: {searchResult.college_name}</li>
            <li>Program Name: {searchResult.program_name}</li>
            <li>Year: {searchResult.year}</li>
            <li>Semester: {searchResult.semester}</li>
          </ul>
        </div>
      )}

      <h2>All Students</h2>
      <table style={{ borderCollapse: "collapse", width: "90%" }}>
        <thead>
          <tr>
            <th>ID</th><th>First Name</th><th>Last Name</th><th>Age</th><th>College Name</th>
            <th>Program Name</th><th>Year</th><th>Semester</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {students.map(student =>
            <tr key={student.id}>
              <td>{student.id}</td>
              <td>{student.first_name}</td>
              <td>{student.last_name}</td>
              <td>{student.age}</td>
              <td>{student.college_name}</td>
              <td>{student.program_name}</td>
              <td>{student.year}</td>
              <td>{student.semester}</td>
              <td>
                <button onClick={() => handleEdit(student)}>Edit</button>
                <button style={{ color: "white", background: "#e74c3c", marginLeft: 5 }} onClick={() => handleDelete(student.id)}>Delete</button>
              </td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}

export default App;
```

---

### `frontend/src/index.js`
```javascript name=frontend/src/index.js
import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);
```

---

### `frontend/public/index.html`
```html name=frontend/public/index.html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Database Web App</title>
</head>
<body>
  <div id="root"></div>
</body>
</html>
```

---

## 3. **How to Run**

**Backend:**
1.  Install Node.js and npm (On Amazon Linux 2) run:

`curl -fsSL https://rpm.nodesource.com/setup_18.x | sudo bash -
sudo yum install -y nodejs`

2. Edit `backend/db.js` with your actual RDS credentials.
3. Run:
   ```sh
   cd backend
   npm install
   npm start
   ```

**Frontend:**
1. Run:
   ```sh
   cd frontend
   npm install
   npm start
   ```
>By default, frontend runs on: localhost:3000 and expects backend at: localhost:4000


**Access the App**
Frontend:
   Open `http://<your-ec2-public-ip>:3000` in your browser.
   
Backend API: 
   Runs on port 4000 by default `http://<your-ec2-public-ip>:4000`

**Deploying to Production:**
- Use environment variables for database secrets.
- Serve the React build with Express in production.
- Secure API routes, add authentication if needed.

---
