<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoSync HR System</title>
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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-link {
            text-decoration: none;
            color: #666;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-link.active {
            background: #667eea;
            color: white;
        }

        .main-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

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
            color: #333;
            font-weight: 600;
        }

        .btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }

        .btn.cancel {
            background: #dc3545;
            margin-left: 10px;
        }

        .btn.cancel:hover {
            background: #c82333;
        }

        .modal-bg {
        
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .candidate-modal {
            max-width: 800px;
            width: 95%;
            margin-top: 50px auto; /* tambahkan margin atas */
            position: relative; /* atau pastikan tidak fixed jika tidak perlu */
        }

        .modal h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 0;
        }

        .form-row .form-group {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .file-upload-wrapper {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            background: #f8f9fa;
        }

        .file-upload-display {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .file-choose-btn,
        .file-browse-btn {
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            font-size: 14px;
        }

        .file-choose-btn:hover,
        .file-browse-btn:hover {
            background: #f0f0f0;
        }

        .file-name-display {
            color: #666;
            font-size: 14px;
            font-style: italic;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .candidate-modal {    
                max-width: 800px;
                width: 100%;
                max-height: 90vh; /* batasi tinggi modal agar tidak lebih dari layar */
                overflow-y: auto;  /* biar bisa discroll kalau terlalu panjang */
                background-color: white;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
            }
        }

        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .job-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
        }

        .job-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .job-icon {
            font-size: 2rem;
            margin-right: 15px;
        }

        .job-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .job-email {
            color: #666;
            font-size: 0.9rem;
        }

        .job-stats {
            margin: 15px 0;
        }

        .stat-item {
            margin-bottom: 8px;
            color: #555;
        }

        .job-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .job-actions button {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .job-actions button:hover {
            background: #e9ecef;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .candidates-grid,
        .reports-grid {
            display: grid;
            gap: 20px;
            margin-top: 20px;
        }
        /* Candidate Cards Styling */
.candidates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.candidate-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
    position: relative;
}

.candidate-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.candidate-header {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
    gap: 15px;
}

.candidate-avatar {
    font-size: 36px;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    border-radius: 50%;
    flex-shrink: 0;
}

.candidate-info {
    flex: 1;
    min-width: 0;
}

.candidate-name {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
    word-wrap: break-word;
}

.candidate-position {
    font-size: 14px;
    color: #666;
    margin-bottom: 3px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.candidate-email {
    font-size: 12px;
    color: #888;
    display: flex;
    align-items: center;
    gap: 5px;
    word-wrap: break-word;
}

.candidate-details {
    margin-bottom: 15px;
    padding: 10px 0;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-item {
    font-size: 13px;
    color: #666;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.candidate-status {
    margin-bottom: 15px;
    display: flex;
    justify-content: center;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: center;
}

/* Status Badge Colors */
.status-new {
    background: #e3f2fd;
    color: #1976d2;
}

.status-interview {
    background: #fff3e0;
    color: #f57c00;
}

.status-passed {
    background: #e8f5e8;
    color: #2e7d32;
}

.status-failed {
    background: #ffebee;
    color: #d32f2f;
}

.status-final {
    background: #f3e5f5;
    color: #7b1fa2;
}

.status-pooling {
    background: #e0f2f1;
    color: #00695c;
}

.status-offer {
    background: #e8f5e8;
    color: #388e3c;
}

.status-hired {
    background: #c8e6c9;
    color: #1b5e20;
    font-weight: 700;
}

.status-withdraw {
    background: #f5f5f5;
    color: #757575;
}

.status-default {
    background: #f5f5f5;
    color: #666;
}

.candidate-actions {
    display: flex;
    gap: 8px;
    justify-content: space-between;
}

.candidate-actions button {
    flex: 1;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.candidate-actions button:hover {
    transform: translateY(-1px);
}

.candidate-actions button:nth-child(1) {
    background: #e3f2fd;
    color: #1976d2;
}

.candidate-actions button:nth-child(1):hover {
    background: #bbdefb;
}

.candidate-actions button:nth-child(2) {
    background: #fff3e0;
    color: #f57c00;
}

.candidate-actions button:nth-child(2):hover {
    background: #ffe0b2;
}

.candidate-actions button:nth-child(3) {
    background: #ffebee;
    color: #d32f2f;
}

.candidate-actions button:nth-child(3):hover {
    background: #ffcdd2;
}

/* Empty State Styling */
.no-candidates {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 300px;
}

.empty-state {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.6;
}

.empty-state h3 {
    margin-bottom: 10px;
    color: #333;
    font-size: 24px;
}

.empty-state p {
    color: #666;
    margin-bottom: 20px;
    font-size: 16px;
}

.empty-state .btn {
    padding: 12px 24px;
    font-size: 16px;
}

/* Error State Styling */
.error-state {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 300px;
}

.error-state {
    text-align: center;
    padding: 40px;
    background: #ffebee;
    border-radius: 12px;
    border: 1px solid #ffcdd2;
    max-width: 400px;
    width: 100%;
}

.error-icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.7;
}

.error-state h3 {
    margin-bottom: 10px;
    color: #d32f2f;
    font-size: 24px;
}

.error-state p {
    color: #666;
    margin-bottom: 20px;
    font-size: 16px;
}

.error-state .btn {
    background: #d32f2f;
    color: white;
    padding: 12px 24px;
    font-size: 16px;
}

.error-state .btn:hover {
    background: #b71c1c;
}

/* Responsive Design */
@media (max-width: 768px) {
    .candidates-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .candidate-card {
        padding: 15px;
    }
    
    .candidate-header {
        gap: 12px;
    }
    
    .candidate-avatar {
        font-size: 30px;
        width: 40px;
        height: 40px;
    }
    
    .candidate-name {
        font-size: 16px;
    }
    
    .candidate-actions {
        flex-direction: column;
        gap: 8px;
    }
    
    .candidate-actions button {
        width: 100%;
        padding: 10px;
        font-size: 14px;
    }
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
                <a href="recruitment222.php" class="nav-link">Recruitment</a>
                <a href="employees.php" class="nav-link">Employees</a>
                <a href="appraisal.html" class="nav-link">Appraisals</a>
                <a href="payroll.html" class="nav-link">Payroll</a>
            </div>
        </nav>

        <!-- Sub Navigation for Recruitment -->
        <nav class="navbar">
            <div class="nav-links">
                <a href="#" class="nav-link active" onclick="showSection('positions')">Job Positions</a>
                <a href="#" class="nav-link" onclick="showSection('candidates')">Candidates</a>
                <a href="#" class="nav-link" onclick="showSection('contract')">Contract</a>
                <a href="#" class="nav-link" onclick="showSection('reporting')">Reporting</a>
            </div>
        </nav>

        <div class="main-content">
            <!-- Job Positions Section -->
            <div id="positions-section" class="section active">
                <div class="page-header">
                    <h1 class="page-title">📋 Job Positions</h1>
                    <button id="positions" class="btn trigger-btn" onclick="openForm()">+ New Job Position</button>
                </div>

                <form id="jobForm">
                    <input type="hidden" id="job_id" name="job_id" />
                    <div class="modal-bg" id="modal-bg">
                        <div class="modal">
                            <h2>Create Job Position</h2>

                            <div class="form-group">
                                <label for="title">Job Title</label>
                                <input type="text" id="title" name="title" />
                            </div>
                        
                            <div class="form-group">
                                <label for="desc">Job Description</label>
                                <textarea id="desc" rows="3" name="desc"></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="req">Job Requirements</label>
                                <textarea id="req" rows="3" name="req"></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="count">Needed Count</label>
                                <input type="number" id="count" min="1" name="count" />
                            </div>
                        
                            <button id="submit-btn" class="btn" type="button" onclick="submitJob()">Submit</button>
                            <button class="btn cancel" type="button" onclick="closeForm()">Cancel</button>
                        </div>
                    </div>
                </form>

                <!-- Tempat job-card akan muncul -->
                <div class="jobs-grid" id="jobsGrid"></div>
            </div>

            <!-- Candidates Section -->
            <div id="candidates-section" class="section">
                <div class="page-header">
                    <h1 class="page-title">👥 Candidates</h1>
                    <button class="btn" onclick="openCandidateForm()">+ Add New Candidate</button>
                </div>

                <div id="candidatesGrid" class="candidates-grid">
                    <!-- Candidates content will be injected here -->
                    <div class="card">
                        <h3>Candidates Management</h3>
                        <!-- <p>View and manage job applicants here.</p>
                        <p><em>This section is now properly configured and ready for development.</em></p> -->
                        <button class="btn" onclick="openCandidateForm()">Add Candidate</button>
                    </div>
                </div>
            </div>


                <!-- Candidate Form Modal -->
                <div class="modal-bg" id="candidate-modal-bg">
                    <div class="modal candidate-modal">
                        <h2>New Application</h2>
                        <form id="candidateForm">
                            <input type="hidden" id="candidate-id" name="candidate-id" />

                            <!-- Position -->
                            <div class="form-group">
                                <label for="candidate-position">Position</label>
                                <select id="candidate-position" name="candidate-position">
                                    <option value="">Loading positions...</option>
                                </select>
                            </div>
                            
                            <!-- Name Fields Row -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="candidate-lastname">Last Name</label>
                                    <input type="text" id="candidate-lastname" name="candidate-lastname" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="candidate-firstname">First Name</label>
                                    <input type="text" id="candidate-firstname" name="candidate-firstname" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="candidate-middlename">Middle Name</label>
                                    <input type="text" id="candidate-middlename" name="candidate-middlename" />
                                </div>
                            </div>
                            
                            <!-- Gender, Email, Contact Row -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="candidate-gender">Gender</label>
                                    <select id="candidate-gender" name="candidate-gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="candidate-email">Email</label>
                                    <input type="email" id="candidate-email" name="candidate-email" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="candidate-contact">Contact</label>
                                    <input type="tel" id="candidate-contact" name="candidate-contact" />
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="form-group">
                                <label for="candidate-address">Address</label>
                                <textarea id="candidate-address" name="candidate-address" rows="3" placeholder="Enter full address"></textarea>
                            </div>
                            
                            <!-- Cover Letter -->
                            <div class="form-group">
                                <label for="candidate-coverletter">Cover Letter</label>
                                <textarea id="candidate-coverletter" name="candidate-coverletter" rows="4" placeholder="(Optional)"></textarea>
                            </div>
                            
                            <!-- Resume Upload -->
                            <div class="form-group">
    <label for="candidate-resume">Resume</label>
    <div class="file-upload-wrapper">
        <input type="file" id="candidate-resume" name="candidate-resume" accept=".pdf,.doc,.docx" style="display: none;" />
        <div class="file-upload-display">
            <button type="button" class="file-choose-btn" onclick="document.getElementById('candidate-resume').click()">Choose file</button>
            <button type="button" class="file-browse-btn">Browse</button>
        </div>
        <div class="file-name-display" id="resume-file-name">No file chosen</div>
    </div>
    <span id="resumeInfo" class="text-muted small"></span> <!-- Tambahkan ini -->
</div>


                            <div class="form-group">
                                <label for="candidate-status">Status Category</label>
                                <select id="candidate-status" name="candidate-status">
                                    <option value="New" selected>New</option>
                                    <option value="For Initial Interview">For Initial Interview</option>
                                    <option value="PASSED II">PASSED II</option>
                                    <option value="FAILED II">FAILED II</option>
                                    <option value="For Final Interview">For Final Interview</option>
                                    <option value="PASSED FI">PASSED FI</option>
                                    <option value="FAILED FI">FAILED FI</option>
                                    <option value="FOR POOLING">FOR POOLING</option>
                                    <option value="Job Offer">Job Offer</option>
                                    <option value="Hired">Hired</option>
                                    <option value="Withdraw Application">Withdraw Application</option>
                                </select>
                            </div>
                            
                            <div class="form-actions">
                                <button class="btn" type="button" onclick="submitCandidate()">Submit Application</button>
                                <button class="btn cancel" type="button" onclick="closeCandidateForm()">Cancel</button>
                            </div>

                            
                        </form>
                    </div>
                </div>

                <div class="modal-bg" id="candidate-view-modal-bg" style="display: none;">
                    <div class="modal candidate-modal">
                        <h2>Candidate Details</h2>
                        <div id="candidate-details-content">
                            <!-- Content will be filled dynamically -->
                        </div>
                        <div class="form-actions">
                            <button class="btn cancel" onclick="closeCandidateView()">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contract Section -->
            <div id="contract-section" class="section">
                <div class="page-header">
                    <h1 class="page-title">📄 Contract</h1>
                    <button class="btn" onclick="addContract()">➕ Add Contract</button>
                </div>
                
                <div class="candidates-grid">
                    <div class="card">
                        <h3>Contract Management</h3>
                        <p>View and manage contracts here.</p>
                        <p><em>This section is under development.</em></p>
                    </div>
                </div>
            </div>

            <!-- Reporting Section -->
            <div id="reporting-section" class="section">
                <div class="page-header">
                    <h1 class="page-title">📊 Reporting</h1>
                    <button class="btn" onclick="generateReport()">📈 Generate Report</button>
                </div>
                
                <div class="reports-grid">
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
            const targetSection = document.getElementById(sectionName + '-section');
            if (targetSection) {
                targetSection.classList.add('active');
            }
            
            // Add active class to clicked nav link
            if (event && event.target) {
                event.target.classList.add('active');
            }
        }

        // Job Position Functions
        function openForm() {
            document.getElementById('modal-bg').style.display = 'flex';
            document.getElementById('jobForm').reset();
            document.getElementById('job_id').value = '';
            document.getElementById('submit-btn').textContent = 'Submit';
        }

        function closeForm() {
            document.getElementById('modal-bg').style.display = 'none';
            document.getElementById('jobForm').reset();
        }

        // Candidate Functions
        function openCandidateForm() {
            document.getElementById('candidate-modal-bg').style.display = 'flex';
            document.getElementById('candidateForm').reset();
        }

        function closeCandidateForm() {
            document.getElementById('candidate-modal-bg').style.display = 'none';
            document.getElementById('candidateForm').reset();
        }

        // function submitCandidate() {
        //     // Collect all form data
        //     const form = document.getElementById('candidateForm');
        //     const formData = new FormData(form);
                    
        //     fetch('insert_candidate.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(response => response.text())
        //     .then(result => {
        //         if (result.includes("success")) {
        //             alert("Application submitted successfully!");
        //             form.reset();
        //             document.getElementById('resume-file-name').textContent = "No file chosen";
        //         } else {
        //             alert("Submission failed: " + result);
        //         }
        //     })
        //     .catch(error => {
        //         console.error("Error:", error);
        //         alert("Submission error.");
        //     });

        // }

        // Handle file selection display
        document.addEventListener('DOMContentLoaded', function() {
            const resumeInput = document.getElementById('candidate-resume');
            const fileNameDisplay = document.getElementById('resume-file-name');
            
            if (resumeInput && fileNameDisplay) {
                resumeInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        fileNameDisplay.textContent = this.files[0].name;
                        fileNameDisplay.style.color = '#333';
                        fileNameDisplay.style.fontStyle = 'normal';
                    } else {
                        fileNameDisplay.textContent = 'No file chosen';
                        fileNameDisplay.style.color = '#666';
                        fileNameDisplay.style.fontStyle = 'italic';
                    }
                });
            }
        });

        // Job Position Functions (keeping original functionality)
        async function submitJob() {
            const jobId = document.getElementById('job_id').value;

            const data = {
                job_title: document.getElementById('title').value.trim(),
                job_description: document.getElementById('desc').value.trim(),
                job_requirement: document.getElementById('req').value.trim(),
                needed_count: parseInt(document.getElementById('count').value)
            };

            if (!data.job_title || !data.job_description || !data.job_requirement || !data.needed_count) {
                alert("Semua field harus diisi.");
                return;
            }

            // Jika edit, tambahkan job_id
            if (jobId) {
                data.job_id = parseInt(jobId);
            }

            const url = jobId ? 'update_job.php' : 'insert_job.php';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const text = await response.text();
                console.log('Response text:', text);

                const result = JSON.parse(text);

                if (response.ok && result.success) {
                    alert('Data berhasil disimpan!');
                    closeForm();
                    await loadJobs();
                } else {
                    alert('Gagal menyimpan data: ' + (result.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Fetch error:', error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        }

        // get jobs dari database
        async function loadJobs() {
            try {
                const response = await fetch('get_jobs.php');
                const jobs = await response.json();

                const grid = document.getElementById('jobsGrid');
                grid.innerHTML = ''; // Kosongkan dulu

                jobs.forEach(job => {
                    const cardHTML = `
                        <div class="job-card" data-id="${job.id}">
                            <div class="job-header">
                                <div class="job-icon">💼</div>
                                <div>
                                    <div class="job-title">${job.job_title}</div>
                                    <div class="job-email">📝 ${job.job_description}</div>
                                </div>
                            </div>
                            <div class="job-stats">
                                <div class="stat-item">📋 ${job.job_requirement}</div>
                                <div class="stat-item">${job.needed_count} Dibutuhkan</div>
                            </div>
                            <div class="job-actions">
                                <button onclick="editJob(${job.id})">✏️ Edit</button>
                                <button onclick="deleteJob(${job.id})">🗑️ Delete</button>
                            </div>
                        </div>
                    `;
                    grid.insertAdjacentHTML('beforeend', cardHTML);
                });

            } catch (err) {
                console.error('Gagal memuat data:', err);
            }
        }

        async function editJob(id) {
            const response = await fetch('get_jobs.php');
            const jobs = await response.json();

            const job = jobs.find(j => j.id == id);

            if (!job) {
                alert("Data job tidak ditemukan.");
                return;
            }

            // Tampilkan form dulu!
            openForm();

            // Isi data ke form
            document.getElementById('job_id').value = job.id;
            document.getElementById('title').value = job.job_title;
            document.getElementById('desc').value = job.job_description;
            document.getElementById('req').value = job.job_requirement;
            document.getElementById('count').value = job.needed_count;

            // Ubah tombol submit
            document.getElementById('submit-btn').textContent = 'Update';
        }

        async function deleteJob(id) {
            if (confirm("Yakin ingin menghapus job ini?")) {
                try {
                    const response = await fetch('delete_job.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id })
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Hapus elemen dari UI
                        document.querySelector(`.job-card[data-id='${id}']`).remove();
                    } else {
                        alert("Gagal menghapus: " + (result.error || 'Unknown error'));
                    }
                } catch (err) {
                    console.error(err);
                    alert("Terjadi kesalahan saat menghapus.");
                }
            }
        }

        // Other functions CONTRACT
        function addContract() {
            alert('Add Contract functionality - to be implemented');
        }

        function generateReport() {
            alert('Generate Report functionality - to be implemented');
        }

        // Load jobs when page loads
        window.addEventListener('DOMContentLoaded', loadJobs);

        // function submitCandidate() {
        //     const form = document.getElementById('candidateForm');
        //     const formData = new FormData(form);

        //     fetch('insert_candidate.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(response => response.text())
        //     .then(result => {
        //         if (result.includes("success")) {
        //             alert("Application submitted successfully!");
        //             form.reset();
        //             document.getElementById('resume-file-name').textContent = "No file chosen";
        //         } else {
        //             alert("Submission failed: " + result);
        //         }
        //     })
        //     .catch(error => {
        //         console.error("Error:", error);
        //         alert("Submission error.");
        //     });
        // }

// Function to load positions from database
async function loadPositions() {
    try {
        console.log('🔄 Loading positions from database...');
        const response = await fetch('get_position.php');
        
        console.log('📡 Response status:', response.status, response.statusText);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const responseText = await response.text();
        console.log('📄 Raw response:', responseText);
        
        let positions;
        try {
            positions = JSON.parse(responseText);
        } catch (parseError) {
            console.error('❌ JSON parse error:', parseError);
            console.log('Raw response that failed to parse:', responseText);
            throw new Error('Invalid JSON response');
        }
        
        console.log('✅ Parsed positions:', positions);
        console.log('📊 Number of positions:', positions.length);
        
        const positionSelect = document.getElementById('candidate-position');
        
        if (!positionSelect) {
            console.error('❌ Position select element not found!');
            return;
        }
        
        // Clear existing options and add default
        positionSelect.innerHTML = '<option value="">Please select here</option>';
        console.log('🧹 Cleared existing options');
        
        // Add positions from database
        if (Array.isArray(positions) && positions.length > 0) {
            positions.forEach((position, index) => {
                console.log(`➕ Adding position ${index + 1}:`, position);
                const option = document.createElement('option');
                option.value = position.job_title; // Menggunakan job_title langsung
                option.textContent = position.job_title;
                positionSelect.appendChild(option);
                console.log(`✅ Added: ${position.job_title}`);
            });
            console.log('🎉 All positions added successfully!');
        } else {
            console.log('⚠️ No positions found or invalid format');
            console.log('🔄 Loading default positions...');
            loadDefaultPositions();
        }
        
    } catch (error) {
        console.error('❌ Error loading positions:', error);
        console.log('🔄 Falling back to default positions...');
        loadDefaultPositions();
    }
}

// Fallback function with default positions
function loadDefaultPositions() {
    console.log('🔄 Loading default positions...');
    const positionSelect = document.getElementById('candidate-position');
    
    if (!positionSelect) {
        console.error('❌ Position select element not found for defaults!');
        return;
    }
    
    const defaultPositions = [
        { value: 'frontend-developer', text: 'Frontend Developer' },
        { value: 'backend-developer', text: 'Backend Developer' },
        { value: 'fullstack-developer', text: 'Fullstack Developer' },
        { value: 'ui-ux-designer', text: 'UI/UX Designer' },
        { value: 'project-manager', text: 'Project Manager' }
    ];
    
    positionSelect.innerHTML = '<option value="">Please select here</option>';
    
    defaultPositions.forEach(position => {
        const option = document.createElement('option');
        option.value = position.value;
        option.textContent = position.text;
        positionSelect.appendChild(option);
    });
    
    console.log('✅ Default positions loaded');
}

// Test function - panggil ini dari console untuk debugging
function testLoadPositions() {
    console.log('🧪 Testing loadPositions function...');
    loadPositions();
}

// Modified openCandidateForm function
function openCandidateForm() {
    console.log('📝 Opening candidate form...');
    document.getElementById('candidate-modal-bg').style.display = 'flex';
    document.getElementById('candidateForm').reset();
    
    // Load positions when opening the form
    setTimeout(() => {
        console.log('⏰ Loading positions after timeout...');
        loadPositions();
    }, 100);
}

function submitCandidate() {
    console.log('📝 Submitting candidate application...');
    
    const form = document.getElementById('candidateForm');
    const candidateId = form.getAttribute('data-candidate-id');
    const isUpdate = candidateId && candidateId !== '';
    
    const formData = new FormData(form);
    
    // Add candidate ID for update
    if (isUpdate) {
        formData.append('candidate_id', candidateId);
    }
    
    // Client-side validation
    const position = document.getElementById('candidate-position').value.trim();
    const lastName = document.getElementById('candidate-lastname').value.trim();
    const firstName = document.getElementById('candidate-firstname').value.trim();
    const email = document.getElementById('candidate-email').value.trim();
    const contact = document.getElementById('candidate-contact').value.trim();
    const address = document.getElementById('candidate-address').value.trim();

    if (!position) {
        alert('Please select a position.');
        return;
    }

    if (!lastName || !firstName) {
        alert('Please fill in Last Name and First Name.');
        return;
    }

    if (!email) {
        alert('Please enter an email address.');
        return;
    }

    if (!contact) {
        alert('Please enter a contact number.');
        return;
    }

    if (!address) {
        alert('Please enter an address.');
        return;
    }

    // Show loading state
    const submitBtn = document.querySelector('#candidateForm button[onclick="submitCandidate()"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = isUpdate ? 'Updating...' : 'Submitting...';
    submitBtn.disabled = true;

    // Choose endpoint based on operation
    const endpoint = isUpdate ? 'update_candidate.php' : 'insert_candidate.php';

    // Submit to server
    fetch(endpoint, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('📡 Server response status:', response.status);
        return response.text();
    })
    .then(result => {
        console.log('📄 Server response:', result);
        
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        if (result.includes("success")) {
            alert(isUpdate ? "Candidate updated successfully!" : "Application submitted successfully!");
            form.reset();
            form.removeAttribute('data-candidate-id');
            document.getElementById('resume-file-name').textContent = "No file chosen";
            
            // Clear resume info
            const resumeInfo = document.getElementById('resumeInfo');
            if (resumeInfo) {
                resumeInfo.textContent = '';
            }
            
            closeCandidateForm();
            
            // Reload candidates to show changes
            loadCandidates();
        } else {
            alert("Operation failed: " + result);
        }
    })
    .catch(error => {
        console.error("❌ Submission error:", error);
        
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        alert("Submission error: " + error.message);
    });
}

// Single DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOM loaded, initializing...');
    
    // Load positions on page load
    loadPositions();
    
    // Load jobs
    if (typeof loadJobs === 'function') {
        loadJobs();
    }
    
    // Handle file selection display
    const resumeInput = document.getElementById('candidate-resume');
    const fileNameDisplay = document.getElementById('resume-file-name');
    
    if (resumeInput && fileNameDisplay) {
        resumeInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.style.color = '#333';
                fileNameDisplay.style.fontStyle = 'normal';
            } else {
                fileNameDisplay.textContent = 'No file chosen';
                fileNameDisplay.style.color = '#666';
                fileNameDisplay.style.fontStyle = 'italic';
            }
        });
    }
});

async function loadCandidates() {
    try {
        console.log('🔄 Loading candidates from database...');
        const response = await fetch('get_candidates.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const candidates = await response.json();
        console.log('✅ Loaded candidates:', candidates);
        
        const grid = document.getElementById('candidatesGrid');
        if (!grid) {
            console.error('❌ Candidates grid not found!');
            return;
        }
        
        grid.innerHTML = ''; // Clear existing content
        
        if (candidates && candidates.length > 0) {
            candidates.forEach(candidate => {
                const fullName = `${candidate.first_name} ${candidate.middle_name ? candidate.middle_name + ' ' : ''}${candidate.last_name}`.trim();
                const statusClass = getStatusClass(candidate.status);
                
                const cardHTML = `
                    <div class="candidate-card" data-id="${candidate.id}">
                        <div class="candidate-header">
                            <div class="candidate-avatar">
                                ${getGenderIcon(candidate.gender)}
                            </div>
                            <div class="candidate-info">
                                <div class="candidate-name">${fullName}</div>
                                <div class="candidate-position">📋 ${candidate.position}</div>
                                <div class="candidate-email">📧 ${candidate.email}</div>
                            </div>
                        </div>
                        <div class="candidate-details">
                            <div class="detail-item">📱 ${candidate.contact}</div>
                            <div class="detail-item">📍 ${candidate.address.substring(0, 50)}${candidate.address.length > 50 ? '...' : ''}</div>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge ${statusClass}">${candidate.status}</span>
                        </div>
                        <div class="candidate-actions">
                            <button onclick="viewCandidate(${candidate.id})" title="View Details">👁️ View</button>
                            <button onclick="editCandidate(${candidate.id})" title="Edit">✏️ Edit</button>
                            <button onclick="deleteCandidate(${candidate.id})" title="Delete">🗑️ Delete</button>
                        </div>
                    </div>
                `;
                grid.insertAdjacentHTML('beforeend', cardHTML);
            });
        } else {
            grid.innerHTML = `
                <div class="no-candidates">
                    <div class="empty-state">
                        <div class="empty-icon">👥</div>
                        <h3>No Candidates Yet</h3>
                        <p>Start by adding your first candidate application.</p>
                        <button class="btn" onclick="openCandidateForm()">➕ Add First Candidate</button>
                    </div>
                </div>
            `;
        }
        
    } catch (error) {
        console.error('❌ Error loading candidates:', error);
        const grid = document.getElementById('candidatesGrid');
        if (grid) {
            grid.innerHTML = `
                <div class="error-state">
                    <div class="error-icon">⚠️</div>
                    <h3>Error Loading Candidates</h3>
                    <p>Unable to load candidate data. Please try again.</p>
                    <button class="btn" onclick="loadCandidates()">🔄 Retry</button>
                </div>
            `;
        }
    }
}

// Helper function to get gender icon
function getGenderIcon(gender) {
    switch (gender?.toLowerCase()) {
        case 'male': return '👨';
        case 'female': return '👩';
        default: return '👤';
    }
}

// Helper function to get status class for styling
function getStatusClass(status) {
    const statusMap = {
        'New': 'status-new',
        'For Initial Interview': 'status-interview',
        'PASSED II': 'status-passed',
        'FAILED II': 'status-failed',
        'For Final Interview': 'status-final',
        'PASSED FI': 'status-passed',
        'FAILED FI': 'status-failed',
        'FOR POOLING': 'status-pooling',
        'Job Offer': 'status-offer',
        'Hired': 'status-hired',
        'Withdraw Application': 'status-withdraw'
    };
    return statusMap[status] || 'status-default';
}


// Function to edit candidate
// Function to edit candidate - FIXED VERSION
async function editCandidate(id) {
    try {
        console.log('Editing candidate:', id);
        
        // Fetch candidate data
        const response = await fetch(`get_candidate.php?id=${id}`);
        if (!response.ok) {
            throw new Error('Failed to fetch candidate data');
        }
        
        const candidate = await response.json();
        
        // Open form first
        openCandidateForm();
        
        // Wait for positions to load and form to be visible, then populate
        setTimeout(() => {
            populateCandidateForm(candidate);
        }, 300); // Increased timeout to ensure positions are loaded
        
    } catch (error) {
        console.error('Error editing candidate:', error);
        alert('Failed to load candidate data for editing.');
    }
}

// Helper function to populate candidate form
// function populateCandidateForm(candidate) {
//     document.getElementById('candidate-position').value = candidate.position || '';
//     document.getElementById('candidate-lastname').value = candidate.last_name || '';
//     document.getElementById('candidate-firstname').value = candidate.first_name || '';
//     document.getElementById('candidate-middlename').value = candidate.middle_name || '';
//     document.getElementById('candidate-gender').value = candidate.gender || '';
//     document.getElementById('candidate-email').value = candidate.email || '';
//     document.getElementById('candidate-contact').value = candidate.contact || '';
//     document.getElementById('candidate-address').value = candidate.address || '';
//     document.getElementById('candidate-coverletter').value = candidate.cover_letter || '';
//     document.getElementById('candidate-status').value = candidate.status || 'New';
    
//     // Store candidate ID for update
//     document.getElementById('candidateForm').setAttribute('data-candidate-id', candidate.id);
    
//     // Change submit button text
//     const submitBtn = document.querySelector('#candidateForm button[onclick="submitCandidate()"]');
//     if (submitBtn) {
//         submitBtn.textContent = 'Update Application';
//     }
// }

// Function to delete candidate
async function deleteCandidate(id) {
    if (!confirm('Are you sure you want to delete this candidate application?')) {
        return;
    }
    
    try {
        const response = await fetch('delete_candidate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            // Remove from UI
            const candidateCard = document.querySelector(`.candidate-card[data-id='${id}']`);
            if (candidateCard) {
                candidateCard.remove();
            }
            alert('Candidate deleted successfully!');
        } else {
            alert('Failed to delete candidate: ' + (result.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Delete error:', error);
        alert('Error occurred while deleting candidate.');
    }
}

// Modified submitCandidate function to handle both create and update
function submitCandidate() {
    console.log('📝 Submitting candidate application...');
    
    const form = document.getElementById('candidateForm');
    const candidateId = form.getAttribute('data-candidate-id');
    const isUpdate = candidateId && candidateId !== '';
    
    const formData = new FormData(form);
    
    // Add candidate ID for update
    if (isUpdate) {
        formData.append('candidate_id', candidateId);
    }
    
    // Client-side validation
    const position = document.getElementById('candidate-position').value.trim();
    const lastName = document.getElementById('candidate-lastname').value.trim();
    const firstName = document.getElementById('candidate-firstname').value.trim();
    const email = document.getElementById('candidate-email').value.trim();
    const contact = document.getElementById('candidate-contact').value.trim();
    const address = document.getElementById('candidate-address').value.trim();


    if (!position) {
        alert('Please select a position.');
        return;
    }

    if (!lastName || !firstName) {
        alert('Please fill in Last Name and First Name.');
        return;
    }

    if (!email) {
        alert('Please enter an email address.');
        return;
    }

    if (!contact) {
        alert('Please enter a contact number.');
        return;
    }

    if (!address) {
        alert('Please enter an address.');
        return;
    }

    // Show loading state
    const submitBtn = document.querySelector('#candidateForm button[onclick="submitCandidate()"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = isUpdate ? 'Updating...' : 'Submitting...';
    submitBtn.disabled = true;

    // Choose endpoint based on operation
    const endpoint = isUpdate ? 'update_candidate.php' : 'insert_candidate.php';

    // Submit to server
    fetch(endpoint, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('📡 Server response status:', response.status);
        return response.text();
    })
    .then(result => {
        console.log('📄 Server response:', result);
        
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        if (result.includes("success")) {
            alert(isUpdate ? "Candidate updated successfully!" : "Application submitted successfully!");
            form.reset();
            form.removeAttribute('data-candidate-id');
            document.getElementById('resume-file-name').textContent = "No file chosen";
            closeCandidateForm();
            
            // Reload candidates to show changes
            loadCandidates();
        } else {
            alert("Operation failed: " + result);
        }
    })
    .catch(error => {
        console.error("❌ Submission error:", error);
        
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        alert("Submission error: " + error.message);
    });
}

// Modified closeCandidateForm to clear edit state
function closeCandidateForm() {
    document.getElementById('candidate-modal-bg').style.display = 'none';
    const form = document.getElementById('candidateForm');
    form.reset();
    form.removeAttribute('data-candidate-id');
    
    // Reset file display
    document.getElementById('resume-file-name').textContent = "No file chosen";
    document.getElementById('resume-file-name').style.color = '#666';
    document.getElementById('resume-file-name').style.fontStyle = 'italic';
    
    // Clear resume info
    const resumeInfo = document.getElementById('resumeInfo');
    if (resumeInfo) {
        resumeInfo.textContent = '';
        resumeInfo.style.color = '';
    }
    
    // Reset submit button text
    const submitBtn = document.querySelector('#candidateForm button[onclick="submitCandidate()"]');
    if (submitBtn) {
        submitBtn.textContent = 'Submit Application';
    }
}

// Enhanced file input handler - FIXED VERSION
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOM loaded, initializing...');
    
    // Load positions and candidates on page load
    loadPositions();
    loadCandidates();
    
    // Load jobs
    if (typeof loadJobs === 'function') {
        loadJobs();
    }
    
    // Handle file selection display - ENHANCED VERSION
    const resumeInput = document.getElementById('candidate-resume');
    const fileNameDisplay = document.getElementById('resume-file-name');
    const resumeInfo = document.getElementById('resumeInfo');
    
    if (resumeInput && fileNameDisplay) {
        resumeInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                fileNameDisplay.textContent = fileName;
                fileNameDisplay.style.color = '#333';
                fileNameDisplay.style.fontStyle = 'normal';
                
                if (resumeInfo) {
                    resumeInfo.textContent = `Selected file: ${fileName}`;
                    resumeInfo.style.color = '#28a745';
                }
            } else {
                fileNameDisplay.textContent = 'No file chosen';
                fileNameDisplay.style.color = '#666';
                fileNameDisplay.style.fontStyle = 'italic';
                
                if (resumeInfo) {
                    resumeInfo.textContent = '';
                }
            }
        });
    }
});
// Update showSection function untuk handle candidates
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
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    // Load data when switching to candidates section
    if (sectionName === 'candidates') {
        loadCandidates();
    }
    
    // Add active class to clicked nav link
    if (event && event.target) {
        event.target.classList.add('active');
    }
}

    function viewCandidate(id) {
    fetch(`get_candidate.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            const detailsHtml = `
                <p><strong>Position:</strong> ${data.position}</p>
                <p><strong>Full Name:</strong> ${data.full_name}</p>
                <p><strong>Gender:</strong> ${data.gender}</p>
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Contact:</strong> ${data.contact}</p>
                <p><strong>Address:</strong> ${data.address}</p>
                <p><strong>Cover Letter:</strong><br>${data.cover_letter || '-'}</p>
                <p><strong>Resume:</strong> ${data.resume_filename ? `<a href="uploads/resumes/${data.resume_filename}" target="_blank">${data.resume_filename}</a>` : '-'}</p>
            `;

            document.getElementById('candidate-details-content').innerHTML = detailsHtml;
            document.getElementById('candidate-view-modal-bg').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error fetching candidate:', error);
            alert('Failed to fetch candidate details.');
        });
}


    function closeCandidateView() {
        document.getElementById('candidate-view-modal-bg').style.display = 'none';
    }

    function populateCandidateForm(candidate) {
    // Wait for positions to be loaded before setting position
    const positionSelect = document.getElementById('candidate-position');
    if (positionSelect && positionSelect.options.length <= 1) {
        // If positions not loaded yet, wait a bit more
        setTimeout(() => populateCandidateForm(candidate), 200);
        return;
    }

    // Populate basic fields
    document.getElementById('candidate-lastname').value = candidate.last_name || '';
    document.getElementById('candidate-firstname').value = candidate.first_name || '';
    document.getElementById('candidate-middlename').value = candidate.middle_name || '';
    document.getElementById('candidate-gender').value = candidate.gender || '';
    document.getElementById('candidate-email').value = candidate.email || '';
    document.getElementById('candidate-contact').value = candidate.contact || '';
    document.getElementById('candidate-address').value = candidate.address || '';
    document.getElementById('candidate-coverletter').value = candidate.cover_letter || '';
    document.getElementById('candidate-status').value = candidate.status || 'New';
    
    // Set position - FIXED
    if (candidate.position) {
        document.getElementById('candidate-position').value = candidate.position;
    }
    
    // Handle resume file display - FIXED
    const resumeFileDisplay = document.getElementById('resume-file-name');
    const resumeInfo = document.getElementById('resumeInfo');
    
    if (candidate.resume_filename) {
        resumeFileDisplay.textContent = `Current: ${candidate.resume_filename}`;
        resumeFileDisplay.style.color = '#007bff';
        resumeFileDisplay.style.fontStyle = 'normal';
        
        if (resumeInfo) {
            resumeInfo.textContent = `Current resume: ${candidate.resume_filename}`;
            resumeInfo.style.color = '#007bff';
        }
    } else {
        resumeFileDisplay.textContent = 'No file uploaded';
        resumeFileDisplay.style.color = '#666';
        resumeFileDisplay.style.fontStyle = 'italic';
        
        if (resumeInfo) {
            resumeInfo.textContent = '';
        }
    }
    
    // Store candidate ID for update
    document.getElementById('candidateForm').setAttribute('data-candidate-id', candidate.id);
    
    // Change submit button text
    const submitBtn = document.querySelector('#candidateForm button[onclick="submitCandidate()"]');
    if (submitBtn) {
        submitBtn.textContent = 'Update Application';
    }
}


document.getElementById('candidate-resume').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
    document.getElementById('resumeInfo').textContent = `Selected file: ${fileName}`;
});

    </script>
</body>
</html>