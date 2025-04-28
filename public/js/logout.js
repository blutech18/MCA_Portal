function confirmExit() {
    document.getElementById("confirm-modal").style.display = "flex";
}

function closeModal() {
    document.getElementById('confirm-modal').style.display = "none";
}

function logout(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
}
// Open modal and pass the user type
document.querySelectorAll('.add-user-btn').forEach(button => {
  button.addEventListener('click', function () {
      const userType = this.dataset.type;
      console.log("Add User clicked!", userType); // Debug line
      document.getElementById('modal-user-type').value = userType;
      document.getElementById('addUserModal').style.display = 'flex';
  });
});


// Close modal (already in app.blade.php, but just to confirm)
document.querySelectorAll('.close').forEach(closeBtn => {
  closeBtn.addEventListener('click', function () {
      this.closest('.modal').style.display = 'none';
  });
});

// Optional: Close modal on click outside
window.addEventListener('click', function (event) {
  const modal = document.getElementById('addUserModal');
  if (event.target === modal) {
      modal.style.display = 'none';
  }
});

function filterUsers(inputElement, tableId) {
  const searchValue = inputElement.value.toLowerCase();
  const table = document.getElementById(tableId);
  if (!table) return;

  const rows = table.querySelectorAll('tbody tr');

  rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      let match = false;

      cells.forEach(cell => {
          if (cell.textContent.toLowerCase().includes(searchValue)) {
              match = true;
          }
      });

      row.style.display = match ? '' : 'none';
  });
}

