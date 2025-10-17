/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
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

// 25 questions with unique answer choices for each question
const questions = [
  { 
    q: '1. Which quote resonates with you the most?', 
    options: [
      { text: 'Knowledge is power', scores: { 'STEM': 1 } },
      { text: 'Success is the best revenge', scores: { 'ABM': 1 } },
      { text: 'Understanding leads to wisdom', scores: { 'GAS': 1 } },
      { text: 'Communication bridges all gaps', scores: { 'HUMSS': 1 } },
      { text: 'Innovation drives the future', scores: { 'ICT': 1 } },
      { text: 'Nourishment brings people together', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '2. How do you prefer to learn?', 
    options: [
      { text: 'Through hands-on experiments', scores: { 'STEM': 1 } },
      { text: 'By analyzing case studies', scores: { 'ABM': 1 } },
      { text: 'Through theoretical discussions', scores: { 'GAS': 1 } },
      { text: 'Through group debates and discussions', scores: { 'HUMSS': 1 } },
      { text: 'By building and coding projects', scores: { 'ICT': 1 } },
      { text: 'By creating and tasting recipes', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '3. Which are you more comfortable with?', 
    options: [
      { text: 'Complex mathematical formulas', scores: { 'STEM': 1 } },
      { text: 'Financial spreadsheets and budgets', scores: { 'ABM': 1 } },
      { text: 'Philosophical concepts and theories', scores: { 'GAS': 1 } },
      { text: 'Social issues and human behavior', scores: { 'HUMSS': 1 } },
      { text: 'Programming languages and code', scores: { 'ICT': 1 } },
      { text: 'Cooking techniques and ingredients', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '4. What environment do you thrive in?', 
    options: [
      { text: 'Laboratory or research facility', scores: { 'STEM': 1 } },
      { text: 'Corporate office or business center', scores: { 'ABM': 1 } },
      { text: 'Library or quiet study space', scores: { 'GAS': 1 } },
      { text: 'Community center or public forum', scores: { 'HUMSS': 1 } },
      { text: 'Tech hub or innovation center', scores: { 'ICT': 1 } },
      { text: 'Kitchen or culinary school', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '5. In a group project, which role do you take?', 
    options: [
      { text: 'Research and data analyst', scores: { 'STEM': 1 } },
      { text: 'Project manager and coordinator', scores: { 'ABM': 1 } },
      { text: 'Theoretical framework designer', scores: { 'GAS': 1 } },
      { text: 'Discussion facilitator and presenter', scores: { 'HUMSS': 1 } },
      { text: 'Technical developer and programmer', scores: { 'ICT': 1 } },
      { text: 'Creative designer and implementer', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '6. When facing a challenge, you rely on:', 
    options: [
      { text: 'Scientific method and experimentation', scores: { 'STEM': 1 } },
      { text: 'Strategic planning and analysis', scores: { 'ABM': 1 } },
      { text: 'Critical thinking and reasoning', scores: { 'GAS': 1 } },
      { text: 'Communication and collaboration', scores: { 'HUMSS': 1 } },
      { text: 'Technical skills and innovation', scores: { 'ICT': 1 } },
      { text: 'Creativity and practical solutions', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '7. Your favorite subject is:', 
    options: [
      { text: 'Mathematics and Science', scores: { 'STEM': 1 } },
      { text: 'Business and Economics', scores: { 'ABM': 1 } },
      { text: 'Philosophy and Literature', scores: { 'GAS': 1 } },
      { text: 'History and Social Studies', scores: { 'HUMSS': 1 } },
      { text: 'Computer Science and Technology', scores: { 'ICT': 1 } },
      { text: 'Home Economics and Arts', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '8. You feel successful when:', 
    options: [
      { text: 'You solve complex problems', scores: { 'STEM': 1 } },
      { text: 'You achieve business goals', scores: { 'ABM': 1 } },
      { text: 'You gain deep understanding', scores: { 'GAS': 1 } },
      { text: 'You help others and create change', scores: { 'HUMSS': 1 } },
      { text: 'You create innovative technology', scores: { 'ICT': 1 } },
      { text: 'You create something beautiful and useful', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '9. Which activity appeals most?', 
    options: [
      { text: 'Conducting scientific experiments', scores: { 'STEM': 1 } },
      { text: 'Managing a business venture', scores: { 'ABM': 1 } },
      { text: 'Reading and analyzing texts', scores: { 'GAS': 1 } },
      { text: 'Organizing community events', scores: { 'HUMSS': 1 } },
      { text: 'Developing software applications', scores: { 'ICT': 1 } },
      { text: 'Designing and creating crafts', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '10. Your ideal internship is at:', 
    options: [
      { text: 'Research laboratory', scores: { 'STEM': 1 } },
      { text: 'Corporate company', scores: { 'ABM': 1 } },
      { text: 'Academic institution', scores: { 'GAS': 1 } },
      { text: 'Non-profit organization', scores: { 'HUMSS': 1 } },
      { text: 'Tech startup company', scores: { 'ICT': 1 } },
      { text: 'Restaurant or culinary school', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '11. What motivates you most?', 
    options: [
      { text: 'Discovering new knowledge', scores: { 'STEM': 1 } },
      { text: 'Achieving financial success', scores: { 'ABM': 1 } },
      { text: 'Understanding complex ideas', scores: { 'GAS': 1 } },
      { text: 'Making a positive impact', scores: { 'HUMSS': 1 } },
      { text: 'Creating innovative solutions', scores: { 'ICT': 1 } },
      { text: 'Expressing creativity through practical skills', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '12. You prefer tasks that are:', 
    options: [
      { text: 'Analytical and research-based', scores: { 'STEM': 1 } },
      { text: 'Goal-oriented and strategic', scores: { 'ABM': 1 } },
      { text: 'Thought-provoking and theoretical', scores: { 'GAS': 1 } },
      { text: 'People-centered and collaborative', scores: { 'HUMSS': 1 } },
      { text: 'Technical and innovative', scores: { 'ICT': 1 } },
      { text: 'Creative and hands-on', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '13. Which best describes you?', 
    options: [
      { text: 'Logical and analytical thinker', scores: { 'STEM': 1 } },
      { text: 'Ambitious and goal-driven', scores: { 'ABM': 1 } },
      { text: 'Thoughtful and reflective', scores: { 'GAS': 1 } },
      { text: 'Socially conscious and empathetic', scores: { 'HUMSS': 1 } },
      { text: 'Tech-savvy and innovative', scores: { 'ICT': 1 } },
      { text: 'Creative and practical', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '14. You enjoy learning about:', 
    options: [
      { text: 'Scientific phenomena and discoveries', scores: { 'STEM': 1 } },
      { text: 'Market trends and business strategies', scores: { 'ABM': 1 } },
      { text: 'Philosophical concepts and theories', scores: { 'GAS': 1 } },
      { text: 'Social issues and human behavior', scores: { 'HUMSS': 1 } },
      { text: 'Emerging technologies and digital trends', scores: { 'ICT': 1 } },
      { text: 'Culinary arts and creative techniques', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '15. Which appeals most?', 
    options: [
      { text: 'Solving complex equations', scores: { 'STEM': 1 } },
      { text: 'Leading a team to success', scores: { 'ABM': 1 } },
      { text: 'Writing and analyzing literature', scores: { 'GAS': 1 } },
      { text: 'Advocating for social justice', scores: { 'HUMSS': 1 } },
      { text: 'Building the next big app', scores: { 'ICT': 1 } },
      { text: 'Creating beautiful and functional designs', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '16. How do you make decisions?', 
    options: [
      { text: 'Based on data and evidence', scores: { 'STEM': 1 } },
      { text: 'Considering costs and benefits', scores: { 'ABM': 1 } },
      { text: 'Through careful analysis and reasoning', scores: { 'GAS': 1 } },
      { text: 'Considering impact on others', scores: { 'HUMSS': 1 } },
      { text: 'By testing and prototyping', scores: { 'ICT': 1 } },
      { text: 'By experimenting and refining', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '17. You prefer work that is:', 
    options: [
      { text: 'Research-intensive and analytical', scores: { 'STEM': 1 } },
      { text: 'Results-driven and profitable', scores: { 'ABM': 1 } },
      { text: 'Intellectually stimulating and theoretical', scores: { 'GAS': 1 } },
      { text: 'Meaningful and socially impactful', scores: { 'HUMSS': 1 } },
      { text: 'Cutting-edge and innovative', scores: { 'ICT': 1 } },
      { text: 'Creative and hands-on practical', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '18. When presenting, you:', 
    options: [
      { text: 'Use data and charts to support your points', scores: { 'STEM': 1 } },
      { text: 'Focus on results and business outcomes', scores: { 'ABM': 1 } },
      { text: 'Present logical arguments and theories', scores: { 'GAS': 1 } },
      { text: 'Connect with your audience emotionally', scores: { 'HUMSS': 1 } },
      { text: 'Demonstrate technology and innovation', scores: { 'ICT': 1 } },
      { text: 'Show practical examples and creations', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '19. Your hobby is:', 
    options: [
      { text: 'Conducting personal science experiments', scores: { 'STEM': 1 } },
      { text: 'Managing personal investments', scores: { 'ABM': 1 } },
      { text: 'Reading philosophy or academic books', scores: { 'GAS': 1 } },
      { text: 'Volunteering for social causes', scores: { 'HUMSS': 1 } },
      { text: 'Coding personal projects', scores: { 'ICT': 1 } },
      { text: 'Cooking or crafting', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '20. Which skill do you value most?', 
    options: [
      { text: 'Problem-solving and analysis', scores: { 'STEM': 1 } },
      { text: 'Leadership and management', scores: { 'ABM': 1 } },
      { text: 'Critical thinking and reasoning', scores: { 'GAS': 1 } },
      { text: 'Communication and empathy', scores: { 'HUMSS': 1 } },
      { text: 'Technical proficiency and innovation', scores: { 'ICT': 1 } },
      { text: 'Creativity and practical application', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '21. What excites you?', 
    options: [
      { text: 'New scientific discoveries', scores: { 'STEM': 1 } },
      { text: 'Business opportunities and growth', scores: { 'ABM': 1 } },
      { text: 'Intellectual debates and discussions', scores: { 'GAS': 1 } },
      { text: 'Social movements and change', scores: { 'HUMSS': 1 } },
      { text: 'Emerging technologies and AI', scores: { 'ICT': 1 } },
      { text: 'New recipes and creative techniques', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '22. You are drawn to:', 
    options: [
      { text: 'Complex problems and challenges', scores: { 'STEM': 1 } },
      { text: 'Success stories and achievements', scores: { 'ABM': 1 } },
      { text: 'Deep thinking and contemplation', scores: { 'GAS': 1 } },
      { text: 'Human stories and experiences', scores: { 'HUMSS': 1 } },
      { text: 'Innovation and technology trends', scores: { 'ICT': 1 } },
      { text: 'Artistic expression and beauty', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '23. Your strength is:', 
    options: [
      { text: 'Logical reasoning and analysis', scores: { 'STEM': 1 } },
      { text: 'Strategic planning and execution', scores: { 'ABM': 1 } },
      { text: 'Deep understanding and insight', scores: { 'GAS': 1 } },
      { text: 'Building relationships and connections', scores: { 'HUMSS': 1 } },
      { text: 'Technical skills and adaptability', scores: { 'ICT': 1 } },
      { text: 'Creative problem-solving and design', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '24. The type of articles you read are about:', 
    options: [
      { text: 'Scientific research and discoveries', scores: { 'STEM': 1 } },
      { text: 'Business news and market analysis', scores: { 'ABM': 1 } },
      { text: 'Philosophical and academic topics', scores: { 'GAS': 1 } },
      { text: 'Social issues and current events', scores: { 'HUMSS': 1 } },
      { text: 'Technology and innovation news', scores: { 'ICT': 1 } },
      { text: 'Arts, crafts, and lifestyle content', scores: { 'HE': 1 } }
    ]
  },
  { 
    q: '25. In your career, you aim to:', 
    options: [
      { text: 'Contribute to scientific advancement', scores: { 'STEM': 1 } },
      { text: 'Build a successful business empire', scores: { 'ABM': 1 } },
      { text: 'Pursue academic excellence and knowledge', scores: { 'GAS': 1 } },
      { text: 'Make a positive impact on society', scores: { 'HUMSS': 1 } },
      { text: 'Revolutionize technology and innovation', scores: { 'ICT': 1 } },
      { text: 'Express creativity through practical skills', scores: { 'HE': 1 } }
    ]
  }
];

let currentIndex = 0;
const answers = [];
let userEmail = null;

// DOM references
const container = document.querySelector('.assessment-container');
const questionEl = document.getElementById('question-text');
const optionBtns = Array.from(document.querySelectorAll('.option'));
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const submitBtn = document.getElementById('submit-btn');
const progressFill = document.getElementById('progress-fill');
const questionCounter = document.getElementById('question-counter');

// Render current question and options
function renderQuestion() {
  const { q, options } = questions[currentIndex];
  questionEl.textContent = q;

  // Update progress bar
  const progress = ((currentIndex + 1) / questions.length) * 100;
  progressFill.style.width = progress + '%';

  // Update question counter
  questionCounter.textContent = `Question ${currentIndex + 1} of ${questions.length}`;

  // Clear previous selections
  optionBtns.forEach(btn => {
    btn.classList.remove('selected');
    btn.disabled = false;
  });

  // Populate options
  options.forEach((opt, idx) => {
    const btn = optionBtns[idx];
    btn.textContent = opt.text;
    btn.disabled = false;
    btn.style.display = 'block';
  });

  // Hide unused options
  for (let i = options.length; i < optionBtns.length; i++) {
    optionBtns[i].style.display = 'none';
  }

  // Navigation controls
  prevBtn.disabled = currentIndex === 0;
  nextBtn.disabled = currentIndex === questions.length - 1;
  submitBtn.style.display = currentIndex === questions.length - 1 ? 'block' : 'none';
}

// Handle option click: record and advance
optionBtns.forEach((btn, idx) => {
  btn.addEventListener('click', () => {
    // Remove previous selection
    optionBtns.forEach(b => b.classList.remove('selected'));
    
    // Add selection to clicked button
    btn.classList.add('selected');
    
    // Record answer
    answers[currentIndex] = questions[currentIndex].options[idx].scores;
    
    // Auto-advance to next question after a short delay
    setTimeout(() => {
    if (currentIndex < questions.length - 1) {
      currentIndex++;
      renderQuestion();
    }
    }, 500);
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

// Submit: tally and save results
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

  // Save assessment results via AJAX
  saveAssessmentResults(userEmail, bestStrand, totals);
});

// Function to save assessment results
function saveAssessmentResults(email, recommendedStrand, scores) {
  fetch('/strand_assessment/submit', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                     document.querySelector('input[name="_token"]')?.value
    },
    body: JSON.stringify({
      email: email,
      recommended_strand: recommendedStrand,
      scores: scores,
      total_questions: 25,
      completed_at: new Date().toISOString()
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Store assessment ID in session for enrollment flow
      sessionStorage.setItem('assessment_id', data.assessment_id);
      // Redirect to result page
  const url = new URL(submitBtn.dataset.resultRoute, window.location.origin);
      url.searchParams.set('strand', recommendedStrand);
      url.searchParams.set('email', email);
      url.searchParams.set('saved', 'true');
  window.location.href = url;
    } else {
      alert('Error saving assessment results: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error saving assessment results. Please try again.');
  });
}

// Email form handling
document.addEventListener('DOMContentLoaded', function() {
  const emailInput = document.getElementById('user-email');
  const startBtn = document.getElementById('start-assessment-btn');
  const emailForm = document.getElementById('email-form');
  const emailModal = document.getElementById('email-modal');
  
  // Debug: Check if elements are found
  console.log('Email input found:', !!emailInput);
  console.log('Start button found:', !!startBtn);
  console.log('Email form found:', !!emailForm);
  console.log('Email modal found:', !!emailModal);

  // Enable start button when valid email is entered
  if (emailInput && startBtn) {
    // Email validation function
    function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email) && email.length > 5;
    }
    
    emailInput.addEventListener('input', function() {
      const emailValue = this.value.trim();
      const isValid = validateEmail(emailValue);
      startBtn.disabled = !isValid;
      console.log('Email validation:', emailValue, 'Valid:', isValid, 'Button disabled:', startBtn.disabled);
      
      // Also update button appearance
      if (isValid) {
        startBtn.style.opacity = '1';
        startBtn.style.cursor = 'pointer';
      } else {
        startBtn.style.opacity = '0.6';
        startBtn.style.cursor = 'not-allowed';
      }
    });
    
    // Also validate on keyup for better responsiveness
    emailInput.addEventListener('keyup', function() {
      const emailValue = this.value.trim();
      const isValid = validateEmail(emailValue);
      startBtn.disabled = !isValid;
    });
    
    // Also validate on paste
    emailInput.addEventListener('paste', function() {
      setTimeout(() => {
        const emailValue = this.value.trim();
        const isValid = validateEmail(emailValue);
        startBtn.disabled = !isValid;
      }, 10);
    });
    
    // Debug: Add click event listener to start button
    startBtn.addEventListener('click', function() {
      console.log('Start Assessment button clicked!');
      console.log('Button disabled:', this.disabled);
      console.log('Email value:', emailInput.value);
    });
  }

  // Handle email form submission
  if (emailForm) {
    emailForm.addEventListener('submit', function(e) {
      e.preventDefault();
      userEmail = emailInput.value.trim();
      console.log('Form submitted with email:', userEmail);
      
      // Validate email before proceeding
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (userEmail && emailRegex.test(userEmail)) {
        // Hide modal and show assessment
        emailModal.style.display = 'none';
        
        // Show assessment container
        container.classList.add('visible');
        
        // Initialize the first question
renderQuestion();
        
        // Store email in session storage for enrollment flow
        sessionStorage.setItem('assessment_email', userEmail);
        
        // Also set in server session via AJAX
        fetch('/strand_assessment/set-email', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value
          },
          body: JSON.stringify({
            email: userEmail
          })
        }).catch(error => {
          console.error('Error setting assessment email in session:', error);
        });
      } else {
        alert('Please enter a valid email address');
      }
    });
  }
});

// Initialize - Don't render question until email is captured
// renderQuestion(); // Will be called after email capture



function confirmExit() {
    // Only show confirmation modal if assessment has started
    const assessmentContainer = document.querySelector('.assessment-container');
    if (assessmentContainer && assessmentContainer.classList.contains('visible')) {
    document.getElementById("confirm-modal").style.display = "flex";
    } else {
        // If assessment hasn't started, just redirect to login
        window.location.href = "/login";
    }
}

// Global function for closing confirmation modal
window.closeModal = function() {
    document.getElementById("confirm-modal").style.display = "none";
}

// Global function for going to result page
window.goToResult = function() {
    let resultRoute = document.querySelector(".submit-btn").getAttribute("data-result-route");
    window.location.href = resultRoute; // Redirect to result page
}


// Global functions for assessment navigation
window.exitAssessment = function() {
    let exitRoute = document.querySelector(".button-back").getAttribute("data-route");
    window.location.href = exitRoute; // Redirect to the assessment page
}

window.closeEmailModal = function() {
    // Close the email modal and redirect to login
    window.location.href = "/login";
}

// Global function for closing modal only
window.closeModalOnly = function() {
    // Close the email modal and redirect to login page
    window.location.href = "/login";
}
