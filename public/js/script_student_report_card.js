/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
document.addEventListener('DOMContentLoaded', function() {
    
    const mobileToggle = document.querySelector('.mobile-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !mobileToggle.contains(event.target) &&
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
    
    
    const semesterTabs = document.querySelectorAll('.semester-tab');
    
    semesterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            semesterTabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // You can add logic here to load different semester data
            const semester = this.dataset.semester;
            console.log(`Semester ${semester} selected`);
            
            // For demonstration purposes - change some UI elements based on semester
            if (semester === '2') {
                // Simulate loading second semester data (for demo only)
                setTimeout(() => {
                    // This is just a visual demo - in a real app you'd load actual data
                    document.querySelectorAll('.quarter-grade').forEach(grade => {
                        // Generate a random grade between 75 and 95
                        const randomGrade = Math.floor(Math.random() *