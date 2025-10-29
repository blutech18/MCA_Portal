/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */

// Global variables and functions that need to be accessible from HTML onchange handlers
let allCoreSubjects = []; // Store all core subjects for filtering
let selectedInstructorRow = null;

// Function to close alert notification - defined at global scope
window.closeAlert = function(alertId) {
  const alert = document.getElementById(alertId);
  if (alert) {
    alert.style.animation = 'slideOutRight 0.3s ease-in';
    setTimeout(function() {
      alert.remove();
    }, 300);
  }
}

// Professional notification system - defined at global scope
window.showNotification = function(message, type = 'info', duration = 5000) {
  const container = document.getElementById('notification-container');
  if (!container) return;

  const notification = document.createElement('div');
  notification.className = `notification notification-${type}`;
  
  const messageSpan = document.createElement('span');
  messageSpan.textContent = message;
  
  const closeBtn = document.createElement('button');
  closeBtn.className = 'notification-close';
  closeBtn.innerHTML = '&times;';
  closeBtn.onclick = () => window.removeNotification(notification);
  
  notification.appendChild(messageSpan);
  notification.appendChild(closeBtn);
  container.appendChild(notification);

  // Auto-remove after duration
  if (duration > 0) {
    setTimeout(() => {
      window.removeNotification(notification);
    }, duration);
  }
}

window.removeNotification = function(notification) {
  if (notification && notification.parentNode) {
    notification.style.animation = 'slideOutRight 0.3s ease-in';
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }
}

// Function to update the default classes checkboxes section
function updateDefaultClassesSection(defaultClasses) {
  const gridContainer = document.querySelector('.default-subjects-grid');
  if (!gridContainer) return;
  
  gridContainer.innerHTML = '';
  
  if (defaultClasses.length === 0) {
    gridContainer.innerHTML = `
      <div style="grid-column: 1 / -1; padding: 24px; text-align: center; background: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; color: #6c757d;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 8px;">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <p style="margin: 0; font-weight: 500;">Empty</p>
        <small>No classes match the selected filters. Try adjusting your filter criteria.</small>
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

// Function to filter core subjects
function filterCoreSubjects() {
  console.log('🔍 filterCoreSubjects() called');
  
  const gradeFilter = document.getElementById('grade-filter');
  const sectionFilter = document.getElementById('section-filter');
  const strandFilter = document.getElementById('strand-filter');
  
  if (!gradeFilter || !sectionFilter || !strandFilter) {
    console.log('❌ Filter elements not found:', { gradeFilter, sectionFilter, strandFilter });
    return;
  }
  
  const selectedGrade = gradeFilter.value;
  const selectedSection = sectionFilter.value;
  const selectedStrand = strandFilter.value;
  
  console.log('Filtering with:', { selectedGrade, selectedSection, selectedStrand });
  console.log('All core subjects count:', allCoreSubjects.length);
  console.log('Sample core subject:', allCoreSubjects[0]);
  
  let filteredClasses = [...allCoreSubjects]; // Create a copy
  
  // Apply filters
  if (selectedGrade) {
    filteredClasses = filteredClasses.filter(c => {
      const gradeName = c.gradeLevel?.name || '';
      console.log('Checking grade:', gradeName, 'against selected:', selectedGrade);
      
      // More precise matching - check for exact grade number
      // Handle formats like "Grade 7", "7", "Grade 11", "11"
      const gradeNumber = gradeName.toString().replace(/[^0-9]/g, '');
      const selectedNumber = selectedGrade.toString();
      
      console.log('Grade number extracted:', gradeNumber, 'selected number:', selectedNumber);
      return gradeNumber === selectedNumber;
    });
  }
  
  if (selectedSection) {
    filteredClasses = filteredClasses.filter(c => {
      const sectionName = c.section?.section_name || '';
      return sectionName === selectedSection;
    });
  }
  
  if (selectedStrand) {
    filteredClasses = filteredClasses.filter(c => {
      const strandName = c.strand?.name || '';
      return strandName === selectedStrand;
    });
  }
  
  console.log('Filtered classes:', filteredClasses);
  
  // Update the display
  updateDefaultClassesSection(filteredClasses);
}

// Function to clear all filters
function clearAllFilters() {
  const gradeFilter = document.getElementById('grade-filter');
  const sectionFilter = document.getElementById('section-filter');
  const strandFilter = document.getElementById('strand-filter');
  
  if (gradeFilter) gradeFilter.value = '';
  if (sectionFilter) sectionFilter.value = '';
  if (strandFilter) strandFilter.value = '';
  
  // Show all core subjects
  updateDefaultClassesSection(allCoreSubjects);
}

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
  
  // Function to load available classes dynamically
  async function loadAvailableClasses(instructorId = null) {
    try {
      const url = instructorId 
        ? `/admin/api/admin/available-classes?instructor_id=${instructorId}`
        : '/admin/api/admin/available-classes';
      
      const response = await fetch(url, {
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
        // Store all core subjects for filtering
        allCoreSubjects = data.defaultClasses;
        
        // Update the default subjects checkboxes section
        updateDefaultClassesSection(data.defaultClasses);
        
        // Populate filter dropdowns
        populateFilterDropdowns(data.defaultClasses);
        
        // Initialize filter event listeners after elements are created
        setTimeout(() => {
          initializeFilterListeners();
        }, 100);
        
        // Update the "Other Classes" multi-select dropdown
        updateAllClassesDropdown(data.allClasses);
        
        console.log('Classes loaded successfully');
      }
    } catch (error) {
      console.error('Error loading available classes:', error);
      showNotification('Failed to load latest classes. Please refresh the page.', 'error');
    }
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
    
    // Load latest classes dynamically, filtered by instructor's advisory section
    await loadAvailableClasses(instrId);
    
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
  
    // show the overlay with smooth animation
    if (assignOverlay) {
      assignOverlay.style.display = 'flex';
      
      // Trigger animation
      setTimeout(() => {
        assignOverlay.style.opacity = '1';
        const modalContent = assignOverlay.querySelector('div[style*="transform"]');
        if (modalContent) {
          modalContent.style.transform = 'scale(1)';
          modalContent.style.opacity = '1';
        }
      }, 10);
    }
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

  // Add close button functionality with smooth animation
  window.closeClassesModal = function() {
    const assignOverlay = document.getElementById('assign-classes-overlay');
    if (assignOverlay) {
      const modalContent = assignOverlay.querySelector('div[style*="transform"]');
      assignOverlay.style.opacity = '0';
      if (modalContent) {
        modalContent.style.transform = 'scale(0.9)';
        modalContent.style.opacity = '0';
      }
      setTimeout(() => {
        assignOverlay.style.display = 'none';
      }, 300);
    }
  }
  
  const cancelAssignBtn = document.getElementById('cancel-assign-classes');
  if (cancelAssignBtn) {
    cancelAssignBtn.addEventListener('click', closeClassesModal);
  }
  
  // Close on overlay click
  if (assignOverlay) {
    assignOverlay.addEventListener('click', function(e) {
      if (e.target === assignOverlay) {
        closeClassesModal();
      }
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

  // Form validation and AJAX submission
  const assignForm = document.getElementById('assign-classes-form');
  if (assignForm) {
    console.log('Assign form found:', assignForm);
    assignForm.addEventListener('submit', function(e) {
      console.log('Form submitted');
      e.preventDefault(); // Prevent default form submission
      
      // Get selected classes from checkboxes and multi-select dropdown
      const checkedBoxes = document.querySelectorAll('input[name="class_ids[]"]:checked');
      const multiSelect = document.getElementById('class_ids');
      const selectedOptions = multiSelect ? Array.from(multiSelect.selectedOptions) : [];
      
      const selectedClasses = [...checkedBoxes, ...selectedOptions];
      
      console.log('Selected classes:', selectedClasses);
      
      if (selectedClasses.length === 0) {
        showNotification('Please select at least one class to assign.', 'warning');
        return false;
      }
      
      // Show loading state
      let submitBtn = assignForm.querySelector('button[type="submit"]');
      
      // Fallback if not found in form
      if (!submitBtn) {
        submitBtn = document.querySelector('#assign-classes-overlay button[type="submit"]');
      }
      
      console.log('Submit button:', submitBtn);
      
      if (!submitBtn) {
        console.error('Submit button not found. Form:', assignForm);
        console.error('Available buttons in form:', assignForm.querySelectorAll('button'));
        return;
      }
      
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Assigning...';
      submitBtn.disabled = true;
      
      // Submit via AJAX
      const formData = new FormData(assignForm);
      
      fetch(assignForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(response => {
        if (response.ok) {
          return response.text(); // Get the full HTML response
        }
        throw new Error('Network response was not ok');
      })
      .then(data => {
        // Show success notification outside the modal
        showNotification('Classes assigned successfully!', 'success');
        
        // Close the modal
        closeClassesModal();
        
        // Refresh the assigned classes display
        setTimeout(() => {
          refreshAssignedClasses();
        }, 500);
        
        // Re-enable button
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to assign classes. Please try again.', 'error');
        
        // Re-enable button
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      });
    });
  }

  // Auto-hide notifications
  document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('assign-success-alert');
    const errorAlert = document.getElementById('assign-error-alert');
    
    if (successAlert) {
      setTimeout(function() {
        window.closeAlert('assign-success-alert');
      }, 5000);
    }
    
    if (errorAlert) {
      setTimeout(function() {
        window.closeAlert('assign-error-alert');
      }, 7000);
    }
  });

  // Function to refresh assigned classes display
  async function refreshAssignedClasses() {
    if (!selectedInstructorRow) return;
    
    const instructorId = selectedInstructorRow.dataset.instructorId;
    
    try {
      // Fetch the updated instructor data from the server
      const response = await fetch(`/admin/instructors/${instructorId}/data`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      });
      
      if (response.ok) {
        const data = await response.json();
        
        // Update the row's data attribute with the new classes
        if (data.instructor_classes) {
          selectedInstructorRow.dataset.instructorClasses = JSON.stringify(data.instructor_classes);
        }
        
        // Refresh the assigned classes display
        const instructorClasses = data.instructor_classes || [];
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
      } else {
        // Fallback to using cached data if the fetch fails
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
    } catch (error) {
      console.error('Error refreshing assigned classes:', error);
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
const instructorName  = document.getElementById('schedule-instructor-name');
const existingUL      = document.querySelector('#existing-schedules-list ul');

  // Initialize schedule buttons as disabled
  if (scheduleBtns.length > 0) {
    scheduleBtns.forEach(btn => {
      btn.disabled = true;
      btn.style.opacity = '0.6';
      btn.style.cursor = 'not-allowed';
      btn.title = 'Please select an instructor first';
    });
  }

  // Define handleSchedulesClick BEFORE using it in event listeners
  // Make handleSchedulesClick globally accessible
  window.handleSchedulesClick = function handleSchedulesClick() {
    if (!selectedInstructorRow) {
      showNotification('Please select an instructor first by clicking on a row in the table.', 'warning');
      return;
    }
  
    // pull the JSON payload off the <tr>
    const payload = JSON.parse(selectedInstructorRow.dataset.instructorClasses || '[]');
    const fullname = selectedInstructorRow.dataset.fullname;
    const instructorId = selectedInstructorRow.dataset.instructorId;
  
    // 1) fill instructor name and ID
    document.getElementById('schedule-instructor-name').textContent = fullname;
    document.getElementById('schedule-instructor-id').value = instructorId;
  
    // 2) rebuild ALL class-pivot <select> elements (for multiple entries)
    const scheduleSelects = document.querySelectorAll('.schedule-class-select');
    
    // Get form and submit button
    const form = document.getElementById('schedule-form');
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
    const inputs = form ? form.querySelectorAll('input, select') : [];
    
    // Check if instructor has any classes assigned
    if (payload.length === 0) {
      // No classes assigned - show message and disable form
      scheduleSelects.forEach(scheduleSelect => {
        scheduleSelect.innerHTML = '';
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = 'No classes assigned to this instructor';
        opt.disabled = true;
        scheduleSelect.appendChild(opt);
      });
      
      // Clear existing schedules
      const ul = document.querySelector('#existing-schedules-list ul');
      if (ul) {
        ul.innerHTML = '<li style="color: #666; font-style: italic;">No classes assigned. Please assign classes first using the "Classes" button.</li>';
      }
      
      // Disable the form
      inputs.forEach(input => input.disabled = true);
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Assign Classes First';
      }
      
    } else {
      // Classes are assigned - populate all dropdowns normally
      scheduleSelects.forEach(scheduleSelect => {
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
      });
      
      // Enable the form
      inputs.forEach(input => input.disabled = false);
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save All Schedules';
      }
      
      // Render schedules for first class (only need to do this once, not for each select)
      if (payload.length > 0 && scheduleSelects.length > 0) {
        renderSchedulesForPivot(payload[0].pivot_id, payload);
        // Attach onChange to first select only
        scheduleSelects[0].onchange = e => renderSchedulesForPivot(e.target.value, payload);
      }
    }
  
    // 5) show modal with smooth animation
    scheduleOverlay.style.display = 'flex';
    scheduleOverlay.classList.add('show');
    
    // Trigger animation
    setTimeout(() => {
      scheduleOverlay.style.opacity = '1';
      const modalContent = scheduleOverlay.querySelector('div[style*="transform"]');
      if (modalContent) {
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
      }
    }, 10);
  }

  // Wire up the buttons AFTER function is defined
  scheduleBtns.forEach(btn => btn.addEventListener('click', handleSchedulesClick));
  
  window.closeScheduleModal = function() {
    const scheduleOverlay = document.getElementById('schedules-overlay');
    if (scheduleOverlay) {
      const modalContent = scheduleOverlay.querySelector('div[style*="transform"]');
      scheduleOverlay.style.opacity = '0';
      if (modalContent) {
        modalContent.style.transform = 'scale(0.9)';
        modalContent.style.opacity = '0';
      }
      setTimeout(() => {
        scheduleOverlay.style.display = 'none';
        scheduleOverlay.classList.remove('show');
        resetScheduleForm();
      }, 300);
    }
  }
  
  cancelSchedule.addEventListener('click', closeScheduleModal);
  scheduleOverlay.addEventListener('click', e => {
    if (e.target === scheduleOverlay) {
      closeScheduleModal();
    }
  });
  
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  
  // Function to reload instructor schedules after adding a new one
  function reloadInstructorSchedules(pivotId) {
    if (!selectedInstructorRow) return;
    
    const instructorId = selectedInstructorRow.dataset.instructorId;
    
    // Fetch updated instructor data
    fetch(`/admin/instructors/${instructorId}/schedules`, {
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      // Update the instructor row's dataset with new schedule data
      if (data.instructorClasses) {
        selectedInstructorRow.dataset.instructorClasses = JSON.stringify(data.instructorClasses);
        
        // Re-render the schedules for the currently selected class
        const payload = JSON.parse(selectedInstructorRow.dataset.instructorClasses || '[]');
        renderSchedulesForPivot(pivotId, payload);
      }
    })
    .catch(error => {
      console.error('Error reloading schedules:', error);
      // Fallback: just show a message that they should refresh
      showNotification('Schedule added! Please refresh the page to see all updates.', 'info');
    });
  }

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
    
    // Clear all class dropdowns
    const scheduleSelects = document.querySelectorAll('.schedule-class-select');
    scheduleSelects.forEach(select => {
      select.innerHTML = '';
    });
    
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

    // Helper function to convert 24-hour time to 12-hour format
    function formatTime(time24) {
      if (!time24) return '';
      const [hours, minutes] = time24.split(':');
      let hour = parseInt(hours);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      hour = hour % 12 || 12; // Convert 0 to 12 for midnight
      return `${hour}:${minutes} ${ampm}`;
    }

    if (scheds.length) {
      scheds.forEach(s => {
        const li = document.createElement('li');
        li.style.cssText = 'padding: 14px 16px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #7a222b; transition: all 0.2s;';
        
        // Schedule info container
        const infoDiv = document.createElement('div');
        infoDiv.style.cssText = 'flex: 1; display: flex; flex-direction: column; gap: 4px;';
        
        // Day and time
        const dayTime = document.createElement('div');
        dayTime.style.cssText = 'font-weight: 600; color: #212529; font-size: 14px;';
        dayTime.innerHTML = `
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
          ${s.day_of_week} • ${formatTime(s.start_time)} – ${formatTime(s.end_time)}
        `;
        
        // Room
        const room = document.createElement('div');
        room.style.cssText = 'font-size: 13px; color: #6c757d;';
        room.innerHTML = `
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
          ${s.room}
        `;
        
        infoDiv.appendChild(dayTime);
        infoDiv.appendChild(room);
        
        // Delete button
        const del = document.createElement('button');
        del.innerHTML = `
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
          </svg>
          Delete
        `;
        del.style.cssText = 'background: #dc3545; color: white; border: none; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.2s; display: flex; align-items: center; gap: 4px;';
        del.onmouseover = () => del.style.background = '#c82333';
        del.onmouseout = () => del.style.background = '#dc3545';
        
        del.addEventListener('click', () => {
          if (!confirm('Delete this schedule?')) return;
          const schedId = s.schedule_id;
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
            showNotification('Schedule deleted successfully!', 'success');
          })
          .catch(err => {
            showNotification('Failed to delete schedule: ' + err.message, 'error');
          });
        });

        li.appendChild(infoDiv);
        li.appendChild(del);
        ul.appendChild(li);
      });
    } else {
      ul.innerHTML = '<li style="padding: 12px; background: #f8f9fa; border-radius: 6px; color: #6c757d; text-align: center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>No schedules assigned yet</li>';
    }
  }
  
  // Make renderSchedulesForPivot accessible globally
  window.renderSchedulesForPivot = renderSchedulesForPivot;

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

      // Enable schedule buttons and add visual feedback
      scheduleBtns.forEach(btn => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
        btn.title = 'Click to manage schedules for ' + fullname;
      });

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
  // Directly call handleSchedulesClick - it will handle the validation internally
  if (typeof window.handleSchedulesClick === 'function') {
    window.handleSchedulesClick();
  } else {
    console.error('handleSchedulesClick function is not defined');
    alert('Unable to open schedule modal. Please refresh the page and try again.');
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

// Core Subjects Filter Functionality

// Function to populate filter dropdowns
function populateFilterDropdowns(classes) {
  const sectionFilter = document.getElementById('section-filter');
  const strandFilter = document.getElementById('strand-filter');
  
  if (!sectionFilter || !strandFilter) return;
  
  // Get unique sections and strands
  const sections = [...new Set(classes.map(c => c.section.section_name).filter(Boolean))];
  const strands = [...new Set(classes.map(c => c.strand?.name).filter(Boolean))];
  
  // Populate section filter
  sectionFilter.innerHTML = '<option value="">All Sections</option>';
  sections.forEach(section => {
    const option = document.createElement('option');
    option.value = section;
    option.textContent = section;
    sectionFilter.appendChild(option);
  });
  
  // Populate strand filter
  strandFilter.innerHTML = '<option value="">All Strands</option>';
  strands.forEach(strand => {
    const option = document.createElement('option');
    option.value = strand;
    option.textContent = strand;
    strandFilter.appendChild(option);
  });
}

// Function to initialize filter event listeners
function initializeFilterListeners() {
  const gradeFilter = document.getElementById('grade-filter');
  const sectionFilter = document.getElementById('section-filter');
  const strandFilter = document.getElementById('strand-filter');
  const clearButton = document.getElementById('clear-filters');
  
  console.log('Initializing filter listeners:', { gradeFilter, sectionFilter, strandFilter, clearButton });
  
  if (gradeFilter) {
    gradeFilter.removeEventListener('change', filterCoreSubjects); // Remove existing listener
    gradeFilter.addEventListener('change', filterCoreSubjects);
    console.log('Grade filter listener added');
  }
  
  if (sectionFilter) {
    sectionFilter.removeEventListener('change', filterCoreSubjects);
    sectionFilter.addEventListener('change', filterCoreSubjects);
    console.log('Section filter listener added');
  }
  
  if (strandFilter) {
    strandFilter.removeEventListener('change', filterCoreSubjects);
    strandFilter.addEventListener('change', filterCoreSubjects);
    console.log('Strand filter listener added');
  }
  
  if (clearButton) {
    clearButton.removeEventListener('click', clearAllFilters);
    clearButton.addEventListener('click', clearAllFilters);
    console.log('Clear button listener added');
  }
}

// Add event listeners for filters
document.addEventListener('DOMContentLoaded', function() {
  // Try to initialize filters on page load
  initializeFilterListeners();
  
  // Initialize dynamic schedule entries
  initializeDynamicScheduleEntries();
});

// Dynamic Schedule Entries Functionality
function initializeDynamicScheduleEntries() {
  const addEntryBtn = document.getElementById('add-schedule-entry-btn');
  const scheduleForm = document.getElementById('schedule-form');
  
  if (!addEntryBtn || !scheduleForm) return;
  
  let entryIndex = 1; // Start from 1 since we already have entry 0
  
  // Handle "Add Another" button click
  addEntryBtn.addEventListener('click', function() {
    addScheduleEntry();
    updateRemoveButtons();
  });
  
  // Handle remove entry buttons (using event delegation)
  scheduleForm.addEventListener('click', function(e) {
    if (e.target.closest('.remove-entry-btn')) {
      const entry = e.target.closest('.schedule-entry');
      if (entry) {
        removeScheduleEntry(entry);
        updateRemoveButtons();
      }
    }
  });
  
  // Override form submission to handle multiple entries
  scheduleForm.addEventListener('submit', function(e) {
    e.preventDefault();
    submitMultipleSchedules();
  });
  
  // Function to add a new schedule entry
  function addScheduleEntry() {
    const entriesList = document.getElementById('schedule-entries-list');
    const firstEntry = entriesList.querySelector('.schedule-entry');
    
    if (!entriesList || !firstEntry) return;
    
    const newEntry = firstEntry.cloneNode(true);
    newEntry.setAttribute('data-entry-index', entryIndex);
    
    // Clear all input values
    const inputs = newEntry.querySelectorAll('input, select');
    inputs.forEach(input => {
      if (input.type === 'text') input.value = '';
      else if (input.type === 'time') input.value = '';
      else if (input.tagName === 'SELECT') input.selectedIndex = 0;
    });
    
    // Add the new entry to the list
    entriesList.appendChild(newEntry);
    
    entryIndex++;
  }
  
  // Function to remove a schedule entry
  function removeScheduleEntry(entry) {
    const entries = document.querySelectorAll('.schedule-entry');
    if (entries.length <= 1) {
      showNotification('At least one schedule entry is required.', 'warning');
      return;
    }
    
    entry.remove();
  }
  
  // Function to update remove button visibility
  function updateRemoveButtons() {
    const entries = document.querySelectorAll('.schedule-entry');
    const removeBtns = document.querySelectorAll('.remove-entry-btn');
    
    entries.forEach((entry, index) => {
      const removeBtn = entry.querySelector('.remove-entry-btn');
      if (removeBtn) {
        // Show remove button only if there are multiple entries
        if (entries.length > 1) {
          removeBtn.style.display = 'block';
        } else {
          removeBtn.style.display = 'none';
        }
      }
    });
  }
  
  // Function to submit multiple schedules
  function submitMultipleSchedules() {
    const entries = document.querySelectorAll('.schedule-entry');
    const instructorId = document.getElementById('schedule-instructor-id').value;
    
    if (!instructorId) {
      showNotification('No instructor selected.', 'error');
      return;
    }
    
    // Collect all schedule data
    const schedules = [];
    let hasErrors = false;
    
    entries.forEach((entry, index) => {
      const classId = entry.querySelector('.schedule-class-select').value;
      const day = entry.querySelector('.schedule-day-select').value;
      const startTime = entry.querySelector('.schedule-start-time').value;
      const endTime = entry.querySelector('.schedule-end-time').value;
      const room = entry.querySelector('.schedule-room').value;
      
      if (classId && day && startTime && endTime && room) {
        schedules.push({
          instructor_class_id: classId,
          day_of_week: day,
          start_time: startTime,
          end_time: endTime,
          room: room
        });
      } else if (index > 0) {
        // Only allow empty entries for the first entry (in case user just wants to add one)
        // For additional entries, they should be filled or removed
        hasErrors = true;
        return;
      }
    });
    
    if (hasErrors) {
      showNotification('Please fill in all fields for each schedule entry, or remove empty entries.', 'warning');
      return;
    }
    
    if (schedules.length === 0) {
      showNotification('Please fill in at least one schedule entry.', 'warning');
      return;
    }
    
    // Disable submit button
    const submitBtn = document.querySelector('.save-btn');
    
    if (!submitBtn) {
      console.error('Submit button not found');
      showNotification('Error: Submit button not found. Please refresh the page.', 'error');
      return;
    }
    
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    // Submit all schedules sequentially
    let successCount = 0;
    let errorCount = 0;
    let currentIndex = 0;
    
    function submitNext() {
      if (currentIndex >= schedules.length) {
        // All done
        if (successCount > 0) {
          showNotification(`${successCount} schedule${successCount > 1 ? 's' : ''} added successfully!`, 'success');
          
          // Reset form
          resetScheduleEntriesForm();
          
          // Reload schedules from server to get the updated data
          if (selectedInstructorRow) {
            const instructorId = selectedInstructorRow.dataset.instructorId;
            
            // Fetch updated instructor data
            fetch(`/admin/instructors/${instructorId}/data`, {
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              // Update the instructor row's dataset with new schedule data
              if (data.instructor_classes) {
                selectedInstructorRow.dataset.instructorClasses = JSON.stringify(data.instructor_classes);
                
                // Re-render the schedules for the currently selected class
                const payload = data.instructor_classes;
                if (payload.length > 0) {
                  const firstPivotId = payload[0].pivot_id;
                  renderSchedulesForPivot(firstPivotId, payload);
                }
              }
            })
            .catch(error => {
              console.error('Error reloading schedules:', error);
              // Fallback: use cached data
              const payload = JSON.parse(selectedInstructorRow.dataset.instructorClasses || '[]');
              if (payload.length > 0) {
                const firstPivotId = payload[0].pivot_id;
                renderSchedulesForPivot(firstPivotId, payload);
              }
            });
          }
        }
        
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        
        // Don't show generic error message if we already showed specific errors
        // The individual error notifications were already displayed above
        
        return;
      }
      
      const schedule = schedules[currentIndex];
      const formData = new FormData();
      formData.append('instructor_class_id', schedule.instructor_class_id);
      formData.append('day_of_week', schedule.day_of_week);
      formData.append('start_time', schedule.start_time);
      formData.append('end_time', schedule.end_time);
      formData.append('room', schedule.room);
      
      fetch('/admin/instructors/schedules', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => Promise.reject(err));
        }
        return response.json();
      })
      .then(data => {
        successCount++;
        currentIndex++;
        submitNext();
      })
      .catch(error => {
        console.error('Error adding schedule:', error);
        
        // Show specific error message if available
        let errorMessage = 'Failed to add schedule.';
        if (error.errors) {
          // Laravel validation errors
          errorMessage = Object.values(error.errors).flat().join(' ');
        } else if (error.message) {
          errorMessage = error.message;
        }
        
        showNotification(errorMessage, 'error');
        
        errorCount++;
        currentIndex++;
        submitNext();
      });
    }
    
    submitNext();
  }
  
  // Function to reset the schedule entries form
  function resetScheduleEntriesForm() {
    const entries = document.querySelectorAll('.schedule-entry');
    
    // Keep only the first entry and clear it
    for (let i = entries.length - 1; i > 0; i--) {
      entries[i].remove();
    }
    
    // Clear the first entry
    const firstEntry = entries[0];
    if (firstEntry) {
      const inputs = firstEntry.querySelectorAll('input, select');
      inputs.forEach(input => {
        if (input.type === 'text') input.value = '';
        else if (input.type === 'time') input.value = '';
        else if (input.tagName === 'SELECT') input.selectedIndex = 0;
      });
    }
    
    // Reset entry index
    entryIndex = 1;
    updateRemoveButtons();
  }
}

// Function to refresh the schedules list manually - moved outside of initializeDynamicScheduleEntries
window.refreshSchedulesList = function() {
  // Get instructor ID from the hidden input field in the modal
  const instructorIdInput = document.getElementById('schedule-instructor-id');
  const instructorId = instructorIdInput ? instructorIdInput.value : null;
  
  if (!instructorId) {
    showNotification('No instructor selected in the form.', 'warning');
    return;
  }
  
  const refreshBtn = document.getElementById('refresh-schedules-btn');
  
  // Show loading state
  if (refreshBtn) {
    const originalText = refreshBtn.innerHTML;
    refreshBtn.disabled = true;
    refreshBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg> Refreshing...';
    
    // Fetch updated instructor data
    fetch(`instructors/${instructorId}/data`, {
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      // Update the instructor row's dataset with new schedule data if it exists
      if (selectedInstructorRow && data.instructor_classes) {
        selectedInstructorRow.dataset.instructorClasses = JSON.stringify(data.instructor_classes);
      }
      
      // Re-render the schedules for the currently selected class
      if (data.instructor_classes) {
        const payload = data.instructor_classes;
        if (payload.length > 0) {
          const firstPivotId = payload[0].pivot_id;
          renderSchedulesForPivot(firstPivotId, payload);
          showNotification('Schedules list refreshed successfully.', 'success');
        } else {
          const ul = document.querySelector('#existing-schedules-list ul');
          if (ul) {
            ul.innerHTML = '<li style="padding: 12px; background: #f8f9fa; border-radius: 6px; color: #6c757d; text-align: center;">No schedules assigned yet</li>';
          }
          showNotification('No schedules found.', 'info');
        }
      }
      
      // Restore button state
      if (refreshBtn) {
        refreshBtn.disabled = false;
        refreshBtn.innerHTML = originalText;
      }
    })
    .catch(error => {
      console.error('Error refreshing schedules:', error);
      showNotification('Failed to refresh schedules list.', 'error');
      
      // Restore button state
      if (refreshBtn) {
        refreshBtn.disabled = false;
        refreshBtn.innerHTML = originalText;
      }
    });
  }
}

// Add CSS for spin animation
const style = document.createElement('style');
style.textContent = `
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
`;
document.head.appendChild(style);
