
document.addEventListener("DOMContentLoaded", function () {
    const addStudentBtn = document.querySelector(".add-student-btn");
    const overlay = document.querySelector(".overlay");
    const addStudentForm = document.querySelector(".add-student-form");



    // Toggle add-student form
    if (addStudentBtn && overlay && addStudentForm) {
        addStudentBtn.addEventListener("click", () => {
            const wasHidden = overlay.style.display === "none";
            overlay.style.display = wasHidden ? "flex" : "none";
            console.log("Submit triggered");
           
        });

        overlay.addEventListener("click", event => {
            if (event.target === overlay) {
                overlay.style.display = "none";
            }
        });
    } else {
        console.error("Add Student button, overlay, or form not found.");
    }

    const appIdInput = document.getElementById('student_school_id');
    const photoImg   = document.getElementById('student-photo');

    if (!appIdInput) return console.error('No #student_school_id found');

    appIdInput.addEventListener('blur', () => {
        const appNum = appIdInput.value.trim();
        console.log('Blurring ID, appNum =', appNum);        // 🔥 debug
        if (!appNum) return;

        // build the URL via Laravel so it’s always correct
        const url = `${window.enrolleeApiBase}/${encodeURIComponent(appNum)}`;
        console.log('Fetching', url);

        fetch(url)
        .then(res => {
            console.log('Got response', res.status);
            if (!res.ok) throw new Error('Not found');
            return res.json();
        })
        .then(data => {
            console.log('Enrollee data', data);
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
            console.warn('Lookup failed:', err);
            ['fname','mname','lname','email','dob','contact','address']
            .forEach(id => document.getElementById(id).value = '');
            photoImg.src = '/images/student_user.png';
        });
    });
    
    const grade   = document.getElementById('grade');
    const strand  = document.getElementById('strand');
    const sem     = document.getElementById('semester');
    const section = document.getElementById('section');


    function resetAll() {
        strand.value  = '';
        sem.value     = '';
        section.innerHTML = '<option value="">-- Select Section --</option>';
    }

    grade.addEventListener('change', e => {
        const gradeId  = e.target.value;                                  // 1–6
        const gradeNum = parseInt(e.target.selectedOptions[0].dataset.grade, 10); // 7–12
        resetAll();

        if (!gradeId) {
        strand.disabled  = true;
        sem.disabled     = true;
        section.disabled = true;
        return;
        }

        if (gradeNum < 11) {
        // Junior High: sections only
        strand.disabled  = true;
        sem.disabled     = true;
        section.disabled = false;
        fetchSections({ grade_level_id: gradeId });
        } else {
        // Senior High: strand & semester, wait for strand
        strand.disabled  = false;
        sem.disabled     = false;
        section.disabled = true;
        }
    });

    strand.addEventListener('change', () => {
        const gradeId = grade.value;
        const strandId = strand.value;
        console.log("Selected grade:", grade.value);
        console.log("Selected strand:", strand.value);
        
        if (gradeId && strandId) {
        section.disabled = false;
        fetchSections({ grade_level_id: gradeId, strand_id: strandId });
        }
    });

    function fetchSections(params) {
        const qs = new URLSearchParams(params).toString();
        fetch(`/admin/api/sections?${qs}`)
        .then(r => r.json())
        .then(json => {
            section.innerHTML = '<option value="">-- Select Section --</option>';
            json.sections.forEach(sec => {
            section.append(new Option(sec.section_name, sec.id));
            });
        })
        .catch(console.error);
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
                            <td>${student.first_name} ${student.last_name}</td>
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
    
    // Show the modal
    addSectionBtn.addEventListener("click", () => {
        overlaySection.style.display = "flex";    // or "block", depending on your CSS
    });

    // Hide when clicking outside the form
    overlaySection.addEventListener("click", e => {
        if (e.target === overlaySection) {
        overlaySection.style.display = "none";
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
