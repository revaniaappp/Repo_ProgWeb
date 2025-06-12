<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoSync Recruitment System</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional external CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 15px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .nav-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            gap: 5px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Main Content */
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
        }

        /* Page Headers */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* Job Positions Grid */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .job-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            position: relative;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .job-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .job-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .job-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .job-company {
            color: #666;
            font-size: 0.95rem;
        }

        .job-stats {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .stat-applications {
            background: #e3f2fd;
            color: #1976d2;
        }

        .stat-to-recruit {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        /* Department Sidebar */
        .sidebar {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .sidebar h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .dept-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dept-item:hover {
            background: #f8f9fa;
            padding-left: 10px;
            border-radius: 8px;
        }

        .dept-name {
            font-weight: 500;
            color: #333;
        }

        .dept-count {
            background: #e9ecef;
            color: #495057;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Candidates Section */
        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .candidate-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .candidate-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .candidate-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .candidate-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .candidate-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }

        .candidate-rating {
            display: flex;
            gap: 3px;
            margin-top: 10px;
        }

        .star {
            color: #ddd;
            font-size: 1.1rem;
        }

        .star.filled {
            color: #ffd700;
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .chart-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
        }

        .chart-filters {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* Chart */
        .chart {
            height: 300px;
            position: relative;
            margin: 20px 0;
        }

        .chart-point {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .chart-point:hover {
            transform: scale(1.5);
        }

        .chart-point.blue {
            background: #2196f3;
        }

        .chart-point.red {
            background: #f44336;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .page-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .jobs-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Page visibility */
        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* Layout for job positions page */
        .layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 25px;
        }

        @media (max-width: 1024px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
      <a href="#" class="nav-brand" onclick="showPage('dashboard')">🏢 NeoSync HR System</a>
      <div class="nav-links">
        <a href="index.html" class="nav-link" onclick="showPage('dashboard')">Dashboard</a>
        <a href="recruitment.html" class="nav-link" onclick="showPage('recruitment')">Recruitment</a>
        <a href="employees.html" class="nav-link" onclick="showPage('employees')">Employees</a>
        <a href="appraisal.html" class="nav-link" onclick="showPage('appraisals')">Appraisals</a>
        <a href="payroll.html" class="nav-link" onclick="showPage('payroll')">Payroll</a>
      </div>
    </nav>
        <nav class="navbar">
            <div class="nav-links">
                <a href="#" class="nav-link active">Job Positions</a>
                <a href="#" class="nav-link">Candidates</a>
                <a href="#" class="nav-link">Reporting</a>
            </div>
        </nav>

        <div class="main-content">
            <div class="page-header">
                <h1 class="page-title">📋 Job Positions</h1>
                <button class="btn btn-primary" onclick="showForm()">➕ New Job Position</button>
            </div>

            <div id="formContainer" style="display:none; margin-bottom: 30px;">
                <form id="jobForm">
                    <input type="text" id="title" placeholder="Job Title" required>
                    <input type="text" id="department" placeholder="Department" required>
                    <input type="text" id="company" placeholder="Company" required>
                    <input type="email" id="email" placeholder="Email">
                    <input type="number" id="applications" placeholder="Applications" value="0">
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <div class="layout">
                <div>
                    <div class="sidebar">
                        <h3>📊 DEPARTMENT</h3>
                        <div class="dept-item" onclick="filterByDept('all')">
                            <span class="dept-name">All</span>
                        </div>
                        <div class="dept-item" onclick="filterByDept('pengembangan-it')">
                            <span class="dept-name">Pengembangan IT</span>
                        </div>
                    </div>
                </div>

                <div>
                    <div id="candidates" class="page">
                <div class="page-header">
                    <h1 class="page-title">
                        👥 Candidates
                    </h1>
                    <a href="#" class="btn btn-primary">
                        ➕ New Candidate
                    </a>
                </div>
                </div>
                <div>
                    <div class="jobs-grid" id="jobsGrid">
                        <?php
                        $result = $conn->query("SELECT * FROM jobs ORDER BY id DESC");
                        while ($job = $result->fetch_assoc()):
                        ?>
                        <div class="job-card" data-dept="<?= htmlspecialchars($job['department']) ?>">
                            <div class="job-header">
                                <div class="job-icon">⭐</div>
                                <div>
                                    <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
                                    <div class="job-company"><?= htmlspecialchars($job['company']) ?></div>
                                    <?php if (!empty($job['email'])): ?>
                                        <div style="font-size: 0.85rem; color: #666;">📧 <?= htmlspecialchars($job['email']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="job-stats">
                                <div class="stat-item stat-applications"><?= (int)$job['applications'] ?> New Applications</div>
                                <div class="stat-item stat-to-recruit"><?= (int)$job['to_recruit'] ?> To Recruit</div>
                            </div>
                            <div style="margin-top: 10px;">
                                <a href="edit_job.php?id=<?= $job['id'] ?>">✏️ Edit</a> |
                                <a href="delete_job.php?id=<?= $job['id'] ?>" onclick="return confirm('Delete this job?')">🗑️ Delete</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function to show different sections
        function showSection(sectionName) {
            // Hide all sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all nav links
            const navLinks = document.querySelectorAll('.navbar:nth-child(2) .nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionName + '-section').classList.add('active');
            
            // Add active class to clicked nav link
            event.target.classList.add('active');
        }

        function showForm() {
            const form = document.getElementById('formContainer');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function filterByDept(department) {
            const jobCards = document.querySelectorAll('.job-card');
            jobCards.forEach(card => {
                if (department === 'all' || card.dataset.dept.includes(department)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Placeholder functions for new sections
        function addCandidate() {
            alert('Add Candidate functionality - to be implemented');
        }

        function generateReport() {
            alert('Generate Report functionality - to be implemented');
        }

        document.getElementById('jobForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const data = {
                title: document.getElementById('title').value,
                department: document.getElementById('department').value,
                company: document.getElementById('company').value,
                email: document.getElementById('email').value,
                applications: document.getElementById('applications').value
            };

            const response = await fetch('insert_job.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const newJob = await response.text();
                document.getElementById('jobsGrid').insertAdjacentHTML('afterbegin', newJob);
                document.getElementById('jobForm').reset();
                document.getElementById('formContainer').style.display = 'none';
            } else {
                alert('Failed to add job');
            }
        });
    </script>
</body>
</html>
