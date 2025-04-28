// Show modal with overlay
document.getElementById('add-subject-btn').addEventListener('click', function() {
  document.getElementById('overlay').style.display = 'block';
  document.getElementById('add-subject-form').style.display = 'block';
});

// Hide modal and overlay
document.getElementById('cancel-btn').addEventListener('click', function() {
  document.getElementById('overlay').style.display = 'none';
  document.getElementById('add-subject-form').style.display = 'none';
});

// Close modal with close button (X)
document.getElementById('close-modal-btn').addEventListener('click', function() {
  document.getElementById('overlay').style.display = 'none';
  document.getElementById('add-subject-form').style.display = 'none';
});

const searchInput = document.getElementById('instructor-search');
const sortSelect = document.getElementById('sort');
const subjectList = document.querySelector('.subject-list');

// Add sorting options
const sortOptions = [
    { value: 'name-asc', label: 'Name A-Z' },
    { value: 'name-desc', label: 'Name Z-A' },
    { value: 'code-asc', label: 'Code A-Z' },
    { value: 'code-desc', label: 'Code Z-A' }
];

sortOptions.forEach(option => {
    const opt = document.createElement('option');
    opt.value = option.value;
    opt.textContent = option.label;
    sortSelect.appendChild(opt);
});

// Search function
searchInput.addEventListener('input', () => {
    const filter = searchInput.value.toLowerCase();
    const items = subjectList.querySelectorAll('li');

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(filter) ? '' : 'none';
    });
});

// Sort function
sortSelect.addEventListener('change', () => {
    const itemsArray = Array.from(subjectList.querySelectorAll('li'));
    const value = sortSelect.value;

    itemsArray.sort((a, b) => {
        const [nameA, codeA] = a.textContent.trim().split('(');
        const [nameB, codeB] = b.textContent.trim().split('(');

        if (value === 'name-asc') return nameA.localeCompare(nameB);
        if (value === 'name-desc') return nameB.localeCompare(nameA);
        if (value === 'code-asc') return codeA.localeCompare(codeB);
        if (value === 'code-desc') return codeB.localeCompare(codeA);
        return 0;
    });

    // Re-append sorted items
    itemsArray.forEach(item => subjectList.appendChild(item));
});