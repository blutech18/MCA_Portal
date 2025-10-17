<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result</title>
    <link rel="stylesheet" href="{{ asset('css/styles_result.css') }}?v={{ time() }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
</head>
<body>
    <div class="result-container {{ strtolower($strand) }}">
        <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="School Logo" class="logo">
    
        <h1 class="strand">{{ $strand }}</h1>
    
        @if($saved)
        <div class="success-message">
            <h3>✓ Assessment Results Saved!</h3>
            <p>Your assessment results have been saved and will be used during enrollment.</p>
        </div>
        @endif

        <p class="description">
            {{ $descriptions[$strand] }}
        </p>

        @if($assessmentResult)
        <div class="score-details">
            <h4>Your Assessment Details</h4>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Assessment Score:</strong> {{ $assessmentResult->scores[$strand] }}/25 ({{ number_format($assessmentResult->getScorePercentage($strand), 1) }}%)</p>
            <p><strong>Completed:</strong> {{ $assessmentResult->completed_at->format('M d, Y \a\t g:i A') }}</p>
            
            <button class="score-breakdown-btn" onclick="openScoresModal()">View All Strand Scores</button>
        </div>
        @endif

        <div class="btn-container">
            <a href="{{ route('enroll.new.step1') }}?from_assessment=true" class="btn proceed-btn">Enrollment Form</a>
            <a href="{{ route('strand.assessment') }}" class="btn retake-btn">Retake Assessment</a>
            <a href="{{ route('login') }}" class="btn go-back-btn">Back to Login</a>
        </div>
    </div>

    <!-- Strand Scores Modal -->
    <div id="scores-modal" class="scores-modal">
        <div class="scores-modal-content">
            <div class="scores-modal-header">
                <h3 class="scores-modal-title">All Strand Scores</h3>
                <button class="scores-modal-close" onclick="closeScoresModal()">&times;</button>
            </div>
            @if($assessmentResult)
            <ul class="scores-list">
                @php
                    $allScores = $assessmentResult->getAllScorePercentages();
                    $highestScore = max($allScores);
                    $selectedStrand = $strand;
                @endphp
                @foreach($allScores as $strandName => $percentage)
                @php
                    $isHighest = $percentage == $highestScore;
                    $isSelected = $strandName == $selectedStrand;
                    $classes = [];
                    if ($isHighest) $classes[] = 'highest-score';
                    if ($isSelected) $classes[] = 'selected-strand';
                    $classString = implode(' ', $classes);
                @endphp
                <li class="{{ $classString }}">
                    <span class="strand-name">{{ $strandName }}</span>
                    <span class="strand-score">{{ $percentage }}%</span>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <script>
        function openScoresModal() {
            document.getElementById('scores-modal').style.display = 'block';
        }

        function closeScoresModal() {
            document.getElementById('scores-modal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('scores-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeScoresModal();
            }
        });
    </script>
</body>
</html>
