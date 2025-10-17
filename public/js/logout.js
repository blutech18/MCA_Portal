/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
(function(){
  if (window.__logoutJsLoaded) return; // idempotent guard
  window.__logoutJsLoaded = true;

  // Expose functions only if not already present
  window.confirmExit = window.confirmExit || function() {
      console.log("confirmExit called");
      const modal = document.getElementById("confirm-modal");
      if (modal) {
          modal.style.display = "flex";
          console.log("Modal displayed");
      } else {
          console.error("Modal not found");
      }
  };

  window.closeModal = window.closeModal || function() {
      console.log("closeModal called");
      const modal = document.getElementById('confirm-modal');
      if (modal) {
          modal.style.display = "none";
          console.log("Modal hidden");
      } else {
          console.error("Modal not found for closing");
      }
  };

  window.logout = window.logout || function(event) {
      console.log("logout called");
      if (event && event.preventDefault) event.preventDefault();
      const form = document.getElementById('logout-form');
      if (form) {
          form.submit();
          console.log("Logout form submitted");
      } else {
          console.error("Logout form not found");
      }
  };

  // Only add user modal functionality if elements exist (admin pages)
  var addUserButtons = document.querySelectorAll('.add-user-btn');
  if (addUserButtons.length > 0) {
    addUserButtons.forEach(function(button){
      button.addEventListener('click', function () {
          var userType = this.dataset.type;
          console.log("Add User clicked!", userType);
          var modalUserType = document.getElementById('modal-user-type');
          var addUserModal = document.getElementById('addUserModal');
          if (modalUserType && addUserModal) {
            modalUserType.value = userType;
            addUserModal.style.display = 'flex';
          }
      });
    });
  }

  // Close modal functionality (only if close buttons exist)
  var closeButtons = document.querySelectorAll('.close');
  if (closeButtons.length > 0) {
    closeButtons.forEach(function(closeBtn){
      closeBtn.addEventListener('click', function () {
          var parentModal = this.closest('.modal');
          if (parentModal) parentModal.style.display = 'none';
      });
    });
  }

  // Optional: Close modal on click outside (only if addUserModal exists)
  var addUserModal = document.getElementById('addUserModal');
  if (addUserModal) {
    window.addEventListener('click', function (event) {
      if (event.target === addUserModal) {
          addUserModal.style.display = 'none';
      }
    });
  }

  window.filterUsers = window.filterUsers || function(inputElement, tableId) {
    var searchValue = (inputElement.value || '').toLowerCase();
    var table = document.getElementById(tableId);
    if (!table) return;

    var rows = table.querySelectorAll('tbody tr');

    rows.forEach(function(row){
        var cells = row.querySelectorAll('td');
        var match = false;

        cells.forEach(function(cell){
            if ((cell.textContent || '').toLowerCase().includes(searchValue)) {
                match = true;
            }
        });

        row.style.display = match ? '' : 'none';
    });
  };

  // Only add settings toggle functionality if elements exist (admin pages)
  var settingsToggle, settingsMenu;

  function initSettingsToggles() {
    settingsToggle = document.getElementById('settingsToggle');
    settingsMenu = document.getElementById('settingsMenu');

    if (settingsToggle && settingsMenu) {
      settingsToggle.addEventListener('click', function(e){
        e.stopPropagation();
        e.preventDefault();
        var isVisible = settingsMenu.style.display === 'flex' || settingsMenu.style.display === 'block';
        settingsMenu.style.display = isVisible ? 'none' : 'flex';
        console.log('Settings menu toggled:', settingsMenu.style.display);
      });

      // Close the menu when clicking outside
      document.addEventListener('click', function(event){
        if (!settingsToggle.contains(event.target) && !settingsMenu.contains(event.target)) {
          settingsMenu.style.display = 'none';
        }
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSettingsToggles);
  } else {
    initSettingsToggles();
  }

  // Debug: Check if elements exist on page load
  document.addEventListener('DOMContentLoaded', function() {
      console.log("DOM loaded, checking elements...");
      
      var modal = document.getElementById('confirm-modal');
      var form = document.getElementById('logout-form');
      var logoutBtn = document.querySelector('.logout-btn');
      var dropdownItem = document.querySelector('.dropdown-item');
      
      console.log("Modal exists:", !!modal);
      console.log("Logout form exists:", !!form);
      console.log("Logout button exists:", !!logoutBtn);
      console.log("Dropdown logout item exists:", !!dropdownItem);
      
      // Add click outside handler for modal
      if (modal) {
          modal.addEventListener('click', function(event) {
              if (event.target === modal) {
                  window.closeModal();
              }
          });
      }
  });
})();

