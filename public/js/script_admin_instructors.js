/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
document.addEventListener("DOMContentLoaded", function () {
  const addStudentBtn = document.querySelector(".add-instructor-btn");
  const overlay = document.querySelector(".instructor-overlay");
  const addStudentForm = document.querySelector(".add-student-form");
  const usernameInput = document.getElementById("username");
  const addBtn       = document.querySelector('.add-instructor-btn');
  const addOverlay   = document.getElementById('add-instructor-overlay');
  const cancelAdd    = document.getElementById('cancel-add-instructor');

  if (addBtn) {
    addBtn.addEventListener('click', () => {
      addOverlay.style.display = 'flex';
    });
  }
  
  if (cancelAdd) {
    cancelAdd.addEventListener('click', () => {
      addOverlay.style.display = 'none';
    });
  }
  
  if (addOverlay) {
    addOverlay.addEventListener('click', e => {
      if (e.target === addOverlay) {
        addOverlay.style.display = 'none';
      }
    });
  }

  // Assign Classes Modal
  const classBtn     = document.querySelector('.classes-btn');
  const assignOverlay = document.getElementById('assign-classes-overlay');
  const cancelAssign = document.getElementById('cancel-assign-classes');
  const nameDisplay  = document.getElementById('instructor-name-display');
  const assignedList = document.getElementById('assigned-classes-list');

  classBtn.addEventListener('click', handleClassesClick);
  
  // Initialize classes button as disabled
  if (classBtn) {
    classBtn.disabled = true;
    classBtn.style.opacity = '0.6';
    classBtn.style.cursor = 'not-allowed';
    classBtn.title = 'Please select an instructor first';
  }
  
  // Function to load available classes dynamically via AJAX
  async function loadAvailableClasses() {
    try {
      const response = await fetch('/admin/api/admin/available-classes', {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
      });
      
      if (!response.ok) {
        throw new Error('Failed to fetch classes');
      }
      
      const data = await response.json();
      
      if (data.success) {
        // Update the default subjects checkboxes section
        updateDefaultClassesSection(data.defaultClasses);
        
        // Update the "Other Classes" multi-select dropdown
        updateAllClassesDropdown(data.allClasses);
        
        console.log('Classes loaded successfully');
      }
    } catch (error) {
      console.error('Error loading available classes:', error);
      showNotification('Failed to load latest classes. Please refresh the page.', 'error');
    }
  }
  
  // Function to update the default classes checkboxes section
  function updateDefaultClassesSection(defaultClasses) {
    const gridContainer = document.querySelector('.default-subjects-grid');
    if (!gridContainer) return;
    
    gridContainer.innerHTML = '';
    
    if (defaultClasses.length === 0) {
      gridContainer.innerHTML = `
        <div style="grid-column: 1 / -1; padding: 24px; text-align: center; background: #fff3cd; border: 1px dashed #ffc107; border-radius: 8px; color: #856404;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 8px;">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <p style="margin: 0; font-weight: 500;">No classes available yet</p>
          <small>Accept a student to auto-create default classes, or add classes under Admin Dashboard.</small>
        </div>
      `;
      return;
    }
    
    defaultClasses.forEach(course => {
      const label = document.createElement('label');
      label.className = 'default-subject-option';
      label.style.cssText = 'display: flex; align-items: flex-start; gap: 12px; padding: 14px; border: 2px solid #e9ecef; border-radius: 8px; cursor: pointer; background: #f8f9fa; transition: all 0.2s;';
      label.onmouseover = function() {
        this.style.borderColor = '#7a222b';
        this.style.background = '#fff';
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 4px 12px rgba(122,34,43,0.1)';
      };
      label.onmouseout = function() {
        this.style.borderColor = '#e9ecef';
        this.style.background = '#f8f9fa';
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
      };
      
      const strandHtml = course.strand ? `
        <span style="background: #f0fdf4; color: #15803d; font-size: 12px; padding: 2px 8px; border-radius: 4px; font-weight: 500;">
          ${course.strand.name}
        </span>
      ` : '';
      
      label.innerHTML = `
        <input type="checkbox" name="class_ids[]" value="${course.id}" style="margin-top: 3px; width: 18px; height: 18px; cursor: pointer; accent-color: #7a222b;">
        <div style="flex: 1;">
          <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <strong style="color: #212529; font-size: 15px;">${course.subject.name}</strong>
          </div>
          <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;">
            <span style="background: #e7f1ff; color: #0066cc; font-size: 12px; padding: 2px 8px; border-radius: 4px; font-weight: 500;">
              ${course.section.section_name}
            </span>
            <span style="background: #fff4e6; color: #b45309; font-size: 12px; padding: 2px 8px; border-radius: 4px; font-weight: 500;">
              ${course.gradeLevel.name}
            </span>
            ${strandHtml}
          </div>
        </div>
      `;
      
      gridContainer.appendChild(label);
    });
  }
  
  // Function to update the "Other Classes" multi-select dropdown
  function updateAllClassesDropdown(allClasses) {
    const classSelect = document.getElementById('class_ids');
    if (!classSelect) return;
    
    // Store currently selected values
    const selectedValues = Array.from(classSelect.selectedOptions).map(opt => opt.value);
    
    // Clear and repopulate
    classSelect.innerHTML = '';
    
    allClasses.forEach(course => {
      const option = document.createElement('option');
      option.value = course.id;
      option.dataset.isDefault = course.subject.is_default ? 'true' : 'false';
      
      const prefix = course.subject.is_default ? '⭐ ' : '';
      const strandPart = course.strand ? ` / ${course.strand.name}` : '';
      option.textContent = `${prefix}${course.name} (${course.section.section_name} — ${course.subject.code} / ${course.gradeLevel.name}${strandPart})`;
      
      // Restore selection if it was previously selected
      if (selectedValues.includes(course.id.toString())) {
        option.selected = true;
      }
      
      classSelect.appendChild(option);
    });
  }
  
  async function handleClassesClick(e) {
    // Check if an instructor is selected
    if (!selectedInstructorRow) {
      showNotification('Please select an instructor first by clicking on a row in the table.', 'warning');
      return;
    }
    
    // Double-check button state
    if (classBtn.disabled) {
      showNotification('Please select an instructor first by clicking on a row in the table.', 'warning');
      return;
    }
  
    // pull the JSON payload off the saved row
    const payload = selectedInstructorRow.dataset.instructorClasses;
    const instructorClasses = JSON.parse(payload || '[]');
    console.log('Loaded instructorClasses:', instructorClasses);
  
    // now do exactly what you did before:
    const instrId  = selectedInstructorRow.dataset.instructorId;
    let fullname = selectedInstructorRow.dataset.fullname;
    
    // Load latest classes dynamically
    await loadAvailableClasses();
    
    console.log('Debug - Instructor data:', {
      instrId: instrId,
      fullname: fullname,
      firstName: selectedInstructorRow.dataset.firstName,
      middleName: selectedInstructorRow.dataset.middleName,
      lastName: selectedInstructorRow.dataset.lastName,
      suffix: selectedInstructorRow.dataset.suffix
    });
    
    // Fallback: construct full name from individual parts if data-fullname is empty
    if (!fullname || fullname.trim() === '') {
      const first = selectedInstructorRow.dataset.firstName || '';
      const middle = selectedInstructorRow.dataset.middleName || '';
      const last = selectedInstructorRow.dataset.lastName || '';
      const suffix = selectedInstructorRow.dataset.suffix || '';
      fullname = [first, middle, last, suffix].filter(part => part && part.trim() !== '').join(' ');
      console.log('Debug - Constructed fullname:', fullname);
    }
  
    // Get modal elements
    const idInput = document.getElementById('modal-instructor-id');
    const nameDisplay = document.getElementById('instructor-name-display');
    const classSelect = document.getElementById('class_ids');
    const form = document.getElementById('assign-classes-form');
    const assignOverlay = document.getElementById('assign-classes-overlay');
  
    // fill out modal
    if (idInput) idInput.value = instrId;
    if (nameDisplay) nameDisplay.textContent = fullname || 'Unknown Instructor';
  
    // new logic for displaying assigned classes
    const assignedList = document.querySelector('#assigned-classes-list');
    if (assignedList) {
    assignedList.innerHTML = '';  // Clear the existing content

    if (instructorClasses && instructorClasses.length > 0) {
        instructorClasses.forEach((classData) => {
        const li = document.createElement('li');
          li.style.marginBottom = '8px';
          li.style.padding = '8px';
          li.style.backgroundColor = '#f8f9fa';
          li.style.borderRadius = '4px';
          li.style.borderLeft = '4px solid #7a222b';
          
          // Create a more detailed display
          const classInfo = classData.class;
          if (classInfo) {
            li.innerHTML = `
              <div style="font-weight: bold; color: #7a222b;">${classInfo.name || 'Unknown Class'}</div>
              <div style="font-size: 12px; color: #666; margin-top: 2px;">
                ${classInfo.section_name || 'N/A'} — ${classInfo.code || 'N/A'} / ${classInfo.grade_level || 'Unknown Grade'}
                ${classInfo.strand ? ' / ' + classInfo.strand : ''}
              </div>
            `;
          } else {
            li.textContent = `Class ID ${classData.class_id}`;
          }
        assignedList.appendChild(li);
      });
    } else {
        assignedList.innerHTML = '<li style="color: #666; font-style: italic;">No classes assigned yet.</li>';
      }
    }
  
    // pre-select those options (existing logic)
    if (classSelect) {
    const existing = (selectedInstructorRow.dataset.currentClasses || '')
                        .split(',')
                        .filter(Boolean)
                        .map(n => n.trim());
    Array.from(classSelect.options).forEach(opt => {
      opt.selected = existing.includes(opt.value);
    });
    }
  
    // update the form's action
    if (form) form.action = `/admin/instructors/${instrId}/classes`;
  
    // show the overlay
    if (assignOverlay) assignOverlay.style.display = 'flex';
}

  // Handle "Select All Core Subjects" button
  const selectAllDefaultBtn = document.getElementById('select-all-default');
  if (selectAllDefaultBtn) {
    selectAllDefaultBtn.addEventListener('click', function() {
      const defaultCheckboxes = document.querySelectorAll('.default-subject-option input[type="checkbox"]');
      const allSelected = Array.from(defaultCheckboxes).every(cb => cb.checked);
      
      defaultCheckboxes.forEach(checkbox => {
        checkbox.checked = !allSelected;
        updateSubjectOptionStyle(checkbox);
      });
      
      // Update the select all button text
      this.textContent = allSelected ? 'Select All Core Subjects' : 'Deselect All Core Subjects';
      
      // Also update the multi-select dropdown to reflect the changes
      updateMultiSelectFromCheckboxes();
    });
  }

  // Add event listeners to individual checkboxes for visual feedback
  document.addEventListener('change', function(e) {
    if (e.target.matches('.default-subject-option input[type="checkbox"]')) {
      updateSubjectOptionStyle(e.target);
      updateMultiSelectFromCheckboxes();
    }
  });

  // Function to update visual style of subject options
  function updateSubjectOptionStyle(checkbox) {
    const option = checkbox.closest('.default-subject-option');
    if (checkbox.checked) {
      option.classList.add('selected');
    } else {
      option.classList.remove('selected');
    }
  }

  // Function to sync checkboxes with multi-select dropdown
  function updateMultiSelectFromCheckboxes() {
    const checkboxes = document.querySelectorAll('.default-subject-option input[type="checkbox"]:checked');
    const multiSelect = document.getElementById('class_ids');
    
    // Clear existing selections
    Array.from(multiSelect.options).forEach(option => {
      option.selected = false;
    });
    
    // Select options based on checked checkboxes
    checkboxes.forEach(checkbox => {
      const option = multiSelect.querySelector(`option[value="${checkbox.value}"]`);
      if (option) {
        option.selected = true;
      }
    });
  }

  // Add event listeners to multi-select to sync with checkboxes
  const multiSelect = document.getElementById('class_ids');
  if (multiSelect) {
    multiSelect.addEventListener('change', function() {
      updateCheckboxesFromMultiSelect();
    });
  }

  // Function to sync multi-select dropdown with checkboxes
  function updateCheckboxesFromMultiSelect() {
    const multiSelect = document.getElementById('class_ids');
      const checkboxes = document.querySelectorAll('.default-subject-option input[type="checkbox"]');
      
      checkboxes.forEach(checkbox => {
      const option = multiSelect.querySelector(`option[value="${checkbox.value}"]`);
      if (option) {
        checkbox.checked = option.selected;
        updateSubjectOptionStyle(checkbox);
      }
    });
  }

  // Add close button functionality
  const cancelAssignBtn = document.getElementById('cancel-assign-classes');
  if (cancelAssignBtn) {
    cancelAssignBtn.addEventListener('click', function() {
      assignOverlay.style.display = 'none';
    });
  }

  // Close modal when clicking outside
  if (assignOverlay) {
    assignOverlay.addEventListener('click', function(e) {
      if (e.target === assignOverlay) {
        assignOverlay.style.display = 'none';
      }
    });
  }

  // Form validation
  const assignForm = document.getElementById('assign-classes-form');
  if (assignForm) {
    assignForm.addEventListener('submit', function(e) {
      const selectedClasses = document.querySelectorAll('input[name="class_ids[]"]:checked, select[name="class_ids[]"] option:selected');
      
      if (selectedClasses.length === 0) {
        e.preventDefault();
        showNotification('Please select at least one class to assign.', 'warning');
        return false;
      }
      
      // Show loading state
      const submitBtn = assignForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Assigning...';
      submitBtn.disabled = true;
      
      // Re-enable button after 3 seconds in case of error
      setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }, 3000);
    });
  }

  // Auto-hide notifications
  document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('assign-success-alert');
    const errorAlert = document.getElementById('assign-error-alert');
    
    if (successAlert) {
      setTimeout(function() {
        closeAlert('assign-success-alert');
      }, 5000);
    }
    
    if (errorAlert) {
      setTimeout(function() {
        closeAlert('assign-error-alert');
      }, 7000);
    }
  });

  // Function to close alert notification
  function closeAlert(alertId) {
    const alert = document.getElementById(alertId);
    if (alert) {
      alert.style.animation = 'slideOutRight 0.3s ease-in';
      setTimeout(function() {
        alert.remove();
      }, 300);
    }
  }

  // Professional notification system
  function showNotification(message, type = 'info', duration = 5000) {
    const container = document.getElementById('notification-container');
    if (!container) return;

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    const messageSpan = document.createElement('span');
    messageSpan.textContent = message;
    
    const closeBtn = document.createElement('button');
    closeBtn.className = 'notification-close';
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = () => removeNotification(notification);
    
    notification.appendChild(messageSpan);
    notification.appendChild(closeBtn);
    container.appendChild(notification);

    // Auto-remove after duration
    if (duration > 0) {
      setTimeout(() => {
        removeNotification(notification);
      }, duration);
    }
  }

  function removeNotification(notification) {
    if (notification && notification.parentNode) {
      notification.style.animation = 'slideOutRight 0.3s ease-in';
      setTimeout(() => {
        if (notification.parentNode) {
          notification.parentNode.removeChild(notification);
        }
      }, 300);
    }
  }

  // Function to refresh assigned classes display
  function refreshAssignedClasses() {
    if (!selectedInstructorRow) return;
    
    const payload = selectedInstructorRow.dataset.instructorClasses;
    const instructorClasses = JSON.parse(payload || '[]');
    const assignedList = document.querySelector('#assigned-classes-list');
    
    if (assignedList) {
      assignedList.innerHTML = '';
      
      if (instructorClasses && instructorClasses.length > 0) {
        instructorClasses.forEach((classData) => {
          const li = document.createElement('li');
          li.style.marginBottom = '8px';
          li.style.padding = '8px';
          li.style.backgroundColor = '#f8f9fa';
          li.style.borderRadius = '4px';
          li.style.borderLeft = '4px solid #7a222b';
          
          const classInfo = classData.class;
          if (classInfo) {
            li.innerHTML = `
              <div style="font-weight: bold; color: #7a222b;">${classInfo.name || 'Unknown Class'}</div>
              <div style="font-size: 12px; color: #666; margin-top: 2px;">
                ${classInfo.section_name || 'N/A'} — ${classInfo.code || 'N/A'} / ${classInfo.grade_level || 'Unknown Grade'}
                ${classInfo.strand ? ' / ' + classInfo.strand : ''}
              </div>
            `;
          } else {
            li.textContent = `Class ID ${classData.class_id}`;
          }
          assignedList.appendChild(li);
        });
      } else {
        assignedList.innerHTML = '<li style="color: #666; font-style: italic;">No classes assigned yet.</li>';
      }
    }
  }

  // Function to handle successful class assignment
  function handleAssignmentSuccess() {
    showNotification('Classes assigned successfully!', 'success');
    
    // Close the modal
    const assignOverlay = document.getElementById('assign-classes-overlay');
    if (assignOverlay) {
      assignOverlay.style.display = 'none';
    }
    
    // Refresh the assigned classes display
    setTimeout(() => {
      refreshAssignedClasses();
    }, 500);
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
 

  // Note: Classes button click is handled by handleClassesClick function above
  // Note: Modal overlay functionality is handled in the main assignOverlay section above

  // Note: Classes form functionality is handled by handleClassesClick function above

// assume selectedInstructorRow is being set in populateProfile()

const scheduleBtns    = document.querySelectorAll('.schedule-btn');
const scheduleOverlay = document.getElementById('schedules-overlay');
const cancelSchedule  = document.getElementById('cancel-schedule');
const scheduleSelect  = document.getElementById('schedule-instructor-class-id');
const instructorName  = document.getElementById('schedule-instructor-name');
const existingUL      = document.querySelector('#existing-schedules-list ul');

  // wire up the buttons
  scheduleBtns.forEach(btn => btn.addEventListener('click', handleSchedulesClick));
  cancelSchedule.addEventListener('click', ()=> {
    resetScheduleForm();
    scheduleOverlay.classList.remove('show');
  });
  scheduleOverlay.addEventListener('click', e => {
    if (e.target === scheduleOverlay) {
      resetScheduleForm();
      scheduleOverlay.classList.remove('show');
    }
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
    
    // Check if instructor has any classes assigned
    if (payload.length === 0) {
      // No classes assigned - show message and disable form
      const opt = document.createElement('option');
      opt.value = '';
      opt.textContent = 'No classes assigned to this instructor';
      opt.disabled = true;
      scheduleSelect.appendChild(opt);
      
      // Clear existing schedules
      const ul = document.querySelector('#existing-schedules-list ul');
      ul.innerHTML = '<li style="color: #666; font-style: italic;">No classes assigned. Please assign classes first using the "Classes" button.</li>';
      
      // Disable the form
      const form = document.getElementById('schedule-form');
      const submitBtn = form.querySelector('button[type="submit"]');
      const inputs = form.querySelectorAll('input, select');
      
      inputs.forEach(input => input.disabled = true);
      submitBtn.disabled = true;
      submitBtn.textContent = 'Assign Classes First';
      
    } else {
      // Classes are assigned - populate dropdown normally
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
      
      // Enable the form
      const form = document.getElementById('schedule-form');
      const submitBtn = form.querySelector('button[type="submit"]');
      const inputs = form.querySelectorAll('input, select');
      
      inputs.forEach(input => input.disabled = false);
      submitBtn.disabled = false;
      submitBtn.textContent = 'Save Schedule';
      
      // Render schedules for first class
      if (payload.length > 0) {
        renderSchedulesForPivot(payload[0].pivot_id, payload);
        scheduleSelect.onchange = e => renderSchedulesForPivot(e.target.value, payload);
      }
    }
  
    // 5) show modal
    scheduleOverlay.classList.add('show');
  }
  
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  function resetScheduleForm() {
    // Reset form inputs
    const form = document.getElementById('schedule-form');
    if (form) {
      form.reset();
      
      // Reset all form elements to enabled state
      const inputs = form.querySelectorAll('input, select');
      const submitBtn = form.querySelector('button[type="submit"]');
      
      inputs.forEach(input => input.disabled = false);
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save Schedule';
      }
    }
    
    // Clear the class dropdown
    const scheduleSelect = document.getElementById('schedule-instructor-class-id');
    if (scheduleSelect) {
      scheduleSelect.innerHTML = '';
    }
    
    // Clear schedules list
    const ul = document.querySelector('#existing-schedules-list ul');
    if (ul) {
      ul.innerHTML = '';
    }
    
    // Reset instructor name
    const instructorName = document.getElementById('schedule-instructor-name');
    if (instructorName) {
      instructorName.textContent = 'N/A';
    }
  }

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
                  const fullName = instr.display_name;
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
      
      // Enable classes button and add visual feedback
      const classesBtn = document.querySelector('.classes-btn');
      if (classesBtn) {
        classesBtn.disabled = false;
        classesBtn.style.opacity = '1';
        classesBtn.style.cursor = 'pointer';
        classesBtn.title = 'Click to assign classes to ' + fullname;
      }

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
const cancelEditBtn2 = document.getElementById('cancel-edit-instructor-btn');
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
    document.getElementById('edit_advisory_section_id').value = row.dataset.advisorySectionId || '';

    editForm.action = window.updateInstructorUrl.replace('__ID__', id);
    console.log("🔧 setting form.action →", editForm.action);
    
    editOverlay.style.display = 'flex';
  });

// cancel button closes overlay
cancelEditBtn.addEventListener('click', () => {
  editOverlay.style.display = 'none';
});

// cancel button in form also closes overlay
cancelEditBtn2.addEventListener('click', () => {
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
  const assignOverlay = document.getElementById('assign-classes-overlay');
  if (assignOverlay) {
    assignOverlay.style.display = 'flex';
  }
}

function triggerScheduleModal() {
  const scheduleOverlay = document.getElementById('schedules-overlay');
  if (scheduleOverlay) {
    handleSchedulesClick();
  }
}

// Global functions for the new modal
function triggerAddInstructorModal() {
  const modal = document.getElementById('add-instructor-overlay');
  if (modal) {
    modal.style.display = 'flex';
  }
}

function closeInstructorModal() {
  const modal = document.getElementById('add-instructor-overlay');
  if (modal) {
    modal.style.display = 'none';
    // Reset form
    const form = document.getElementById('add-instructor-form');
    if (form) {
      form.reset();
      // Clear any error messages
      clearFormErrors();
    }
  }
}

// Form validation and error handling
function validateInstructorForm() {
  const form = document.getElementById('add-instructor-form');
  if (!form) return false;

  let isValid = true;
  const errors = [];

  // Required fields validation
  const requiredFields = [
    { name: 'first_name', label: 'First Name' },
    { name: 'last_name', label: 'Last Name' },
    { name: 'email', label: 'Email Address' },
    { name: 'gender', label: 'Gender' },
    { name: 'date_of_birth', label: 'Date of Birth' },
    { name: 'contact_number', label: 'Contact Number' },
    { name: 'address', label: 'Address' },
    { name: 'job_start_date', label: 'Job Start Date' }
  ];

  // Clear previous errors
  clearFormErrors();

  // Validate required fields
  requiredFields.forEach(field => {
    const input = form.querySelector(`[name="${field.name}"]`);
    if (!input) return;

    if (field.name === 'gender') {
      const genderInputs = form.querySelectorAll('input[name="gender"]');
      const isGenderSelected = Array.from(genderInputs).some(input => input.checked);
      if (!isGenderSelected) {
        showFieldError(field.name, `${field.label} is required.`);
        isValid = false;
      }
    } else {
      if (!input.value.trim()) {
        showFieldError(field.name, `${field.label} is required.`);
        isValid = false;
      }
    }
  });

  // Email validation
  const emailInput = form.querySelector('[name="email"]');
  if (emailInput && emailInput.value) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
      showFieldError('email', 'Please enter a valid email address.');
      isValid = false;
    }
  }

  // Date validation
  const dobInput = form.querySelector('[name="date_of_birth"]');
  if (dobInput && dobInput.value) {
    const dob = new Date(dobInput.value);
    const today = new Date();
    const age = today.getFullYear() - dob.getFullYear();
    if (age < 18) {
      showFieldError('date_of_birth', 'Instructor must be at least 18 years old.');
      isValid = false;
    }
  }

  const jobStartInput = form.querySelector('[name="job_start_date"]');
  if (jobStartInput && jobStartInput.value) {
    const jobStart = new Date(jobStartInput.value);
    const today = new Date();
    if (jobStart < today) {
      showFieldError('job_start_date', 'Job start date cannot be in the past.');
      isValid = false;
    }
  }

  // Contact number validation
  const contactInput = form.querySelector('[name="contact_number"]');
  if (contactInput && contactInput.value) {
    const contactRegex = /^[0-9\-\+\(\)\s]+$/;
    if (!contactRegex.test(contactInput.value)) {
      showFieldError('contact_number', 'Contact number contains invalid characters.');
      isValid = false;
    }
  }

  return isValid;
}

function showFieldError(fieldName, message) {
  const input = document.querySelector(`[name="${fieldName}"]`);
  if (!input) return;

  // Remove existing error message
  const existingError = input.parentNode.querySelector('.error-message');
  if (existingError) {
    existingError.remove();
  }

  // Add error class to input
  input.classList.add('error');

  // Create error message element
  const errorDiv = document.createElement('div');
  errorDiv.className = 'error-message';
  errorDiv.textContent = message;

  // Insert error message after the input
  input.parentNode.insertBefore(errorDiv, input.nextSibling);
}

function clearFormErrors() {
  const form = document.getElementById('add-instructor-form');
  if (!form) return;

  // Remove all error messages
  const errorMessages = form.querySelectorAll('.error-message');
  errorMessages.forEach(error => error.remove());

  // Remove error classes from inputs
  const errorInputs = form.querySelectorAll('.error');
  errorInputs.forEach(input => input.classList.remove('error'));
}

// Add form submission handler
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('add-instructor-form');
  if (form) {
    form.addEventListener('submit', function(e) {
      if (!validateInstructorForm()) {
        e.preventDefault();
        showNotification('Please correct the errors below and try again.', 'error');
      }
    });
  }
});
