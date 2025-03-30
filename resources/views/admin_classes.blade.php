<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Classes</title>
  <link rel="stylesheet" href="{{ asset('css/style_admin_classes.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
        <img src="{{ asset('images/schoollogo.png') }}" alt="School Logo" class="logo">
        <h2>MCA Montessori School</h2>
        <nav class="menu">
            <ul>
            <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">Users</a></li>
            <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">Instructors</a></li>
            <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
            <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Classes</a></li>
            </ul>
        </nav>
        <a href="#" class="logout">Logout</a>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-bar">
                <div class="welcome">
                <h3>Manage Classes</h3>
                </div>
                <div class="user-info">
                <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
                <img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon">
                </div>
            </header>

            <div class="container-classes">
                <div class="grade-box">
                    <h2>Grade 11 <button class="add-student-btn">+ Add Student</button></h2>
                    <div class="strand-box">
                        <h3>Strand: STEM - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="strand-box">
                        <h3>Strand: HUMSS - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="strand-box">
                        <h3>Strand: ABM - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="strand-box">
                        <h3>Strand: HE - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            <div class="container-classes">
                <div class="grade-box">
                    <h2>Grade 12 <button class="add-student-btn">+ Add Student</button></h2>
                    <div class="strand-box">
                        <h3>Strand: STEM - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="strand-box">
                        <h3>Strand: GAS - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="strand-box">
                        <h3>Strand: HE - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="strand-box">
                        <h3>Strand: ICT - Section 1A</h3>
                        <h4>Student List</h4>
                        <table>
                            <thead>
                                <tr>
                                <th>Account ID</th>
                                <th>Name</th>
                                <th>Strand</th>
                                <th>Grade</th>
                                <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>001</td>
                                <td>John Doe</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                                <tr>
                                <td>002</td>
                                <td>Jane Smith</td>
                                <td>STEM</td>
                                <td>11</td>
                                <td>1A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            <!-- Blurred Background Overlay -->
            <div class="overlay" style="display: none;">
                <div class="add-student-form">
                    <h3>Add Student</h3>
                    <div class="student-info">
                        <div class="student-image">
                            <img src="{{ asset('images/me.jpg') }}" alt="Profile Picture">
                            <button>Add picture</button>
                        </div>
                        <div class="student-details">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" autocomplete="name">
                    
                            <label for="account_id">Account ID:</label>
                            <input type="text" id="account_id" name="account_id" autocomplete="username">
                    
                            <label for="grade_section">Grade & Section:</label>
                            <input type="text" id="grade_section" name="grade_section" autocomplete="off">
                    
                            <label for="strand">Strand:</label>
                            <input type="text" id="strand" name="strand" autocomplete="off">
                    
                            <button class="add-btn">Add</button>
                        </div>
                    </div>
                </div>
            </div>

          
        </main>

        <!-- Hidden Add Student Form -->
        
    </div>

   

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const addStudentBtn = document.querySelector(".add-student-btn");
        const overlay = document.querySelector(".overlay");
        const addStudentForm = document.querySelector(".add-student-form");

        if (addStudentBtn && overlay && addStudentForm) {
            addStudentBtn.addEventListener("click", function () {
                if (overlay.style.display === "none" || overlay.style.display === "") {
                    overlay.style.display = "flex"; // Show overlay and form
                } else {
                    overlay.style.display = "none"; // Hide overlay and form
                }
            });

            // Close form when clicking outside of it
            overlay.addEventListener("click", function (event) {
                if (event.target === overlay) {
                    overlay.style.display = "none";
                }
            });
        } else {
            console.error("Add Student button, overlay, or form not found.");
        }
    });


  </script>

</body>
</html>
