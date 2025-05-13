document.getElementById('addCourseForm').addEventListener('submit', () => {
  document.getElementById('semester').disabled = false;
  document.getElementById('strand').disabled = false;
  document.getElementById('section').disabled = false;
});

document.querySelector('.add-student-btn').addEventListener('click', function () {
    document.getElementById('addCourseModal').style.display = 'block';
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
  const gradeId  = e.target.value;
  const gradeNum = parseInt(e.target.selectedOptions[0].dataset.grade, 10);
  resetAll();

  if (!gradeId) {
    strand.disabled  = true;
    sem.disabled     = true;
    section.disabled = true;
    return;
  }

  if (gradeNum < 11) {
    strand.disabled  = true;
    sem.disabled     = true;
    section.disabled = false;
    fetchSections({ grade_level_id: gradeId });
  } else {
    strand.disabled  = false;
    sem.disabled     = false;
    section.disabled = true;
  }
});

strand.addEventListener('change', () => {
  const gradeId  = grade.value;
  const strandId = strand.value;
  if (gradeId && strandId) {
    section.disabled = false;
    fetchSections({ grade_level_id: gradeId, strand_id: strandId });
  }
});

function fetchSections(params) {
  const qs = new URLSearchParams(params).toString();
  fetch(`/admin/api/sections?${qs}`)
    .then(res => res.json())
    .then(data => {
      section.innerHTML = '<option value="">-- Select Section --</option>';
      data.sections.forEach(sec => {
        section.append(new Option(sec.section_name, sec.id));
      });
    })
    .catch(console.error);
}

document.addEventListener('DOMContentLoaded', () => {
  const editModal   = document.getElementById('editCourseModal');
  const addModal   = document.getElementById('addCourseModal');
  const closeBtn    = editModal.querySelector('.close-btn');
  const closeBtnn    = addModal.querySelector('.close-btnn');
  const editForm    = document.getElementById('editCourseForm');
  const gradeEl     = document.getElementById('edit_grade');
  const strandEl    = document.getElementById('edit_strand');
  const semEl       = document.getElementById('edit_semester');
  const sectionEl   = document.getElementById('edit_section');
  const searchInput = document.getElementById('instructor-search');
  const tableRows   = document.querySelectorAll('.strand-box table tbody tr');

    searchInput.addEventListener('input', () => {
      const filter = searchInput.value.trim().toLowerCase();

      tableRows.forEach(row => {
        // Grab the Class Name cell (first <td>)
        const classNameCell = row.querySelector('td');
        const text = classNameCell.textContent.trim().toLowerCase();

        // Show/hide row based on whether it contains the filter text
        if (text.includes(filter)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });

  // fetch & populate sections helper
  function fetchSections(params) {
    const qs = new URLSearchParams(params).toString();
    return fetch(`/admin/api/sections?${qs}`)
      .then(r => r.json())
      .then(json => {
        sectionEl.innerHTML = '<option value="">-- Select Section --</option>';
        json.sections.forEach(sec =>
          sectionEl.append(new Option(sec.section_name, sec.id))
        );
        return json;
      });
  }

  // close “×” button
  closeBtn.addEventListener('click', () => {
    editModal.style.display = 'none';
  });

  closeBtnn.addEventListener('click', () => {
    addModal.style.display = 'none';
  });

  // grade → strand/section logic (same as Add form)
  gradeEl.addEventListener('change', () => {
    const gradeNum = parseInt(gradeEl.selectedOptions[0].dataset.grade, 10);
    // reset everything
    strandEl.value = '';
    semEl.value    = '';
    sectionEl.innerHTML = '<option value="">-- Select Section --</option>';
    strandEl.disabled  = true;
    semEl.disabled     = true;
    sectionEl.disabled = true;

    if (gradeNum < 11) {
      // Junior High: only section
      sectionEl.disabled = false;
      fetchSections({ grade_level_id: gradeEl.value });
    } else {
      // Senior High: strand + semester first
      strandEl.disabled = false;
      semEl.disabled    = false;
    }
  });

  // when strand chosen, unlock & fetch its sections
  strandEl.addEventListener('change', () => {
    if (!strandEl.value) return;
    sectionEl.disabled = false;
    fetchSections({
      grade_level_id: gradeEl.value,
      strand_id:      strandEl.value
    });
  });

  // open & populate the edit modal
  function openEditModal(course) {
    editForm.action = `/admin/courses/${course.id}`;
    document.getElementById('edit_course_id').value = course.id;
    document.getElementById('edit_name').value      = course.name;
    document.getElementById('edit_code').value      = course.code || '';
    document.getElementById('edit_subject_id').value= course.subject_id;
    document.getElementById('edit_room').value      = course.room || '';

    // trigger grade change logic
    gradeEl.value = course.grade_level_id;
    gradeEl.dispatchEvent(new Event('change'));

    const gradeNum = parseInt(gradeEl.selectedOptions[0].dataset.grade, 10);
    if (gradeNum < 11) {
      sectionEl.disabled = false;
      fetchSections({ grade_level_id: gradeEl.value })
        .then(() => sectionEl.value = course.section_id);
    } else {
      strandEl.value = course.strand_id || '';
      semEl.value    = course.semester   || '';
      strandEl.dispatchEvent(new Event('change'));
      fetchSections({
        grade_level_id: course.grade_level_id,
        strand_id:      course.strand_id
      }).then(() => sectionEl.value = course.section_id);
    }

    editModal.style.display = 'flex';
  }

  // wire up each “Edit” button
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const course = JSON.parse(btn.dataset.course);
      openEditModal(course);
    });
  });

});
