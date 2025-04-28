document.getElementById('addCourseForm').addEventListener('submit', () => {
  document.getElementById('semester').disabled = false;
  document.getElementById('strand').disabled = false;
  document.getElementById('section').disabled = false;
});

document.querySelector('.add-student-btn').addEventListener('click', function () {
    document.getElementById('addCourseModal').style.display = 'block';
});

function closeModal() {
  document.getElementById('addCourseModal').style.display = 'none';
}

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
  fetch(`/api/sections?${qs}`)
    .then(res => res.json())
    .then(data => {
      section.innerHTML = '<option value="">-- Select Section --</option>';
      data.sections.forEach(sec => {
        section.append(new Option(sec.section_name, sec.id));
      });
    })
    .catch(console.error);
}

document.getElementById('instructor-search').addEventListener('keyup', function () {
  const search = this.value.toLowerCase();
  const rows = document.querySelectorAll('#courseTable tr');

  rows.forEach(row => {
      const rowText = row.innerText.toLowerCase();
      row.style.display = rowText.includes(search) ? '' : 'none';
  });
});

function openEditModal(course) {
  document.getElementById('editCourseModal').style.display = 'block';

  // Populate values
  document.getElementById('edit_name').value = course.name;
  document.getElementById('edit_code').value = course.code || '';
  document.getElementById('edit_subject_id').value = course.subject_id;
  document.getElementById('edit_grade').value = course.grade_level_id;
  document.getElementById('edit_strand').value = course.strand_id || '';
  document.getElementById('edit_section').value = course.section_name || '';
  document.getElementById('edit_semester').value = course.semester || '';
  document.getElementById('edit_room').value = course.room || '';

  // Set form action
  document.getElementById('editCourseForm').action = `/admin/courses/${course.id}`;
}

function closeEditModal() {
  document.getElementById('editCourseModal').style.display = 'none';
}

