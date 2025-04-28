
document.addEventListener("DOMContentLoaded", function () {
    const addStudentBtn = document.querySelector(".add-student-btn");
    const overlay = document.querySelector(".overlay");
    const addStudentForm = document.querySelector(".add-student-form");
    const usernameInput = document.getElementById("username");



    // Toggle add-student form
    if (addStudentBtn && overlay && addStudentForm) {
        addStudentBtn.addEventListener("click", () => {
            const wasHidden = overlay.style.display === "none";
            overlay.style.display = wasHidden ? "flex" : "none";
           
        });

        overlay.addEventListener("click", event => {
            if (event.target === overlay) {
                overlay.style.display = "none";
            }
        });
    } else {
        console.error("Add Student button, overlay, or form not found.");
    }

    const messageBox = document.getElementById('username-feedback');

    usernameInput.addEventListener('blur', function () {
        const username = this.value.trim();

        if (!messageBox) return;

        if (username === '') {
            messageBox.innerText = '';
            return;
        }

        messageBox.innerText = 'Checking...';
        messageBox.style.color = 'black';

        fetch('/check-username/' + encodeURIComponent(username))
            .then(response => response.json())
            .then(data => {
                console.log(data); // For debugging

                if (!data.valid) {
                    messageBox.innerText = 'Username not found.';
                    messageBox.style.color = 'red';
                } else if (data.has_student) {
                    messageBox.innerText = `This user is already linked to another student (ID: ${data.student_id})`;
                    messageBox.style.color = 'orange';
                } else {
                    messageBox.innerText = `User is available. User ID: ${data.user_id}`;
                    messageBox.style.color = 'green';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                messageBox.innerText = 'Error fetching user data.';
                messageBox.style.color = 'red';
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
        fetch(`/api/sections?${qs}`)
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
    const sectionFormWrap = document.querySelector(".add-section-form");
    
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
