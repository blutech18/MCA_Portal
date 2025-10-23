/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */

document.addEventListener("DOMContentLoaded", function () {
    const addStudentBtn = document.querySelector(".add-student-btn");
    const overlay = document.querySelector(".overlay");
    const addStudentForm = document.querySelector(".add-student-form");



    // Toggle add-student form
    if (addStudentBtn && overlay) {
        addStudentBtn.addEventListener("click", () => {
            overlay.style.display = "flex";
            // Reset form when opening
            document.getElementById('add-student-form').reset();
            // Reset photo to default
            document.getElementById('student-photo').src = '/images/student_user.png';
            console.log("Add Student modal opened");
        });

        overlay.addEventListener("click", event => {
            if (event.target === overlay) {
                closeStudentModal();
            }
        });
    } else {
        console.error("Add Student button or overlay not found.");
    }

    const appIdInput = document.getElementById('student_school_id');
    const photoImg   = document.getElementById('student-photo');
    const pictureInput = document.getElementById('picture-input');

    if (!appIdInput) return console.error('No #student_school_id found');

    // Handle image preview when file is selected
    if (pictureInput) {
        pictureInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    photoImg.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Add keyboard support for radio buttons
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStudentModal();
        }
    });

    // Auto-generate student ID for manual additions
    function generateStudentId() {
        const fname = document.getElementById('fname')?.value || '';
        const lname = document.getElementById('lname')?.value || '';
        
        if (fname && lname && !appIdInput.value) {
            const year = new Date().getFullYear();
            const initials = (fname.charAt(0) + lname.slice(0, 3)).toUpperCase();
            const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            const studentId = `MCA-${initials}-${year}-${random}`;
            
            appIdInput.value = studentId;
            console.log('Auto-generated student ID:', studentId);
        }
    }

    // Generate ID when names are filled (debounced)
    let generateTimeout;
    ['fname', 'lname'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', () => {
                clearTimeout(generateTimeout);
                generateTimeout = setTimeout(generateStudentId, 800);
            });
        }
    });

    appIdInput.addEventListener('blur', () => {
        const appNum = appIdInput.value.trim();
        console.log('Blurring ID, appNum =', appNum);
        if (!appNum) return;

        // Try to fetch enrollee data (if it exists)
        const url = `${window.enrolleeApiBase}/${encodeURIComponent(appNum)}`;
        console.log('Fetching enrollee data from:', url);

        fetch(url)
        .then(res => {
            console.log('Got response', res.status);
            if (!res.ok) throw new Error('Not found');
            return res.json();
        })
        .then(data => {
            console.log('Enrollee data found, auto-filling:', data);
            document.getElementById('fname').value   = data.given_name   || '';
            document.getElementById('mname').value   = data.middle_name  || '';
            document.getElementById('lname').value   = data.surname      || '';
            document.getElementById('email').value   = data.email        || '';
            document.getElementById('dob').value     = data.dob          || '';
            document.getElementById('contact').value = data.contact_no   || '';
            document.getElementById('address').value = data.address      || '';

            if (data.id_picture_path) {
                photoImg.src = `/storage/${data.id_picture_path}`;
            } else {
                photoImg.src = '/images/student_user.png';
            }
        })
        .catch(err => {
            console.log('No enrollee found (manual addition mode):', err.message);
            // Don't clear fields for manual addition - just keep what user entered
        });
    });
    
    const strand  = document.getElementById('strand');
    const sem     = document.getElementById('semester');
    const section = document.getElementById('section');
    const gradeRadios = document.querySelectorAll('input[name="grade_level_id"]');

    function resetAll() {
        strand.value  = '';
        sem.value     = '';
        section.innerHTML = '<option value="">-- Select Section --</option>';
    }

    // Handle grade level radio button changes
    gradeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const gradeId  = radio.value;
            const gradeNum = parseInt(radio.dataset.grade, 10);
            resetAll();

            if (!gradeId) {
                strand.disabled  = true;
                sem.disabled     = true;
                section.disabled = true;
                return;
            }

            if (gradeNum < 11) {
                // Junior High (7-10): sections only
                strand.disabled  = true;
                strand.required  = false;
                sem.disabled     = true;
                section.disabled = false;
                section.required = true;
                fetchSections({ grade_level_id: gradeId });
            } else {
                // Senior High (11-12): strand & semester required
                strand.disabled  = false;
                strand.required  = true;
                sem.disabled     = false;
                sem.required     = true;
                section.disabled = true;
            }
        });
    });

    strand.addEventListener('change', () => {
        const selectedGradeRadio = document.querySelector('input[name="grade_level_id"]:checked');
        const gradeId = selectedGradeRadio?.value;
        const strandId = strand.value;
        
        console.log("Selected grade:", gradeId);
        console.log("Selected strand:", strandId);
        
        if (gradeId && strandId) {
            section.disabled = false;
            section.required = true;
            fetchSections({ grade_level_id: gradeId, strand_id: strandId });
        }
    });

    function fetchSections(params) {
        const qs = new URLSearchParams(params).toString();
        fetch(`/admin/api/sections?${qs}`)
        .then(r => r.json())
        .then(json => {
            section.innerHTML = '<option value="">-- Select Section --</option>';
            
            if (json.sections.length === 0) {
                section.innerHTML = '<option value="">No sections available - Create one first</option>';
            } else {
                json.sections.forEach(sec => {
                    section.append(new Option(sec.section_name, sec.id));
                });
            }
        })
        .catch(err => {
            console.error('Error fetching sections:', err);
            section.innerHTML = '<option value="">Error loading sections</option>';
        });
    }

    // Add section capacity check when section is selected
    section.addEventListener('change', () => {
        const sectionId = section.value;
        const selectedGradeRadio = document.querySelector('input[name="grade_level_id"]:checked');
        const gradeId = selectedGradeRadio?.value;
        
        if (sectionId && gradeId) {
            // Check section capacity
            checkSectionCapacity(sectionId, gradeId);
        }
    });

    // Close modal function
    window.closeStudentModal = function() {
        const overlay = document.querySelector('.overlay');
        if (overlay) {
            overlay.style.display = 'none';
            // Reset form when closing
            const form = document.getElementById('add-student-form');
            if (form) {
                form.reset();
            }
            // Reset photo to default
            const photo = document.getElementById('student-photo');
            if (photo) {
                photo.src = '/images/student_user.png';
            }
            console.log("Add Student modal closed");
        }
    };

    // Form submission with loading state
    const studentForm = document.getElementById('add-student-form');
    if (studentForm) {
        studentForm.addEventListener('submit', function(e) {
            const submitBtn = studentForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 11-6.219-8.56"></path>
                    </svg>
                    Adding Student...
                `;
                
                // Re-enable button after 10 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Add Student
                    `;
                }, 10000);
            }
        });
    }

    function checkSectionCapacity(sectionId, gradeLevelId) {
        // This will be validated server-side, but we can show a warning
        fetch(`/admin/api/section-capacity?section_id=${sectionId}&grade_level_id=${gradeLevelId}`)
        .then(r => r.json())
        .then(data => {
            if (data.count >= 25) {
                alert(`⚠️ Warning: This section is at maximum capacity (${data.count}/25 students). Please select a different section or create a new one.`);
                section.value = '';
            } else if (data.count >= 20) {
                console.log(`Section is nearly full: ${data.count}/25 students`);
            }
        })
        .catch(err => {
            console.log('Could not check section capacity:', err);
        });
    }

    const sectionLinks = document.querySelectorAll('.section-link');
    const tableBody = document.querySelector('#student-table tbody');
    const classTitle = document.getElementById('class-title');

    sectionLinks.forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();

            const gradeId = link.dataset.grade;
            const strandId = link.dataset.strand;
            const sectionId = link.dataset.section;

            try {
                const response = await fetch(`/admin/get-students/${gradeId}/${strandId}/${sectionId}`);
                const data = await response.json();

                if (data.error) {
                    classTitle.textContent = data.error;
                    tableBody.innerHTML = '';
                    return;
                }

                // Check if data is valid and not empty
                if (!data.strand || !data.grade || !data.section || !data.students.length) {
                    classTitle.textContent = 'No students found for the selected section.';
                    tableBody.innerHTML = '';
                    return;
                }

                // Update class title with strand, grade, and section
                classTitle.textContent = `Strand: ${data.strand} - Section ${data.section} (Grade ${data.grade})`;

                // Clear existing table data
                tableBody.innerHTML = '';

                // Populate table with new data
                data.students.forEach(student => {
                    const row = `
                        <tr>
                            <td>${student.user_id}</td>
                            <td>${student.display_name || `${student.first_name} ${student.last_name}`}</td>
                            <td>${data.strand}</td>
                            <td>${data.grade}</td>
                            <td>${data.section}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

            } catch (error) {
                console.error('Error fetching student data:', error);
                classTitle.textContent = 'Error loading students.';
                tableBody.innerHTML = '';
            }
        });
    });

    const addSectionBtn   = document.querySelector(".add-section-btn");
    const overlaySection  = document.querySelector(".overlay-section");
    const gradeSelect = document.getElementById("section-grade-level");
    const strandGroup = document.getElementById("strand-group");
    const strandEl    = document.getElementById("section-strand");
    
    // Show the modal with smooth animation
    addSectionBtn.addEventListener("click", () => {
        overlaySection.style.display = "flex";
        
        // Trigger animation
        setTimeout(() => {
            overlaySection.style.opacity = '1';
            const modalContent = overlaySection.querySelector('div[style*="transform"]');
            if (modalContent) {
                modalContent.style.transform = 'scale(1)';
                modalContent.style.opacity = '1';
            }
        }, 10);
    });
    
    // Close modal with smooth animation
    window.closeAddSectionModal = function() {
        const modalContent = overlaySection.querySelector('div[style*="transform"]');
        overlaySection.style.opacity = '0';
        if (modalContent) {
            modalContent.style.transform = 'scale(0.9)';
            modalContent.style.opacity = '0';
        }
        setTimeout(() => {
            overlaySection.style.display = 'none';
        }, 300);
    }

    // Hide when clicking outside the form
    overlaySection.addEventListener("click", e => {
        if (e.target === overlaySection) {
            closeAddSectionModal();
        }
    });

    function toggleStrand() {
    // your <option>s carry data-name="{{ $g->name }}", so use that
    const name = gradeSelect.selectedOptions[0]?.dataset.name || "";
    if (parseInt(name, 10) >= 11) {
      strandGroup.style.display   = "";
      strandEl.required           = true;
    } else {
      strandGroup.style.display   = "none";
      strandEl.required           = false;
      strandEl.value              = "";
    }
  }

  gradeSelect.addEventListener("change", toggleStrand);
  toggleStrand();  // run once in case the form was pre‐populated

    const sortSelect  = document.getElementById('sort');
    const searchInput = document.getElementById('search');
    const boxes       = document.querySelectorAll('.container-classes .strand-box');

    function filter() {
        const gradeFilter = sortSelect.value;            
        const textFilter  = searchInput.value.trim().toLowerCase();

        // 1) No grade AND no text? hide all
        if (!gradeFilter && !textFilter) {
        boxes.forEach(b => b.style.display = 'none');
        return;
        }

        // 2) Otherwise show only those that match BOTH
        boxes.forEach(box => {
        const boxGrade     = box.dataset.grade;         
        const matchesGrade = !gradeFilter || boxGrade === gradeFilter;
        const matchesText  = !textFilter  || box.innerText.toLowerCase().includes(textFilter);

        box.style.display = (matchesGrade && matchesText) ? '' : 'none';
        });
    }

    sortSelect.addEventListener('change', filter);
    searchInput.addEventListener('input',  filter);

    // initial state: hide everything 
    filter();
});
