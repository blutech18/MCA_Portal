function updateDate() {
  const now = new Date();
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const formattedDate = now.toLocaleDateString('en-US', options);
  document.getElementById('current-date').textContent = formattedDate;
}

function populateScheduleCards() {
  for (let i = 0; i < 3; i++) {
    const data = scheduleData[i] || {};
    document.getElementById(`grade${i+1}`).textContent   = data.grade   || '—';
    document.getElementById(`section${i+1}`).textContent = data.section || '—';
    document.getElementById(`subject${i+1}`).textContent = data.subject || '—';
    document.getElementById(`time${i+1}`).textContent    = data.time    || '—';
  }
  const moreLink = document.querySelector('.more-link');
  if (scheduleData.length > 3) {
    moreLink.textContent = `View ${scheduleData.length - 3} more…`;
  } else {
    moreLink.style.display = 'none';
  }
}

function formatTime(t) {
  const [h, m] = t.split(':');
  let hour = parseInt(h, 10);
  const ampm = hour >= 12 ? 'PM' : 'AM';
  hour = hour % 12 || 12;
  return `${hour}:${m} ${ampm}`;
}

function populateScheduleCards() {
  // if you have 6 cards, loop over them
  for (let i = 0; i < scheduleData.length && i < 6; i++) {
    const cardIndex = i + 1;
    const s = scheduleData[i];

    document.getElementById(`grade${cardIndex}`).textContent   = s.grade;
    document.getElementById(`section${cardIndex}`).textContent = s.section || '—';
    document.getElementById(`subject${cardIndex}`).textContent = s.subject;
    document.getElementById(`time${cardIndex}`).textContent    =
      `${formatTime(s.start)} – ${formatTime(s.end)}`;
    // **new**: room and day
    document.getElementById(`time${cardIndex}`)
      .insertAdjacentHTML('beforeend', `<br><small>Room ${s.room} (${s.day})</small>`);
  }
}


document.addEventListener('DOMContentLoaded', () => {
  updateDate();
  populateScheduleCards();
  populateScheduleTable();
  
  setInterval(updateDate, 60000);
});