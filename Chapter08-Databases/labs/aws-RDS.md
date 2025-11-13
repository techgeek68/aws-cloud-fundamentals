# Lab: Build Your DB Server and Interact With Your DB Using an App

Amazon RDS is an Amazon Web Services (AWS) fully managed service that makes it easier to set up, operate, and scale a relational database in the cloud. It automates administrative tasks, such as provisioning, patching, backups, recovery, and failure detection, freeing teams up to focus more on innovating applications.

**Features and Advantages**

  - Managed Service: AWS is responsible for core database management tasks, which reduces operational overhead and lets developers and DBAs focus on application development.
    
  - Multiple Database Engines: Supports several popular and industry-standard engines, including:
    - Amazon Aurora (MySQL- and PostgreSQL-compatible)
    - PostgreSQL
    - MySQL
    - MariaDB
    - Oracle
    - Microsoft SQL Server
    - Db2

  - Scalability: Increase or decrease compute, memory, and storage resources with little to no downtime. Some database engines support storage auto-scaling to dynamically adjust capacity.
    
  - High availability and durability: Multi-AZ deployments ensure a highly available environment because of the synchronous replication between Availability Zones, together with automatic failover for minimally interrupted events.
    
  - Automated Backups and Recovery: RDS performs automatic backups and transaction logging, allowing for point-in-time recovery within a retention period of up to 35 days. Manual snapshots can also be created for long-term retention.
    
  - Security: Offers network isolation via Amazon VPC, encryption at rest with AWS KMS, and encryption in transit using SSL. Integration with AWS Identity and Access Management (IAM) enables fine-grained access control.

  - Performance: Offers SSD-backed storage (General Purpose and Provisioned IOPS) and features like Optimized Reads and Optimized Writes to deliver high and consistent performance across workloads.

---


**Objectives:**
- Set up a secure AWS VPC and networking for web and database servers.
- Deploy an Amazon RDS MySQL Multi-AZ instance and connect it to an EC2 web server.
- Build and test a simple web app that performs CRUD operations on the RDS database.
- Learn best practices for troubleshooting and cleaning up AWS resources.
  

---

**Architectural Diagram:**

Here’s an ASCII architectural diagram of the AWS RDS lab, styled like your example.

```
+====================================================================================================+
|                                      AWS Cloud — Region: us-east-1                                 |
|                                                                                                    |
|  +----------------------------------------------------------------------------------------------+  |
|  |                                VPC: Lab VPC (CIDR 10.0.0.0/16)                               |  |
|  |                                                                                              |  |
|  |   Internet                                                                                   |  |
|  |      ^                                                                                       |  |
|  |      |  0.0.0.0/0                                                                            |  |
|  |  +---+-----------------+                                                                     |  |
|  |  | Internet Gateway    |  (Lab-igw)                                                          |  |
|  |  +---------------------+                                                                     |  |
|  |                                                                                              |  |
|  |  +-----------------------------------------+   +-------------------------------------------+ |  |
|  |  | Availability Zone: us-east-1a           |   | Availability Zone: us-east-1b             | |  |
|  |  |                                         |   |                                           | |  |
|  |  |  +-----------------------------------+  |   |  +-------------------------------------+  | |  |
|  |  |  | Public-subnet-01 (10.0.0.0/24)    |  |   |  | DB-subnet-02 (10.0.3.0/24) Private  |  | |  |
|  |  |  |  (Associated: Lab-public-rt)      |  |   |  | (no IGW route)                      |  | |  |
|  |  |  |                                   |  |   |  |                                     |  | |  |
|  |  |  |   +---------------------------+   |  |   |  |   +-----------------------------+   |  | |  |
|  |  |  |   | EC2: DBAppServer          |   |  |   |  |   | RDS MySQL: Standby          |   |  | |  |
|  |  |  |   | - Amazon Linux 2          |   |  |   |  |   | - Multi-AZ replica          |   |  | |  |
|  |  |  |   | - t2.micro                |   |  |   |  |   | - Public access: NO         |   |  | |  |
|  |  |  |   | - Public IP: Enabled      |   |  |   |  |   +-----------------------------+   |  | |  |
|  |  |  |   +-----------+---------------+   |  |   |  |        ^  DB SG                     |  | |  |
|  |  |  |         | Web SG                  |  |   |  +--------|----------------------------+  | |  |
|  |  |  +---------|-------------------------+  |   |           v                               | |  |
|  |  |            v                            |   |   Inbound: 3306 from Web SG               | |  |
|  |  |   Inbound: 80 (HTTP), 22 (SSH) from 0.0.0.0/0                                           | |  |
|  |  |   Outbound: All                                                                         | |  |
|  |  |                                                                                         | |  |
|  |  |  +-----------------------------------+                                                  | |  |
|  |  |  | DB-subnet-01 (10.0.1.0/24) Private|                                                  | |  |
|  |  |  | (no IGW route)                    |                                                  | |  |
|  |  |  |                                   |                                                  | |  |
|  |  |  |   +---------------------------+   |                                                  | |  |
|  |  |  |   | RDS MySQL: Primary        |   |                                                  | |  |
|  |  |  |   | - Multi-AZ                |   |                                                  | |  |
|  |  |  |   | - Public access: NO       |   |                                                  | |  |
|  |  |  |   +-----------+---------------+   |                                                  | |  |
|  |  |  |         | DB SG                   |                                                  | |  |
|  |  |  +---------|-------------------------+                                                  | |  |
|  |  |            v                                                             Synchronous    | |  |
|  |  |   Inbound: 3306 from Web SG                                              Replication    | |  |
|  |  |   Outbound: All                                                        <=============>  | |  |
|  |  |                                                                                         | |  |
|  |  +-----------------------------------------------------------------------------------------+ |  |
|  |                                                                                              |  |
|  |  Route Tables:                                                                               |  |
|  |   - Lab-public-rt: 0.0.0.0/0 -> Internet Gateway; associated to Public-subnet-01             |  |
|  |   - Default/Private RT: no route to IGW; associated to DB-subnet-01 and DB-subnet-02         |  |
|  +----------------------------------------------------------------------------------------------+  |
|                                                                                                    |
+====================================================================================================+

Traffic flow (simplified):
- Internet ⇄ IGW ⇄ EC2 (Public-subnet-01) for HTTP/SSH
- EC2 → RDS Primary on TCP 3306 (private VPC path)
- RDS Primary ⇄ RDS Standby: synchronous replication across AZs
- RDS is not publicly accessible (no public endpoint)

```

---


**Create a VPC**
   1. In the AWS Console, go to the **VPC** service.
   2. Click **Your VPCs** in the left navigation pane, then **Create VPC**.
   3. Select **VPC only**.
   4. Configure:
      - Name tag: `DB VPC`
      - IPv4 CIDR block: `10.0.0.0/16`
      - IPv6 CIDR block: No IPv6 CIDR (leave unchecked/None)
      - Tenancy: Default
   5. Click **Create VPC**.


**Create Subnets**
  - At least three subnets: one public, two private for DB
     - Select **DB VPC**
     - Go to **Subnets** in the VPC console.
     - Click **Create subnet**.
     - Configure and create subnets as follows:

   **a) Public-subnet-01 (for Web/App Server)**
     - VPC: **DB VPC**
     - Subnet name: `DB Public-subnet-01`
     - Availability Zone: `us-east-1a`
     - IPv4 subnet CIDR block: `10.0.0.0/24`

   **b) DB-subnet-01 (Private for RDS)**
     - VPC: **DB VPC**
     - Subnet name: `DB Private-subnet-01`
     - Availability Zone: `us-east-1a`
     - IPv4 subnet CIDR block: `10.0.1.0/24`

   **c) DB-subnet-02 (Private for RDS)**
       - VPC: **DB VPC**
       - Subnet name: `DB Private-subnet-02`
       - Availability Zone: `us-east-1b`
       - IPv4 CIDR block: `10.0.3.0/24`


**Create an Internet Gateway and Attach to VPC**

   1. Go to **Internet gateways** in the VPC console.
   2. Create Internet Gateway.
      - Name tag: `DB Lab-igw`
   3. Action > Attach to VPC > Available VPCs > DB VPC


**Configure Route Tables**

a) **Public Route Table (DB Public-subnet-01)**
   1. Go to **Route tables** in the VPC console.
   2. Create a new route table:
      - Name tag: `DB Lab-public-rt`
      - VPC: `DB VPC`
   3. Select the new route table, go to **Routes** > **Edit routes**.
      - Add route:
        - Destination: `0.0.0.0/0`
        - Target: Internet Gateway (`igw- DB Lab-igw`)
   4. Go to Subnet associations > Explicit subnet associations > Edit subnet associations.
      - Select `DB Public-subnet-01`
      - Click Save associations.

b) **Private Route Table (Optional, for DB subnets)**
   - The default route table (created with your VPC) can be used for private subnets. No route to Internet Gateway is needed for DB subnets.


5. **Create Security Groups**

a) **DB Web Security Group**
- In the left side pane, Security > Security Groups
- Create security group
    - Name: `DB Web Security Group`
    - Description: Allow HTTP/SSH from anywhere                    
    - VPC: `DB VPC`
  - Inbound rules > Add rules
    - Inbound Rule: HTTP (80) from `0.0.0.0/0`
    - Inbound Rule: SSH (22) from `0.0.0.0/0` or Only from your IP
    - Outbound: All traffic

b) **DB Security Group**
- In the left side pane, Security > Security Groups
- Create security group
    - Name: `DB Security Group`
    - Description: Permit access from Web Security Group
    - VPC: `DB VPC`
  - Inbound rules
    - Inbound Rule: MySQL/Aurora (3306), Source Type: Custom, Source: `DB Web Security Group` (select by SG ID)
    - Outbound: All traffic


**Create a DB Subnet Group**
  - Search for **Aurora and RDS**
  - Aurora and RDS > Dashboard > Subnet groups > Create DB subnet group
  - Name: `DB-Lab-Subnet-Group`
  - Description: `DB Subnet Group`
  - VPC: `DB VPC`
  - Add subnets:
     - Availability Zones`us-east-1a` `us-east-1b`,
     - Subnets: `DB Private-subnet-01`, `DB Private-subnet-02`
  - Create


**Launch Amazon RDS Multi-AZ DB Instance**
  - Go to Aurora and RDS > Dashboard > Databases > Create database
    - Standard create
    - Engine: **MySQL**
    - Template: **Dev/Test**
  - Availability: **Multi-AZ DB instance deployment (2 instances)**
  - Settings:
    - DB instance identifier: `db-lab`
    - Master username: `admin`
    - Credentials management
      - Self-managed credentials
      - Master password: `lab-password`
  - DB instance class: Burstable classes `db.t3.micro`
  - Storage: General Purpose SSD (gp3), 20 GiB
  - Connectivity:
    - Don't connect to an EC2 compute resource
    - Network type: IPV4
    - VPC: `DB VPC`
    - DB subnet group: `db-lab-subnet-group`
    - Subnet group: `Lab-DB-Subnet-Group`
    - **Public access: No**
    - VPC security group: **DB Security Group**
    - Enhanced Monitoring **Disable**
10. Additional configuration:
    - Initial database name: `lab`
11. Click **Create database**.
12. Wait until status is **Available**.  
    - Copy the **Endpoint** for later.
    - Click on your RDS database instance.
    - Under the Connectivity & security tab, look for Endpoint & port.
    - The endpoint will look like: `lab-db.cr0s8miyua9l.us-east-1.rds.amazonaws.com`


8. **Launch a Web Server EC2 Instance in the Public Subnet**

1. Go to **EC2 > Instances > Launch Instances**
    - Name: `DBAppServer`
    - AMI: Amazon Linux 2
    - Instance type: `t2.micro`
    - Key pair: Create
    - Network: Edit **DB VPC**, **Subnet: DB Public-subnet-01**
    - Auto-assign public IP: **Enable**
    - Security group: **DB Web Security Group**
    - Lunch instance
2. Wait for the instance to start.
3. Note the public IP address.


**SSH Login**

- Go to the directory where the key is located, `chmod 400 	dbkey.pem` 
- SSH into the instance:
   - Syntax `ssh -i <keypair.pem> ec2-user@<AppServer-Public-IP>`
     
  Example:
    ```sh
       ssh -i "dbkey.pem" ec2-user@3.231.105.221
    ```

**Deploy a Web App on the Instance**
  - Install Apache, PHP, and MySQL client:
    ```sh
       sudo yum install -y httpd php php-mysqlnd
    ```
    ```sh
       sudo systemctl enable httpd
    ```
    ```sh
       sudo systemctl start httpd
    ```
    
- Deploy a sample PHP app that connects to MySQL using the RDS endpoint.
  
- Place your `index.php` and `config.php` in `/var/www/html/`
- Index page:
         `sudo vim /var/www/html/index.php`
```php
<?php
// index.php - main application page
error_reporting(E_ALL);
ini_set('display_errors', 1);

// config.php will start the session and redirect to login.php if needed
require_once 'config.php';

// Create students table if it doesn't exist
$tableSql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    age INT,
    college_name VARCHAR(100),
    program_name VARCHAR(100),
    year INT,
    semester VARCHAR(20)
)";
$conn->query($tableSql);

// Handle insert form submission
$insertMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $fn = $conn->real_escape_string($_POST['first_name']);
    $ln = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $college = $conn->real_escape_string($_POST['college_name']);
    $program = $conn->real_escape_string($_POST['program_name']);
    $year = intval($_POST['year']);
    $semester = $conn->real_escape_string($_POST['semester']);

    $sql = "INSERT INTO students (first_name, last_name, age, college_name, program_name, year, semester)
            VALUES ('$fn', '$ln', $age, '$college', '$program', $year, '$semester')";
    if ($conn->query($sql)) {
        $insertMsg = "<span style='color: green;'>Student added successfully!</span>";
    } else {
        $insertMsg = "<span style='color: red;'>Error: " . htmlspecialchars($conn->error) . "</span>";
    }
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    $id = intval($_POST['student_id']);
    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql)) {
        $insertMsg = "<span style='color: green;'>Student deleted successfully!</span>";
    } else {
        $insertMsg = "<span style='color: red;'>Error deleting student: " . htmlspecialchars($conn->error) . "</span>";
    }
}

// Handle edit - show edit form
$editStudent = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM students WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $editStudent = $res->fetch_assoc();
    }
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $id = intval($_POST['student_id']);
    $fn = $conn->real_escape_string($_POST['first_name']);
    $ln = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $college = $conn->real_escape_string($_POST['college_name']);
    $program = $conn->real_escape_string($_POST['program_name']);
    $year = intval($_POST['year']);
    $semester = $conn->real_escape_string($_POST['semester']);

    $sql = "UPDATE students SET first_name='$fn', last_name='$ln', age=$age, college_name='$college', program_name='$program', year=$year, semester='$semester' WHERE id=$id";
    if ($conn->query($sql)) {
        $insertMsg = "<span style='color: green;'>Student updated successfully!</span>";
    } else {
        $insertMsg = "<span style='color: red;'>Error updating student: " . htmlspecialchars($conn->error) . "</span>";
    }
}

// Handle search
$searchResult = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_student'])) {
    $fn = $conn->real_escape_string($_POST['search_first_name']);
    $ln = $conn->real_escape_string($_POST['search_last_name']);

    $sql = "SELECT * FROM students WHERE first_name='$fn' AND last_name='$ln' LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $student = $res->fetch_assoc();
        $searchResult = "<h3>Student Found:</h3>
        <ul>
            <li>First Name: " . htmlspecialchars($student['first_name']) . "</li>
            <li>Last Name: " . htmlspecialchars($student['last_name']) . "</li>
            <li>Age: " . htmlspecialchars($student['age']) . "</li>
            <li>College Name: " . htmlspecialchars($student['college_name']) . "</li>
            <li>Program Name: " . htmlspecialchars($student['program_name']) . "</li>
            <li>Year: " . htmlspecialchars($student['year']) . "</li>
            <li>Semester: " . htmlspecialchars($student['semester']) . "</li>
        </ul>";
    } else {
        $searchResult = "<span style='color: red;'>No student found with that name.</span>";
    }
}

// Get all students for display
$students = [];
$res = $conn->query("SELECT * FROM students ORDER BY id DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $students[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Database Web App</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; width: 350px;}
        h2 { margin-top: 0; }
        table { border-collapse: collapse; width: 90%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f1f1f1; }
        .btn { padding: 4px 10px; cursor: pointer; }
        .edit-link { color: #2980b9; text-decoration: none; }
        .del-btn { background: #e74c3c; color: white; border: none; }
    </style>
</head>
<body>
    <h1>Student Database Web App</h1>
    <p><a href="logout.php">Change DB connection</a><?php if (!empty($_SESSION['db_host'])): ?> — Connected to: <?php echo htmlspecialchars($_SESSION['db_host']); ?><?php endif; ?></p>

    <?php echo $insertMsg; ?>

    <?php if ($editStudent): ?>
        <h2>Edit Student</h2>
        <form method="post">
            <input type="hidden" name="student_id" value="<?php echo $editStudent['id']; ?>">
            <label>First Name: <input type="text" name="first_name" required value="<?php echo htmlspecialchars($editStudent['first_name']); ?>"></label><br><br>
            <label>Last Name: <input type="text" name="last_name" required value="<?php echo htmlspecialchars($editStudent['last_name']); ?>"></label><br><br>
            <label>Age: <input type="number" name="age" required value="<?php echo htmlspecialchars($editStudent['age']); ?>"></label><br><br>
            <label>College Name: <input type="text" name="college_name" required value="<?php echo htmlspecialchars($editStudent['college_name']); ?>"></label><br><br>
            <label>Program Name: <input type="text" name="program_name" required value="<?php echo htmlspecialchars($editStudent['program_name']); ?>"></label><br><br>
            <label>Year: <input type="number" name="year" required value="<?php echo htmlspecialchars($editStudent['year']); ?>"></label><br><br>
            <label>Semester: <input type="text" name="semester" required value="<?php echo htmlspecialchars($editStudent['semester']); ?>"></label><br><br>
            <input type="submit" name="update_student" value="Update Student" class="btn">
            <a href="index.php" class="btn" style="background:#ccc;color:black;">Cancel</a>
        </form>
    <?php else: ?>
        <h2>Add New Student</h2>
        <form method="post">
            <label>First Name: <input type="text" name="first_name" required></label><br><br>
            <label>Last Name: <input type="text" name="last_name" required></label><br><br>
            <label>Age: <input type="number" name="age" required></label><br><br>
            <label>College Name: <input type="text" name="college_name" required></label><br><br>
            <label>Program Name: <input type="text" name="program_name" required></label><br><br>
            <label>Year: <input type="number" name="year" required></label><br><br>
            <label>Semester: <input type="text" name="semester" required></label><br><br>
            <input type="submit" name="add_student" value="Add Student" class="btn">
        </form>
    <?php endif; ?>

    <h2>Search Student</h2>
    <form method="post">
        <label>First Name: <input type="text" name="search_first_name" required></label><br><br>
        <label>Last Name: <input type="text" name="search_last_name" required></label><br><br>
        <input type="submit" name="search_student" value="Search" class="btn">
    </form>
    <?php echo $searchResult; ?>

    <?php if (count($students) > 0): ?>
        <h2>All Students</h2>
        <table>
            <tr>
                <th>ID</th><th>First Name</th><th>Last Name</th><th>Age</th><th>College Name</th>
                <th>Program Name</th><th>Year</th><th>Semester</th><th>Actions</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['age']); ?></td>
                    <td><?php echo htmlspecialchars($student['college_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['program_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['year']); ?></td>
                    <td><?php echo htmlspecialchars($student['semester']); ?></td>
                    <td>
                        <a href="?edit=<?php echo $student['id']; ?>" class="edit-link btn">Edit</a>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                            <button type="submit" name="delete_student" class="del-btn btn" onclick="return confirm('Delete this student?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>

</body>
</html>
```

- Login page
  - sudo vi /var/www/html/login.php
```php
<?php
// login.php - prompts for RDS endpoint, DB username, and password before allowing access
session_start();

$error = '';
$prev_host = '';
$prev_dbname = isset($_SESSION['db_name']) ? htmlspecialchars($_SESSION['db_name']) : 'lab';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim($_POST['db_host'] ?? '');
    $user = trim($_POST['db_user'] ?? '');
    $pass = $_POST['db_pass'] ?? '';
    $dbname = trim($_POST['db_name'] ?? '');

    // Keep sanitized previous host to pre-fill on error
    $prev_host = htmlspecialchars($host);

    // Quick validation
    if ($host === '' || $user === '') {
        $error = 'Please provide both the RDS endpoint and username.';
    } else {
        // Try connecting with supplied credentials (default DB 'lab' if none provided)
        $testDb = $dbname !== '' ? $dbname : 'lab';
        $mysqli = @new mysqli($host, $user, $pass, $testDb);
        if ($mysqli->connect_error) {
            $error = 'Connection failed: ' . htmlspecialchars($mysqli->connect_error);
            // If the DB name caused the failure, we still allow the user to try without it.
        } else {
            // Success: store credentials in session and redirect to main app
            $_SESSION['db_host'] = $host;
            $_SESSION['db_user'] = $user;
            $_SESSION['db_pass'] = $pass;
            $_SESSION['db_name'] = $testDb;
            $mysqli->close();
            header('Location: index.php');
            exit;
        }
    }
} else {
    // If there was a previous failed connection saved in session, show it
    if (!empty($_SESSION['db_error'])) {
        $error = 'Previous connection failed: ' . htmlspecialchars($_SESSION['db_error']);
        unset($_SESSION['db_error']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DB Connection - Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { padding: 15px; border: 1px solid #ccc; width: 420px; }
        label { display:block; margin-bottom: 10px; }
        .btn { padding: 6px 12px; cursor: pointer; }
        .error { color: #c0392b; margin-bottom: 10px; }
        .note { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>Enter RDS Connection Details</h1>
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
        <label>
            RDS Endpoint (host):
            <input type="text" name="db_host" required value="<?php echo $prev_host; ?>" style="width:100%;">
        </label>
        <label>
            Database Username:
            <input type="text" name="db_user" required style="width:100%;">
        </label>
        <label>
            Database Password:
            <input type="password" name="db_pass" required style="width:100%;">
        </label>
        <label>
            Database Name (optional, defaults to "lab"):
            <input type="text" name="db_name" value="<?php echo $prev_dbname; ?>" style="width:100%;">
        </label>
        <br>
        <input type="submit" value="Connect" class="btn">
    </form>

    <p class="note">Note: credentials are stored only in your session for the duration of the browser session. For production, use environment variables or a secrets manager instead of storing credentials in sessions.</p>
</body>
</html>
```

- Logout page:
  - `sudo vi /var/www/html/logout.php`
```php
<?php
// logout.php - clears DB credentials from session and redirects to login page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Only clear DB-related session keys
unset($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['db_name'], $_SESSION['db_error']);

// Redirect to login so the user can re-enter credentials
header('Location: login.php');
exit;
?>
```
      
- Example :
       `sudo vim /var/www/html/config.php`
```php
<?php
// config.php - establishes DB connection using credentials stored in session.
// If credentials are missing, redirect to login.php.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require DB credentials in session
if (
    empty($_SESSION['db_host']) ||
    empty($_SESSION['db_user']) ||
    !array_key_exists('db_pass', $_SESSION) // allow empty password but must be set
) {
    header('Location: login.php');
    exit;
}

$db_host = $_SESSION['db_host'];
$db_user = $_SESSION['db_user'];
$db_pass = $_SESSION['db_pass'];
$db_name = !empty($_SESSION['db_name']) ? $_SESSION['db_name'] : 'lab';

// Attempt to connect
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    // Store a sanitized error message in session and clear credentials so user can re-enter them
    $_SESSION['db_error'] = $conn->connect_error;
    // Clear stored credentials to prevent using broken creds
    unset($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['db_name']);
    header('Location: login.php');
    exit;
}

// Optional: set charset
$conn->set_charset('utf8mb4');
?>
```

- Manage permission:
  
```bash
sudo chown apache:apache /var/www/html/*.php
```

```bash
sudo chmod 644 /var/www/html/*.php
```

-  Restart the Apache web server
```bash
sudo systemctl restart httpd
```


**Connect the App to the RDS Database**
1. Open your web app (browser, using the EC2 public IP).
2. Your PHP app should connect to the RDS endpoint with the credentials above.
3. Endpoint example:
       <img width="611" height="268" alt="Screenshot 2025-11-13 at 1 12 58 PM" src="https://github.com/user-attachments/assets/d3425b5b-e3e5-47e7-9e99-ad374157e386" />

Login Page:

<img width="920" height="475" alt="Screenshot 2025-11-13 at 1 28 25 PM" src="https://github.com/user-attachments/assets/5166ca5c-2c93-4631-ae9b-107ea33d93fd" />


**Test and Validate**
- Add/edit/delete records in the app.
- Confirm data persists and is stored in the RDS database.
- Database:
<img width="1457" height="918" alt="Screenshot 2025-11-13 at 1 30 43 PM" src="https://github.com/user-attachments/assets/90a72d66-f0e1-4353-9844-df4aa7158ee6" />

- Searching:
<img width="1237" height="385" alt="Screenshot 2025-11-13 at 1 31 18 PM" src="https://github.com/user-attachments/assets/8009bda4-aa24-43be-9da0-409e0d451c52" />



---

**Troubleshooting**

| Symptom                   | Possible Cause                       | Fix                                  |
|---------------------------|--------------------------------------|--------------------------------------|
| App can't connect to DB   | Security groups, wrong endpoint      | Check DB SG, use correct endpoint    |
| RDS not accessible        | Wrong VPC/subnet group/Security group| Check networking and SG config       |
| No public IP on instance  | Subnet not public/auto-assign off    | Use public subnet, assign public IP  |
| App errors                | PHP/MySQL not installed              | Install required packages            |


---
