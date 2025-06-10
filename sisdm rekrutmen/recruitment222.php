<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoSync Recruitment System</title>
    <link rel="stylesheet" href="style.css">
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
                /* Add styles for different sections */
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        .nav-link.active {
            
            color: white;
            border-radius: 4px;
            padding: 8px 12px;
        }

        /* job position form */
            .modal-bg {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.4);
      justify-content: center;
      align-items: center;
    }

    .modal {
      background: #f8f8ff;
      border-radius: 16px;
      padding: 30px;
      width: 400px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .modal h2 {
      margin-top: 0;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .form-group input, .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #d0d0f0;
      border-radius: 10px;
      font-size: 14px;
    }

    .btn {
      background: linear-gradient(to right, #7a5cff, #5e63f3);
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: bold;
    }

    .btn:hover {
      background: #5e63f3;
    }

    .trigger-btn {
      margin: 20px;
    }

    .btn.cancel {
  background: #ccc;
  color: #333;
  margin-left: 10px;
}

.btn.cancel:hover {
  background: #aaa;
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Main Navigation -->
        <nav class="navbar">
            <a href="#" class="nav-brand" onclick="showPage('dashboard')">🏢 NeoSync HR System</a>
            <div class="nav-links">
                <a href="index.html" class="nav-link">Dashboard</a>
                <a href="recruitment.html" class="nav-link">Recruitment</a>
                <a href="employees.html" class="nav-link">Employees</a>
                <a href="appraisal.html" class="nav-link">Appraisals</a>
                <a href="payroll.html" class="nav-link">Payroll</a>
            </div>
        </nav>

        <!-- Sub Navigation for Recruitment -->
        <nav class="navbar">
            <div class="nav-links">
                <a href="#" class="nav-link active" onclick="showSection('positions')">Job Positions</a>
                <a href="#" class="nav-link" onclick="showSection('candidates')">Candidates</a>
                <a href="#" class="nav-link" onclick="showSection('reporting')">Reporting</a>
            </div>
        </nav>

        <div class="main-content">
            <!-- Job Positions Section -->
            <div id="positions-section" class="section active">
                <div class="page-header">
                    <h1 class="page-title">📋 Job Positions</h1>
                    <button class="btn trigger-btn" onclick="openForm()">+ New Job Position</button>
                    
                </div>

                <form id="jobForm">
  <div class="modal-bg" id="modal-bg">
    <div class="modal">
      <h2>Create Job Position</h2>

      <div class="form-group">
        <label for="title">Job Title</label>
        <input type="text" id="title" />
      </div>

      <div class="form-group">
        <label for="desc">Job Description</label>
        <textarea id="desc" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label for="req">Job Requirements</label>
        <textarea id="req" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label for="count">Needed Count</label>
        <input type="number" id="count" min="1" />
      </div>

      <button class="btn" type="button" onclick="submitJob()">Submit</button>
      <button class="btn cancel" type="button" onclick="closeForm()">Cancel</button>
    </div>
  </div>
</form>

<!-- Tempat job-card akan muncul -->
<div class="jobs-grid" id="jobsGrid"></div>



<!-- Grid for job cards -->
<div class="jobs-grid" id="jobsGrid"></div>
        
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
                </div>
            </div>

            <!-- Candidates Section -->
            <div id="candidates-section" class="section">
                <div class="page-header">
                    <h1 class="page-title">👥 Candidates</h1>
                    <button class="btn btn-primary" onclick="addCandidate()">➕ Add Candidate</button>
                </div>
                
                <div class="candidates-grid">
                    <!-- Candidates content will go here -->
                    <div class="card">
                        <h3>Candidates Management</h3>
                        <p>View and manage job applicants here.</p>
                        <p><em>This section is under development.</em></p>
                    </div>
                </div>
            </div>

            <!-- Reporting Section -->
            <div id="reporting-section" class="section">
                <div class="page-header">
                    <h1 class="page-title">📊 Reporting</h1>
                    <button class="btn btn-primary" onclick="generateReport()">📈 Generate Report</button>
                </div>
                
                <div class="reports-grid">
                    <!-- Reporting content will go here -->
                    <div class="card">
                        <h3>Recruitment Analytics</h3>
                        <p>View recruitment statistics and reports here.</p>
                        <p><em>This section is under development.</em></p>
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


function openForm() {
    document.getElementById('modal-bg').style.display = 'flex';
  }

  function closeForm() {
    document.getElementById('modal-bg').style.display = 'none';
    document.getElementById('jobForm').reset();
  }

  async function submitJob() {
    const data = {
      job_title: document.getElementById('title').value.trim(),
      job_description: document.getElementById('desc').value.trim(),
      job_requirement: document.getElementById('req').value.trim(),
      needed_count: parseInt(document.getElementById('count').value)
    };

    // Validasi input
    if (!data.job_title || !data.job_description || !data.job_requirement || !data.needed_count) {
      alert("Semua field harus diisi.");
      return;
    }

    try {
      const response = await fetch('insert_job.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (response.ok) {
        // Tambahkan kartu job ke grid
        const cardHTML = `
          <div class="job-card">
            <div class="job-header">
              <div class="job-icon">💼</div>
              <div>
                <div class="job-title">${result.job_title}</div>
                <div class="job-email">📝 ${result.job_description}</div>
              </div>
            </div>
            <div class="job-stats">
              <div class="stat-item">📋 ${result.job_requirement}</div>
              <div class="stat-item">${result.needed_count} Dibutuhkan</div>
            </div>
          </div>
        `;
        document.getElementById('jobsGrid').insertAdjacentHTML('afterbegin', cardHTML);
        closeForm();
      } else {
        alert('Gagal menambahkan data: ' + (result.error || 'Unknown error'));
      }
    } catch (err) {
      console.error('Fetch error:', err);
      alert('Terjadi kesalahan saat mengirim data.');
    }
  }

//   get jobs dari database
async function loadJobs() {
  try {
    const response = await fetch('get_jobs.php');
    const jobs = await response.json();

    const grid = document.getElementById('jobsGrid');
    grid.innerHTML = ''; // Kosongkan dulu

    jobs.forEach(job => {
      const cardHTML = `
        <div class="job-card">
          <div class="job-header">
            <div class="job-icon">💼</div>
            <div>
              <div class="j ob-title">${job.job_title}</div>
              <div class="job-email">📝 ${job.job_description}</div>
            </div>
          </div>
          <div class="job-stats">
            <div class="stat-item">📋 ${job.job_requirement}</div>
            <div class="stat-item">${job.needed_count} Dibutuhkan</div>
          </div>
        </div>
      `;
      grid.insertAdjacentHTML('beforeend', cardHTML);
    });

  } catch (err) {
    console.error('Gagal memuat data:', err);
  }
}

// Panggil saat halaman dimuat
window.addEventListener('DOMContentLoaded', loadJobs);
    </script>
</body>
</html>