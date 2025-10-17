// Archive Module JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize archive functionality
    initializeArchiveModule();
});

function initializeArchiveModule() {
    // Year selector functionality
    const yearSelector = document.getElementById('yearSelector');
    if (yearSelector) {
        yearSelector.addEventListener('change', handleYearChange);
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(handleSearch, 300));
    }

    // Filter functionality
    const gradeFilter = document.getElementById('gradeFilter');
    const sectionFilter = document.getElementById('sectionFilter');
    const statusFilter = document.getElementById('statusFilter');

    if (gradeFilter) gradeFilter.addEventListener('change', handleFilterChange);
    if (sectionFilter) sectionFilter.addEventListener('change', handleFilterChange);
    if (statusFilter) statusFilter.addEventListener('change', handleFilterChange);

    // Archive current year button
    const archiveCurrentYearBtn = document.getElementById('archiveCurrentYearBtn');
    if (archiveCurrentYearBtn) {
        archiveCurrentYearBtn.addEventListener('click', handleArchiveCurrentYear);
    }

    // Export buttons
    const exportButtons = document.querySelectorAll('[data-action="export"]');
    exportButtons.forEach(btn => {
        btn.addEventListener('click', handleExport);
    });

    // Restore student buttons
    const restoreButtons = document.querySelectorAll('[data-action="restore"]');
    restoreButtons.forEach(btn => {
        btn.addEventListener('click', handleRestoreStudent);
    });

    // Student detail modals
    const viewDetailButtons = document.querySelectorAll('[data-action="view-detail"]');
    viewDetailButtons.forEach(btn => {
        btn.addEventListener('click', handleViewDetail);
    });
}

// Year change handler
function handleYearChange(event) {
    const selectedYear = event.target.value;
    const currentYear = event.target.dataset.currentYear;
    
    if (selectedYear === currentYear) {
        // Load current year data (live from Students & Sections)
        loadCurrentYearData();
    } else {
        // Load archived year data
        loadArchivedYearData(selectedYear);
    }
    
    // Update UI to reflect current selection
    updateYearDisplay(selectedYear);
}

// Load current year data (live from Students & Sections)
function loadCurrentYearData() {
    showLoadingState();
    
    fetch('/admin/archive/year/current', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        updateStudentTable(data.students);
        updateStatistics(data.statistics);
        hideLoadingState();
    })
    .catch(error => {
        console.error('Error loading current year data:', error);
        showError('Failed to load current year data');
        hideLoadingState();
    });
}

// Load archived year data
function loadArchivedYearData(year) {
    showLoadingState();
    
    fetch(`/admin/archive/year/${year}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        updateStudentTable(data.students);
        updateStatistics(data.statistics);
        hideLoadingState();
    })
    .catch(error => {
        console.error('Error loading archived year data:', error);
        showError('Failed to load archived year data');
        hideLoadingState();
    });
}

// Update student table
function updateStudentTable(students) {
    const tbody = document.querySelector('#studentTable tbody');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (students.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="no-data-cell">
                    <div class="no-data">
                        <div class="no-data-icon">👥</div>
                        <h4>No students found</h4>
                        <p>No students available for the selected year.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    students.forEach(student => {
        const row = createStudentRow(student);
        tbody.appendChild(row);
    });
}

// Create student table row
function createStudentRow(student) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <div class="student-id">
                <strong>${student.school_student_id || student.student_number || 'N/A'}</strong>
                ${student.lrn ? `<br><small>LRN: ${student.lrn}</small>` : ''}
            </div>
        </td>
        <td>
            <div class="student-info">
                <div class="student-avatar">
                    ${student.picture ? 
                        `<img src="${student.picture}" alt="${student.first_name}" class="avatar">` :
                        `<div class="avatar-placeholder">${student.first_name.charAt(0)}</div>`
                    }
                </div>
                <div class="student-details">
                    <strong>${student.full_name || `${student.first_name} ${student.last_name}`}</strong>
                    ${student.email ? `<br><small>${student.email}</small>` : ''}
                </div>
            </div>
        </td>
        <td>
            <span class="grade-badge">${student.grade_level_name || student.gradeLevel?.name || 'N/A'}</span>
        </td>
        <td>${student.section_name || student.section?.section_name || 'N/A'}</td>
        <td>${student.strand_name || student.strand?.name || 'N/A'}</td>
        <td>
            <span class="status-badge ${getStatusClass(student.status_name || student.status?.name)}">
                ${student.status_name || student.status?.name || 'N/A'}
            </span>
        </td>
        <td>
            <div class="action-buttons">
                <button class="btn btn-sm btn-info" data-action="view-detail" data-student-id="${student.id || student.student_id}">
                    👁️ Details
                </button>
                ${student.is_archived ? 
                    `<button class="btn btn-sm btn-success" data-action="restore" data-student-id="${student.id}">🔄 Restore</button>` :
                    ''
                }
            </div>
        </td>
    `;

    // Add event listeners for buttons in this row
    const viewBtn = row.querySelector('[data-action="view-detail"]');
    if (viewBtn) {
        viewBtn.addEventListener('click', () => handleViewDetail(student));
    }

    const restoreBtn = row.querySelector('[data-action="restore"]');
    if (restoreBtn) {
        restoreBtn.addEventListener('click', () => handleRestoreStudent(student.id));
    }

    return row;
}

// Update statistics
function updateStatistics(stats) {
    const totalStudentsElement = document.getElementById('totalStudents');
    const gradeDistributionElement = document.getElementById('gradeDistribution');
    const statusDistributionElement = document.getElementById('statusDistribution');

    if (totalStudentsElement) {
        totalStudentsElement.textContent = stats.total_students || 0;
    }

    if (gradeDistributionElement) {
        gradeDistributionElement.innerHTML = '';
        if (stats.grade_distribution) {
            stats.grade_distribution.forEach(grade => {
                const gradeItem = document.createElement('div');
                gradeItem.className = 'grade-item';
                gradeItem.innerHTML = `
                    <span class="grade-name">${grade.grade_level_name || grade.name}</span>
                    <span class="grade-count">${grade.count}</span>
                `;
                gradeDistributionElement.appendChild(gradeItem);
            });
        }
    }

    if (statusDistributionElement) {
        statusDistributionElement.innerHTML = '';
        if (stats.status_distribution) {
            stats.status_distribution.forEach(status => {
                const statusItem = document.createElement('div');
                statusItem.className = 'status-item';
                statusItem.innerHTML = `
                    <span class="status-name">${status.status_name || status.name}</span>
                    <span class="status-count">${status.count}</span>
                `;
                statusDistributionElement.appendChild(statusItem);
            });
        }
    }
}

// Search functionality
function handleSearch(event) {
    const query = event.target.value;
    const selectedYear = document.getElementById('yearSelector').value;
    
    if (query.length < 2) {
        // Reset to show all students
        handleYearChange({ target: { value: selectedYear } });
        return;
    }

    showLoadingState();

    fetch(`/admin/archive/search?query=${encodeURIComponent(query)}&academic_year=${selectedYear}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        updateStudentTable(data);
        hideLoadingState();
    })
    .catch(error => {
        console.error('Error searching:', error);
        showError('Search failed');
        hideLoadingState();
    });
}

// Filter functionality
function handleFilterChange() {
    const selectedYear = document.getElementById('yearSelector').value;
    const gradeFilter = document.getElementById('gradeFilter').value;
    const sectionFilter = document.getElementById('sectionFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;

    const filters = {
        year: selectedYear,
        grade: gradeFilter,
        section: sectionFilter,
        status: statusFilter
    };

    applyFilters(filters);
}

// Apply filters
function applyFilters(filters) {
    showLoadingState();

    const params = new URLSearchParams();
    Object.keys(filters).forEach(key => {
        if (filters[key]) {
            params.append(key, filters[key]);
        }
    });

    fetch(`/admin/archive/filter?${params.toString()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        updateStudentTable(data);
        hideLoadingState();
    })
    .catch(error => {
        console.error('Error filtering:', error);
        showError('Filter failed');
        hideLoadingState();
    });
}

// Archive current year
function handleArchiveCurrentYear() {
    if (!confirm('Are you sure you want to archive the current academic year? This action will create a permanent record of all current students and cannot be undone.')) {
        return;
    }

    showLoadingState();

    fetch('/admin/archive/current-year', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess(data.message || 'Academic year archived successfully');
            // Reload the page to show updated data
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            showError(data.message || 'Failed to archive academic year');
        }
        hideLoadingState();
    })
    .catch(error => {
        console.error('Error archiving current year:', error);
        showError('Failed to archive academic year');
        hideLoadingState();
    });
}

// Export functionality
function handleExport(event) {
    const year = event.target.dataset.year || document.getElementById('yearSelector').value;
    
    // Create download link
    const downloadUrl = `/admin/archive/export/${year}`;
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = `students_archive_${year}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Restore student
function handleRestoreStudent(studentId) {
    if (!confirm('Are you sure you want to restore this student? This will move them back to the active students list.')) {
        return;
    }

    showLoadingState();

    fetch(`/admin/archive/restore/${studentId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess(data.message || 'Student restored successfully');
            // Remove the restored student from the table
            const row = document.querySelector(`[data-student-id="${studentId}"]`).closest('tr');
            if (row) {
                row.remove();
            }
        } else {
            showError(data.message || 'Failed to restore student');
        }
        hideLoadingState();
    })
    .catch(error => {
        console.error('Error restoring student:', error);
        showError('Failed to restore student');
        hideLoadingState();
    });
}

// View student details
function handleViewDetail(student) {
    // Create and show student detail modal
    showStudentDetailModal(student);
}

// Show student detail modal
function showStudentDetailModal(student) {
    // Create modal HTML
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>Student Details</h3>
                <span class="close" onclick="this.closest('.modal').remove()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="student-detail-grid">
                    <div class="detail-section">
                        <h4>Personal Information</h4>
                        <div class="detail-item">
                            <label>Name:</label>
                            <span>${student.full_name || `${student.first_name} ${student.last_name}`}</span>
                        </div>
                        <div class="detail-item">
                            <label>Student ID:</label>
                            <span>${student.school_student_id || student.student_number || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <label>LRN:</label>
                            <span>${student.lrn || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <label>Email:</label>
                            <span>${student.email || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <label>Contact:</label>
                            <span>${student.contact_number || 'N/A'}</span>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h4>Academic Information</h4>
                        <div class="detail-item">
                            <label>Grade Level:</label>
                            <span>${student.grade_level_name || student.gradeLevel?.name || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <label>Section:</label>
                            <span>${student.section_name || student.section?.section_name || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <label>Strand:</label>
                            <span>${student.strand_name || student.strand?.name || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <label>Status:</label>
                            <span class="status-badge ${getStatusClass(student.status_name || student.status?.name)}">
                                ${student.status_name || student.status?.name || 'N/A'}
                            </span>
                        </div>
                    </div>
                </div>
                
                ${student.grades && student.grades.length > 0 ? `
                    <div class="detail-section">
                        <h4>Academic Records</h4>
                        <div class="grades-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>1st Q</th>
                                        <th>2nd Q</th>
                                        <th>3rd Q</th>
                                        <th>4th Q</th>
                                        <th>Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${student.grades.map(grade => `
                                        <tr>
                                            <td>${grade.subject_name || grade.subject}</td>
                                            <td>${grade.first_quarter || '-'}</td>
                                            <td>${grade.second_quarter || '-'}</td>
                                            <td>${grade.third_quarter || '-'}</td>
                                            <td>${grade.fourth_quarter || '-'}</td>
                                            <td>${grade.final_grade || '-'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                ` : ''}
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="this.closest('.modal').remove()">Close</button>
                ${student.is_archived ? 
                    `<button class="btn btn-primary" onclick="handleRestoreStudent(${student.id}); this.closest('.modal').remove();">Restore Student</button>` :
                    ''
                }
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    modal.style.display = 'block';
}

// Utility functions
function getStatusClass(status) {
    if (!status) return 'unknown';
    const statusLower = status.toLowerCase();
    if (statusLower.includes('active') || statusLower.includes('enrolled')) return 'active';
    if (statusLower.includes('graduated') || statusLower.includes('completed')) return 'completed';
    if (statusLower.includes('transferred') || statusLower.includes('withdrawn')) return 'inactive';
    return 'unknown';
}

function updateYearDisplay(selectedYear) {
    const yearDisplay = document.getElementById('currentYearDisplay');
    if (yearDisplay) {
        yearDisplay.textContent = selectedYear;
    }

    // Update archive button visibility
    const archiveBtn = document.getElementById('archiveCurrentYearBtn');
    if (archiveBtn) {
        const currentYear = document.getElementById('yearSelector').dataset.currentYear;
        if (selectedYear === currentYear) {
            archiveBtn.style.display = 'inline-block';
        } else {
            archiveBtn.style.display = 'none';
        }
    }
}

function showLoadingState() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
}

function hideLoadingState() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
}

function showSuccess(message) {
    showNotification(message, 'success');
}

function showError(message) {
    showNotification(message, 'error');
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Hide after 5 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// View year comparison
function viewYearComparison() {
    window.location.href = '/admin/archive/comparison';
}

// Export comparison data
function exportComparison() {
    window.location.href = '/admin/archive/export/comparison';
}
