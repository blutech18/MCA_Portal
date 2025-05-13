document.addEventListener("DOMContentLoaded", function () {
  const addStudentBtn = document.querySelector(".add-instructor-btn");
  const overlay = document.querySelector(".instructor-overlay");
  const addStudentForm = document.querySelector(".add-student-form");
  const usernameInput = document.getElementById("username");
  const addBtn       = document.querySelector('.add-instructor-btn');
  const addOverlay   = document.getElementById('add-instructor-overlay');
  const cancelAdd    = document.getElementById('cancel-add-instructor');

  addBtn.addEventListener('click', () => addOverlay.classList.add('show'));
  cancelAdd.addEventListener('click', () => addOverlay.classList.remove('show'));
  addOverlay.addEventListener('click', e => {
    if (e.target === addOverlay) addOverlay.classList.remove('show');
  });

  // Assign Classes Modal
  const classBtn     = document.querySelector('.classes-btn');
  const assignOverlay = document.getElementById('assign-classes-overlay');
  const cancelAssign = document.getElementById('cancel-assign-classes');
  const nameDisplay  = document.getElementById('instructor-name-display');
  const assignedList = document.getElementById('assigned-classes-list');

  classBtn.addEventListener('click', handleClassesClick);
  
  function handleClassesClick(e) {
    // make sure you’ve clicked a row first
    if (!selectedInstructorRow) {
      return alert('Please click an instructor row first.');
    }
  
    // pull the JSON payload off the saved row
    const payload = selectedInstructorRow.dataset.instructorClasses;
    const instructorClasses = JSON.parse(payload || '[]');
    console.log('Loaded instructorClasses:', instructorClasses);
  
    // now do exactly what you did before:
    const instrId  = selectedInstructorRow.dataset.instructorId;
    const fullname = selectedInstructorRow.dataset.fullname;
  
    // fill out modal
    idInput.value         = instrId;
    nameDisplay.textContent = fullname;
  
    // new logic for displaying assigned classes
    const assignedList = document.querySelector('#assigned-classes-list');
    assignedList.innerHTML = '';  // Clear the existing content

    if (instructorClasses && instructorClasses.length > 0) {
      instructorClasses.forEach(({ class_id }) => {
        const classOption = classSelect.querySelector(`option[value="${class_id}"]`);
        const li = document.createElement('li');
        li.textContent = classOption ? classOption.textContent : `Class ID ${class_id}`;
        assignedList.appendChild(li);
      });
    } else {
      assignedList.innerHTML = '<li>None assigned.</li>';
    }
  
    // pre-select those options (existing logic)
    const existing = (selectedInstructorRow.dataset.currentClasses || '')
                        .split(',')
                        .filter(Boolean)
                        .map(n => n.trim());
    Array.from(classSelect.options).forEach(opt => {
      opt.selected = existing.includes(opt.value);
    });
  
    // update the form’s action
    form.action = `/admin/instructors/${instrId}/classes`;
  
    // show the overlay
    assignOverlay.classList.add('show');
}

  const messageBox = document.getElementById('username-feedback');

  if(usernameInput){
    usernameInput.addEventListener('blur', function () {
      const username = this.value.trim();

      if (!messageBox) return;

      if (username === '') {
          messageBox.innerText = '';
          return;
      }

      messageBox.className = ""; // reset
      messageBox.classList.add("feedback-loading");

      fetch('/check-username/' + encodeURIComponent(username))
          .then(response => response.json())
          .then(data => {
              if (!data.valid) {
                  messageBox.innerText = 'No such user.';
                  messageBox.style.color = 'red';
                } else if (data.has_instructor) {
                  messageBox.innerText = 'That user already has an instructor record.';
                  messageBox.style.color = 'orange';
                } else {
                  messageBox.innerText = 'Good—username available.';
                  messageBox.style.color = 'green';
              }
          })
          .catch(error => {
              console.error('Error fetching data:', error);
              messageBox.innerText = 'Error checking username.';
              messageBox.style.color = 'red';
          });
    });
  }
 

  const overlayy = document.getElementById("assign-classes-overlay");
  const form = document.getElementById("assign-classes-form");
  const classSelect = document.getElementById("class_ids");
  const idInput = document.getElementById("modal-instructor-id");
  const cancelBtn = document.getElementById("cancel-assign-classes");
  
  // Click "Classes" in the profile box
  document.querySelector(".classes-btn").addEventListener("click", () => {
      // Select row logic is handled in handleClassesClick
      const instrId = selectedInstructorRow.dataset.instructorId;
      console.log(instrId); // To see if instrId has the correct value
      idInput.value = instrId;
  
      const existing = (selectedInstructorRow.dataset.currentClasses || '')
          .split(',').filter(Boolean).map(n => parseInt(n, 10));
      
      // Set form action
      form.action = `/admin/instructors/${instrId}/classes`;
  
      // Set hidden input
      idInput.value = instrId;
  
      // Pre-select class options
      Array.from(classSelect.options).forEach(opt => {
          opt.selected = existing.includes(+opt.value);
      });
  
      // Show the modal/overlay
      overlayy.style.display = "flex";  // Correct way to show modal overlay
  });
  
  
  // hide when clicking the semi-transparent background
  overlayy.addEventListener("click", e => {
    if (e.target === overlayy) overlayy.style.display = "none";
  });
  // hide on “Cancel”
  cancelBtn.addEventListener("click", () => overlayy.style.display = "none");

  /*---classes Form enhancement */
  function showAssignModal(instructorId, fullName, assignedClasses = []) {
      document.getElementById('modal-instructor-id').value = instructorId;
      document.getElementById('instructor-name-display').innerText = fullName;
    
      const assignedList = document.getElementById('assigned-classes-list');
      assignedList.innerHTML = '';
    
      if (assignedClasses.length > 0) {
        assignedClasses.forEach(cls => {
          const li = document.createElement('li');
          li.textContent = cls;
          assignedList.appendChild(li);
        });
      } else {
        assignedList.innerHTML = '<li>None assigned.</li>';
      }
    
      document.getElementById('assign-classes-overlay').style.display = 'flex';
  }
    
  document.getElementById('cancel-assign-classes').addEventListener('click', function () {
      document.getElementById('assign-classes-overlay').style.display = 'none';
  });

// assume selectedInstructorRow is being set in populateProfile()

const scheduleBtns    = document.querySelectorAll('.schedule-btn');
const scheduleOverlay = document.getElementById('schedules-overlay');
const cancelSchedule  = document.getElementById('cancel-schedule');
const scheduleSelect  = document.getElementById('schedule-instructor-class-id');
const instructorName  = document.getElementById('schedule-instructor-name');
const existingUL      = document.querySelector('#existing-schedules-list ul');

  // wire up the buttons
  scheduleBtns.forEach(btn => btn.addEventListener('click', handleSchedulesClick));
  cancelSchedule.addEventListener('click', ()=> scheduleOverlay.classList.remove('show'));
  scheduleOverlay.addEventListener('click', e => {
    if (e.target === scheduleOverlay) scheduleOverlay.classList.remove('show');
  });

  function handleSchedulesClick() {
    if (!selectedInstructorRow) return alert('Please click an instructor row first.');
  
    // pull the JSON payload off the <tr>
    const payload = JSON.parse(selectedInstructorRow.dataset.instructorClasses || '[]');
    const fullname = selectedInstructorRow.dataset.fullname;
  
    // 1) fill instructor name
    document.getElementById('schedule-instructor-name').textContent = fullname;
  
    // 2) rebuild the class-pivot <select>
    const scheduleSelect = document.getElementById('schedule-instructor-class-id');
    scheduleSelect.innerHTML = '';
    payload.forEach(item => {
      const opt = document.createElement('option');
      opt.value = item.pivot_id;
      opt.textContent = [
        item.class.name,
        `(${item.class.code})`,
        item.class.grade_level ? `Grade ${item.class.grade_level}` : null,
        item.class.strand      ? `/ ${item.class.strand}`      : null,
        `— Section ${item.class.section_name}`
      ].filter(Boolean).join(' ');
      scheduleSelect.appendChild(opt);
    });
  
    renderSchedulesForPivot(payload[0].pivot_id, payload);
    scheduleSelect.onchange = e => renderSchedulesForPivot(e.target.value, payload);
  
    // 5) show modal
    scheduleOverlay.classList.add('show');
  }
  
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  function renderSchedulesForPivot(pivotId, payload) {
    const pivot = payload.find(x => x.pivot_id == pivotId);
    const scheds = pivot?.schedules || [];
    const ul     = document.querySelector('#existing-schedules-list ul');
    ul.innerHTML = '';

    if (scheds.length) {
      scheds.forEach(s => {
        console.dir(s);
        console.log('─ keys:', Object.keys(s).join(', '));
        const schedId = s.id;
        console.log('🗑 will delete schedule id =', schedId);
        const li = document.createElement('li');

        // schedule text
        const txt = document.createElement('span');
        txt.textContent = `${s.day_of_week} ${s.start_time}–${s.end_time} @ ${s.room}`;
        console.log('schedule object:', s);
        li.appendChild(txt);

        // delete button
        const del = document.createElement('button');
        del.textContent = 'Delete';
        del.classList.add('btn','delete-schedule-btn');
        del.style.marginLeft = '1em';
        del.addEventListener('click', () => {
          if (!confirm('Delete this schedule?')) return;
          const schedId = s.schedule_id;    // no longer null!
          const url     = window.deleteScheduleUrl.replace('##ID##', schedId);
          fetch(url, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Accept':       'application/json'
            }
          })
          .then(r => {
            if (!r.ok) throw new Error('Delete failed');
            pivot.schedules = pivot.schedules.filter(x => x.schedule_id !== schedId);
            renderSchedulesForPivot(pivotId, payload);
          })
          .catch(err => alert(err.message));
        });
        

        li.appendChild(del);
        ul.appendChild(li);
      });
    } else {
      ul.innerHTML = '<li>None added yet.</li>';
    }
  }

  /*--- Search functionality --- */
  document.getElementById('instructor-search').addEventListener('input', function () {
      const query = this.value;

      fetch(`/admin/instructors/search?query=${encodeURIComponent(query)}`)
          .then(res => res.json())
          .then(data => {
              const tbody = document.getElementById('instructor-body');
              tbody.innerHTML = '';

              if (data.length === 0) {
                  tbody.innerHTML = '<tr><td colspan="6">No instructors found.</td></tr>';
                  return;
              }

              data.forEach(instr => {
                  const fullName = `${instr.first_name} ${instr.middle_name ?? ''} ${instr.last_name}${instr.suffix ? ', ' + instr.suffix : ''}`;
                  const row = `
                      <tr data-fullname="${fullName}" data-email="${instr.email}" data-status="${instr.status}" 
                          data-hiredate="${instr.job_start_date}" data-dob="${instr.dob}" 
                          data-address="${instr.address}" data-phone="${instr.phone}" data-gender="${instr.gender}"
                          data-picture="${instr.picture}">
                          <td>${instr.instructor_number}</td>
                          <td>${fullName}</td>
                          <td>${instr.email}</td>
                          <td>${instr.status.charAt(0).toUpperCase() + instr.status.slice(1)}</td>
                          <td>${instr.job_start_date}</td>
                          
                      </tr>
                  `;
                  tbody.insertAdjacentHTML('beforeend', row);
              });
          });
  });

  // Use event delegation for the row click event
  document.getElementById('instructor-body').addEventListener('click', function (event) {
    const row = event.target.closest('tr');
    if (row) {
        selectedInstructorRow = row; 
        console.log('Selected Instructor Row:', selectedInstructorRow);
        populateProfile(row); 
    }
  });

  /*--- Profile box functionality --- */
  let selectedInstructorRow = null;

  function populateProfile(row) {

    const instructorId = row.dataset.instructorId;
    const fullname = row.dataset.fullname;
      const allRows = document.querySelectorAll('#instructor-table tbody tr');
      allRows.forEach(r => r.classList.remove('active'));
  
      // Mark current row as active
      row.classList.add('active');
      selectedInstructorRow = row;

      const first  = row.dataset.firstName  || '';
      const middle = row.dataset.middleName || '';
      const last   = row.dataset.lastName   || '';
      const suffix = row.dataset.suffix     || '';
    
      // Build the full name
      let full = first;
      if (middle) full += ' ' + middle;
      full += ' ' + last;
      if (suffix) full += ', ' + suffix;
    
  
      // Populate profile fields
      document.getElementById("profile-fullname").textContent = full;
      document.getElementById("profile-address").textContent = row.dataset.address || 'N/A';
      document.getElementById("profile-status").textContent = row.dataset.status || 'N/A';
      document.getElementById("profile-email").textContent = row.dataset.email || 'N/A';
      document.getElementById("profile-dob").textContent = row.dataset.dob || 'N/A';
      document.getElementById("profile-hiredate").textContent = row.dataset.hiredate || 'N/A';
      document.getElementById("profile-phone").textContent = row.dataset.phone || 'N/A';
      document.getElementById("profile-gender").textContent = row.dataset.gender || 'N/A';
      
  }
  
  /*--- Edit button functionality --- */
// open/close handlers for edit overlay
const editOverlay    = document.getElementById('editInstructorOverlay');
const editForm       = document.getElementById('editInstructorForm');
const cancelEditBtn  = document.getElementById('cancel-edit-instructor');
console.log('rtwet',editForm.action);
// when someone clicks “Edit” in the profile box:
document.querySelector('.profile-actions .edit-btn')
  .addEventListener('click', () => {
    if (!selectedInstructorRow) {
      return alert('Please select an instructor row first.');
    }

    // pull all of our data-* attributes off the row
    const row = selectedInstructorRow;
    const id    = row.dataset.instructorId;
    const full  = row.dataset.fullname;
    // …and the rest

    document.getElementById('edit_instructor_id').value     = id;
     document.getElementById('edit_first_name').value      = row.dataset.firstName    || '';
    document.getElementById('edit_middle_name').value     = row.dataset.middleName   || '';
    document.getElementById('edit_last_name').value       = row.dataset.lastName     || '';
    document.getElementById('edit_suffix').value          = row.dataset.suffix       || '';
    document.getElementById('edit_email').value            = row.dataset.email;
    document.getElementById('edit_gender').value           = row.dataset.gender.toLowerCase();
    document.getElementById('edit_dob').value              = row.dataset.dob;
    document.getElementById('edit_contact').value          = row.dataset.phone;
    document.getElementById('edit_address').value          = row.dataset.address;
    document.getElementById('edit_hiredate').value         = row.dataset.hiredate;
    document.getElementById('edit_status').value           = row.dataset.status.toLowerCase();

    editForm.action = window.updateInstructorUrl.replace('__ID__', id);
    console.log("🔧 setting form.action →", editForm.action);
    
    editOverlay.style.display = 'flex';
  });

// cancel button closes overlay
cancelEditBtn.addEventListener('click', () => {
  editOverlay.style.display = 'none';
});

  /*--- Delete button functionality --- */
  document.querySelectorAll(".delete-btn").forEach(button => {
      button.addEventListener("click", function (event) {
          event.stopPropagation(); // Prevent the row click event from firing
          const instructorId = this.getAttribute("data-instructor-id");
          const confirmation = confirm("Are you sure you want to delete this instructor? This action cannot be undone.");
          if (confirmation) {
              window.location.href = `/admin/instructors/delete/${instructorId}`;
          }
      });
  });

  $(document).ready(function() {
    $('#class_ids').select2({
      placeholder: "Select classes",
      width: '100%'
    });
  });
  
});


function triggerAssignModal() {
  assignOverlay.classList.add('show'); // Show the modal, assuming `assignOverlay` is your modal.
}
