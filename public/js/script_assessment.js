/*
  script_assessment.js
  Handles dynamic question flow and scoring for Strand Assessment Test
*/

// Strands and 1-2 word labels
const strands = ['STEM','ABM','GAS','HUMSS','ICT','HE'];
const labels = {
  STEM: 'Experiment',
  ABM: 'Business',
  GAS: 'Theory',
  HUMSS: 'Discussion',
  ICT: 'Coding',
  HE: 'Cooking'
};

// 25 questions with equal 6 options per question
const questions = [
  { q: '1. Which quote resonates with you the most?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '2. How do you prefer to learn?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '3. Which are you more comfortable with?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '4. What environment do you thrive in?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '5. In a group project, which role do you take?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '6. When facing a challenge, you rely on:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '7. Your favorite subject is:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '8. You feel successful when:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '9. Which activity appeals most?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '10. Your ideal internship is at:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '11. What motivates you most?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '12. You prefer tasks that are:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '13. Which best describes you?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '14. You enjoy learning about:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '15. Which appeals most?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '16. How do you make decisions?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '17. You prefer work that is:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '18. When presenting, you:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '19. Your hobby is:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '20. Which skill do you value most?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '21. What excites you?', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '22. You are drawn to:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '23. Your strength is:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '24. The type of articles you read are about:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) },
  { q: '25. In your career, you aim to:', options: strands.map(s => ({ text: labels[s], scores: { [s]: 1 } })) }
];

let currentIndex = 0;
const answers = [];

// DOM references
const container = document.querySelector('.assessment-container');
const questionEl = container.querySelector('h2');
const optionBtns = Array.from(container.querySelectorAll('.option'));
const prevBtn = container.querySelector('.nav-btn:first-child');
const nextBtn = container.querySelector('.nav-btn:last-child');
const submitBtn = container.querySelector('.submit-btn');

// Render current question and options
function renderQuestion() {
  const { q, options } = questions[currentIndex];
  questionEl.textContent = q;

  options.forEach((opt, idx) => {
    const btn = optionBtns[idx];
    btn.textContent = opt.text;
    btn.disabled = false;
  });

  // Ensure exactly 6 options: hide extras (if any)
  for (let i = options.length; i < optionBtns.length; i++) {
    optionBtns[i].textContent = '';
    optionBtns[i].disabled = true;
  }

  // Navigation controls
  prevBtn.disabled = currentIndex === 0;
  nextBtn.disabled = currentIndex === questions.length - 1;
  submitBtn.style.display = currentIndex === questions.length - 1 ? 'inline-block' : 'none';
}

// Handle option click: record and advance
optionBtns.forEach((btn, idx) => {
  btn.addEventListener('click', () => {
    answers[currentIndex] = questions[currentIndex].options[idx].scores;
    if (currentIndex < questions.length - 1) {
      currentIndex++;
      renderQuestion();
    }
  });
});

// Navigation
prevBtn.addEventListener('click', () => {
  if (currentIndex > 0) {
    currentIndex--;
    renderQuestion();
  }
});
nextBtn.addEventListener('click', () => {
  if (currentIndex < questions.length - 1) {
    currentIndex++;
    renderQuestion();
  }
});

// Submit: tally and redirect
submitBtn.addEventListener('click', () => {
  const totals = {};
  answers.forEach(scores => {
    for (const strand in scores) {
      totals[strand] = (totals[strand] || 0) + scores[strand];
    }
  });

  // Find highest-scoring strand
  let bestStrand = null;
  let maxScore = -Infinity;
  for (const strand in totals) {
    if (totals[strand] > maxScore) {
      bestStrand = strand;
      maxScore = totals[strand];
    }
  }

  // Redirect with strand param
  const url = new URL(submitBtn.dataset.resultRoute, window.location.origin);
  url.searchParams.set('strand', bestStrand);
  window.location.href = url;
});

// Initialize
renderQuestion();



function confirmExit() {
    document.getElementById("confirm-modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("confirm-modal").style.display = "none";
}

function goToResult() {
    let resultRoute = document.querySelector(".submit-btn").getAttribute("data-result-route");
    window.location.href = resultRoute; // Redirect to result page
}


function exitAssessment() {
    let exitRoute = document.querySelector(".button-back").getAttribute("data-route");
    window.location.href = exitRoute; // Redirect to the assessment page
}
