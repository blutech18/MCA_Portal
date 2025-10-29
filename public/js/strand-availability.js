(function(){
  function updateAvailabilityUI(data){
    const codes = ['ABM','GAS','STEM','HUMSS','HE','ICT'];
    codes.forEach(code => {
      const info = data[code];
      const span = document.getElementById('availability_' + code);
      const input = document.getElementById('strand_' + code);
      if (!span || !input || !info) return;

      const available = parseInt(info.available || 0, 10);
      const capacity = parseInt(info.capacity || 0, 10);
      const enrolled = parseInt(info.enrolled || 0, 10);

      // Text
      if (capacity > 0) {
        if (available > 0) {
          span.textContent = `(${available}/${capacity} slots available)`;
          span.style.color = '#2e7d32'; // green
        } else {
          span.textContent = `(${capacity}/${capacity} - FULL)`;
          span.style.color = '#c62828'; // red
        }
      } else {
        span.textContent = '';
      }

      // Disable if full
      const isFull = capacity > 0 && enrolled >= capacity;
      input.disabled = isFull;
      if (isFull) {
        // Uncheck if currently selected
        if (input.checked) input.checked = false;
      }
    });
  }

  async function fetchAvailability(){
    try {
      const res = await fetch(window.__strandAvailabilityUrl || '/enroll/new/strand-availability', { cache: 'no-store' });
      if (!res.ok) return;
      const data = await res.json();
      updateAvailabilityUI(data);
    } catch(e){ /* no-op */ }
  }

  function init(){
    const btn = document.getElementById('refreshStrandAvailability');
    if (btn) {
      btn.addEventListener('click', fetchAvailability);
    }
    // initial load
    fetchAvailability();
    // optional polling every 30s
    if (!window.__disableStrandPolling) {
      setInterval(fetchAvailability, 30000);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();


