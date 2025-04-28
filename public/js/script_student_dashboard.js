document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle functionality
    const addMobileSidebarToggle = () => {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        
        
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'mobile-toggle';
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
        
        
        mainContent.insertBefore(toggleBtn, mainContent.firstChild);
        
        
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        });
        
        
        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open') && 
                !sidebar.contains(e.target) && 
                e.target !== toggleBtn) {
                sidebar.classList.remove('open');
                document.body.classList.remove('sidebar-open');
            }
        });
    };
    
    
    if (window.innerWidth < 992) {
        addMobileSidebarToggle();
    }
    
    window.addEventListener('resize', () => {
        if (window.innerWidth < 992 && !document.querySelector('.mobile-toggle')) {
            addMobileSidebarToggle();
        }
    });

    
    const notificationsBtn = document.querySelector('.notifications');
    if (notificationsBtn) {
        setupDropdown(notificationsBtn, createNotificationsDropdown());
    }

    
    const settingsBtn = document.querySelector('.settings');
    if (settingsBtn) {
        setupDropdown(settingsBtn, createSettingsDropdown());
    }

    
    const sliderDots = document.querySelectorAll('.slider-dot');
    const announcements = document.querySelectorAll('.announcement-card');
    const sliderContainer = document.querySelector('.announcements-slider');
    
    if (sliderDots.length > 0 && announcements.length > 0) {
        sliderDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                // Calculate position to scroll to
                const position = index * announcements[0].offsetWidth;
                
                
                sliderContainer.scrollTo({
                    left: position,
                    behavior: 'smooth'
                });
                
                
                sliderDots.forEach(d => d.classList.remove('active'));
                dot.classList.add('active');
            });
        });
        
        
        sliderContainer.addEventListener('scroll', () => {
            const scrollPosition = sliderContainer.scrollLeft;
            const cardWidth = announcements[0].offsetWidth;
            
            const activeIndex = Math.round(scrollPosition / cardWidth);
            
            sliderDots.forEach((dot, index) => {
                dot.classList.toggle('active', index === activeIndex);
            });
        });
    }

    
    let currentSlide = 0;
    const rotateAnnouncements = () => {
        currentSlide = (currentSlide + 1) % sliderDots.length;
        sliderDots[currentSlide].click();
    };
    
    const interval = setInterval(rotateAnnouncements, 5000);
    
    
    sliderContainer.addEventListener('mouseenter', () => {
        clearInterval(interval);
    });
    
    sliderContainer.addEventListener('mouseleave', () => {
        clearInterval(interval);
    });

    
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Remove active class from all links
            sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
            
            // Add active class to clicked link
            link.parentElement.classList.add('active');
        });
    });

    
    if (window.innerWidth < 992) {
        createSidebarTooltips();
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth < 992) {
            createSidebarTooltips();
        } else {
            removeSidebarTooltips();
        }
    });

    // Initial setup for dropdowns
    function setupDropdown(triggerElement, dropdownContent) {
        // Create dropdown container
        const dropdown = document.createElement('div');
        dropdown.className = 'dropdown';
        dropdown.style.display = 'none';
        dropdown.appendChild(dropdownContent);
        
        // Add dropdown to DOM
        triggerElement.appendChild(dropdown);
        
        // Toggle dropdown on click
        triggerElement.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            dropdown.style.display = 'none';
        });
    }

    // Create notifications dropdown content
    function createNotificationsDropdown() {
        const container = document.createElement('div');
        container.className = 'dropdown-content notifications-dropdown';
        
        const header = document.createElement('div');
        header.className = 'dropdown-header';
        header.innerHTML = '<h3>Notifications</h3><a href="#">Mark all as read</a>';
        
        const notificationsList = document.createElement('div');
        notificationsList.className = 'notifications-list';
        
        // Sample notifications
        const notifications = [
            {
                title: 'New Assignment',
                message: 'Math homework due tomorrow',
                time: '2 hours ago',
                read: false
            },
            {
                title: 'Grade Posted',
                message: 'Your English essay has been graded',
                time: '1 day ago',
                read: true
            },
            {
                title: 'School Event',
                message: 'Science fair registration is now open',
                time: '2 days ago',
                read: true
            }
        ];
        
        notifications.forEach(notification => {
            const item = document.createElement('div');
            item.className = `notification-item ${notification.read ? 'read' : 'unread'}`;
            
            item.innerHTML = `
                <div class="notification-icon">
                    <i class="fas ${notification.read ? 'fa-envelope-open' : 'fa-envelope'}"></i>
                </div>
                <div class="notification-content">
                    <h4>${notification.title}</h4>
                    <p>${notification.message}</p>
                    <span class="notification-time">${notification.time}</span>
                </div>
            `;
            
            notificationsList.appendChild(item);
        });
        
        const footer = document.createElement('div');
        footer.className = 'dropdown-footer';
        footer.innerHTML = '<a href="#">View all notifications</a>';
        
        container.appendChild(header);
        container.appendChild(notificationsList);
        container.appendChild(footer);
        
        return container;
    }

    // Create settings dropdown content
    function createSettingsDropdown() {
        const container = document.createElement('div');
        container.className = 'dropdown-content settings-dropdown';
        
        const header = document.createElement('div');
        header.className = 'dropdown-header';
        header.innerHTML = '<h3>Settings</h3>';
        
        const settingsList = document.createElement('div');
        settingsList.className = 'settings-list';
        
        const settingsItems = [
            { icon: 'fa-user', text: 'Profile Settings' },
            { icon: 'fa-bell', text: 'Notification Preferences' },
            { icon: 'fa-lock', text: 'Privacy & Security' },
            { icon: 'fa-palette', text: 'Appearance' },
            { icon: 'fa-question-circle', text: 'Help & Support' }
        ];
        
        settingsItems.forEach(item => {
            const settingItem = document.createElement('a');
            settingItem.className = 'setting-item';
            settingItem.href = '#';
            
            settingItem.innerHTML = `
                <i class="fas ${item.icon}"></i>
                <span>${item.text}</span>
            `;
            
            settingsList.appendChild(settingItem);
        });
        
        container.appendChild(header);
        container.appendChild(settingsList);
        
        return container;
    }

    // Create tooltips for sidebar items
    function createSidebarTooltips() {
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        
        sidebarLinks.forEach(link => {
            // Get the text content
            const text = link.textContent.trim();
            
            // Create tooltip if it doesn't exist
            if (!link.querySelector('.tooltip')) {
                const tooltip = document.createElement('span');
                tooltip.className = 'tooltip';
                tooltip.textContent = text;
                
                // Add tooltip to link
                link.appendChild(tooltip);
                
                // Add event listeners for tooltip
                link.addEventListener('mouseenter', () => {
                    tooltip.style.opacity = '1';
                    tooltip.style.visibility = 'visible';
                });
                
                link.addEventListener('mouseleave', () => {
                    tooltip.style.opacity = '0';
                    tooltip.style.visibility = 'hidden';
                });
            }
        });
        
        // Add CSS for tooltips
        if (!document.getElementById('tooltip-styles')) {
            const tooltipStyles = document.createElement('style');
            tooltipStyles.id = 'tooltip-styles';
            tooltipStyles.textContent = `
                .sidebar-nav a {
                    position: relative;
                }
                .tooltip {
                    position: absolute;
                    background-color: #333;
                    color: white;
                    padding: 5px 10px;
                    border-radius: 4px;
                    font-size: 12px;
                    left: 100%;
                    top: 50%;
                    transform: translateY(-50%);
                    margin-left: 10px;
                    white-space: nowrap;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.3s ease;
                    z-index: 1000;
                }
                .tooltip::before {
                    content: '';
                    position: absolute;
                    left: -5px;
                    top: 50%;
                    transform: translateY(-50%);
                    border-width: 5px 5px 5px 0;
                    border-style: solid;
                    border-color: transparent #333 transparent transparent;
                }
                .mobile-toggle {
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    background-color: var(--accent-color);
                    color: white;
                    border: none;
                    border-radius: 5px;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    z-index: 1000;
                }
                .sidebar {
                    transform: translateX(-100%);
                    transition: transform 0.3s ease;
                }
                .sidebar.open {
                    transform: translateX(0);
                }
                .main-content {
                    margin-left: 0;
                    padding-top: 70px;
                }
                .dropdown {
                    position: absolute;
                    top: 100%;
                    right: 0;
                    z-index: 1000;
                    min-width: 250px;
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }
                .dropdown-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 15px;
                    border-bottom: 1px solid #eee;
                }
                .dropdown-header h3 {
                    margin: 0;
                    font-size: 16px;
                }
                .dropdown-header a {
                    font-size: 12px;
                    color: var(--accent-color);
                    text-decoration: none;
                }
                .notifications-list, .settings-list {
                    max-height: 300px;
                    overflow-y: auto;
                }
                .notification-item {
                    display: flex;
                    padding: 12px 15px;
                    border-bottom: 1px solid #f0f0f0;
                    cursor: pointer;
                    transition: background-color 0.2s;
                }
                .notification-item:hover {
                    background-color: #f9f9f9;
                }
                .notification-item.unread {
                    background-color: rgba(131, 0, 1, 0.05);
                }
                .notification-icon {
                    margin-right: 12px;
                    width: 30px;
                    height: 30px;
                    background-color: #f0f0f0;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: var(--accent-color);
                }
                .notification-content h4 {
                    margin: 0 0 5px;
                    font-size: 14px;
                }
                .notification-content p {
                    margin: 0 0 5px;
                    font-size: 12px;
                    color: #666;
                }
                .notification-time {
                    font-size: 10px;
                    color: #999;
                }
                .dropdown-footer {
                    padding: 10px;
                    text-align: center;
                    border-top: 1px solid #eee;
                }
                .dropdown-footer a {
                    color: var(--accent-color);
                    font-size: 12px;
                    text-decoration: none;
                }
                .setting-item {
                    display: flex;
                    align-items: center;
                    padding: 12px 15px;
                    border-bottom: 1px solid #f0f0f0;
                    text-decoration: none;
                    color: var(--text-dark);
                    transition: background-color 0.2s;
                }
                .setting-item:hover {
                    background-color: #f9f9f9;
                }
                .setting-item i {
                    margin-right: 12px;
                    color: var(--accent-color);
                    width: 20px;
                    text-align: center;
                }
                @media (max-width: 992px) {
                    body.sidebar-open {
                        overflow: hidden;
                    }
                    .sidebar {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 250px;
                        z-index: 1001;
                        height: 100vh;
                        transform: translateX(-100%);
                    }
                    .sidebar.open {
                        transform: translateX(0);
                    }
                }
            `;
            document.head.appendChild(tooltipStyles);
        }
    }

    // Remove tooltips
    function removeSidebarTooltips() {
        const tooltips = document.querySelectorAll('.tooltip');
        tooltips.forEach(tooltip => {
            tooltip.remove();
        });
    }

    // Add some animations to elements
    animateElements();

    function animateElements() {
        // Add CSS animations for elements
        const animStyles = document.createElement('style');
        animStyles.id = 'animation-styles';
        animStyles.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideIn {
                from { transform: translateX(-20px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            .animated {
                animation-duration: 0.5s;
                animation-fill-mode: both;
            }
            
            .fade-in {
                animation-name: fadeIn;
            }
            
            .slide-in {
                animation-name: slideIn;
            }
            
            .delay-1 { animation-delay: 0.1s; }
            .delay-2 { animation-delay: 0.2s; }
            .delay-3 { animation-delay: 0.3s; }
            .delay-4 { animation-delay: 0.4s; }
            .delay-5 { animation-delay: 0.5s; }
        `;
        document.head.appendChild(animStyles);
        
        // Add animation classes to elements
        const banner = document.querySelector('.banner');
        if (banner) {
            banner.classList.add('animated', 'fade-in');
        }
        
        const subjectCards = document.querySelectorAll('.subject-card');
        subjectCards.forEach((card, index) => {
            card.classList.add('animated', 'fade-in', `delay-${index + 1}`);
        });
        
        const gradeCards = document.querySelectorAll('.grade-card');
        gradeCards.forEach((card, index) => {
            card.classList.add('animated', 'fade-in', `delay-${index + 1}`);
        });
        
        const deadlineItems = document.querySelectorAll('.deadline-item');
        deadlineItems.forEach((item, index) => {
            item.classList.add('animated', 'slide-in', `delay-${index + 1}`);
        });
        
        const announcementCards = document.querySelectorAll('.announcement-card');
        announcementCards.forEach((card, index) => {
            card.classList.add('animated', 'fade-in', `delay-${index + 1}`);
        });
    }

    // Add theme toggle functionality
    addThemeToggle();

    function addThemeToggle() {
        // Create theme toggle button
        const themeToggle = document.createElement('div');
        themeToggle.className = 'theme-toggle';
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        
        // Add theme toggle to top bar
        const topBar = document.querySelector('.top-bar');
        const userMenu = document.querySelector('.user-menu');
        
        if (topBar && userMenu) {
            topBar.insertBefore(themeToggle, userMenu);
        }
        
        // Check for saved theme
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        }
        
        // Add click event
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            
            // Update icon
            if (document.body.classList.contains('dark-theme')) {
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                localStorage.setItem('theme', 'dark');
            } else {
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                localStorage.setItem('theme', 'light');
            }
        });
        
        // Add CSS for dark theme
        const darkThemeStyles = document.createElement('style');
        darkThemeStyles.id = 'dark-theme-styles';
        darkThemeStyles.textContent = `
            .theme-toggle {
                cursor: pointer;
                padding: 8px;
                border-radius: 50%;
                background-color: #f0f0f0;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--accent-color);
                transition: all 0.3s ease;
            }
            
            .theme-toggle:hover {
                background-color: #e0e0e0;
            }
            
            body.dark-theme {
                --bg-color: #1a1a2e;
                --text-dark: #e6e6e6;
                --text-muted: #a0a0a0;
                --sidebar-color: #16213e;
                color: var(--text-dark);
            }
            
            body.dark-theme .subject-card,
            body.dark-theme .grade-card,
            body.dark-theme .deadlines-list,
            body.dark-theme .announcement-card,
            body.dark-theme .dropdown,
            body.dark-theme .notification-item,
            body.dark-theme .setting-item {
                background-color: #273349;
                border-color: #3a4556;
            }
            
            body.dark-theme .quarter-grade {
                background-color: #3a4556;
                color: #e6e6e6;
            }
            
            body.dark-theme .slider-dot {
                background-color: #3a4556;
            }
            
            body.dark-theme .progress-bar {
                background-color: #3a4556;
            }
            
            body.dark-theme .dropdown-header,
            body.dark-theme .dropdown-footer,
            body.dark-theme .notification-item,
            body.dark-theme .setting-item {
                border-color: #3a4556;
            }
            
            body.dark-theme .theme-toggle {
                background-color: #273349;
                color: #f0f0f0;
            }
            
            body.dark-theme .theme-toggle:hover {
                background-color: #3a4556;
            }
        `;
        document.head.appendChild(darkThemeStyles);
    }

    
    
});

function confirmExit() {
    document.getElementById("confirm-modal").style.display = "flex";
}
function closeModal(){
    document.getElementById('confirm-modal').style.display = "none";
}
function logout(e){
    e.preventDefault();  
    document.getElementById('logout-form').submit();
}