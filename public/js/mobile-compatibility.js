/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
/**
 * Mobile vs Desktop Form Compatibility Fixes
 * Addresses differences in form handling between mobile and desktop browsers
 */

(function() {
    'use strict';

    // Device detection utility
    const DeviceUtils = {
        isMobile: function() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
                   (window.innerWidth <= 768);
        },
        
        isTouchDevice: function() {
            return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        },
        
        getDeviceType: function() {
            if (this.isMobile()) return 'mobile';
            if (this.isTouchDevice()) return 'tablet';
            return 'desktop';
        }
    };

    // Enhanced form validation with mobile compatibility
    const FormValidator = {
        init: function() {
            this.setupEventListeners();
            this.fixMobileInputIssues();
            this.setupTouchHandlers();
        },

        setupEventListeners: function() {
            // Use both input and change events for better mobile compatibility
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    this.enhanceForm(form);
                });
                
                // Handle dynamically added forms
                this.observeFormChanges();
            }.bind(this));
        },

        observeFormChanges: function() {
            // Watch for dynamically added forms
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1) { // Element node
                            if (node.tagName === 'FORM') {
                                this.enhanceForm(node);
                            } else if (node.querySelectorAll) {
                                const forms = node.querySelectorAll('form');
                                forms.forEach(form => {
                                    this.enhanceForm(form);
                                });
                            }
                        }
                    });
                });
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        },

        enhanceForm: function(form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                // Remove existing listeners to avoid duplicates
                input.removeEventListener('input', this.handleInput);
                input.removeEventListener('change', this.handleChange);
                input.removeEventListener('blur', this.handleBlur);
                
                // Add enhanced event listeners
                input.addEventListener('input', this.handleInput.bind(this), { passive: true });
                input.addEventListener('change', this.handleChange.bind(this), { passive: true });
                input.addEventListener('blur', this.handleBlur.bind(this), { passive: true });
                
                // Add touch-specific events for mobile
                if (DeviceUtils.isMobile()) {
                    input.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
                    input.addEventListener('touchend', this.handleTouchEnd.bind(this), { passive: true });
                }
            });

            // Enhanced form submission
            form.addEventListener('submit', this.handleSubmit.bind(this));
        },

        handleInput: function(event) {
            const input = event.target;
            this.validateField(input);
            this.updateSubmitButton(input.closest('form'));
            
            // Trigger change event for mobile compatibility
            if (DeviceUtils.isMobile()) {
                setTimeout(() => {
                    const changeEvent = new Event('change', { bubbles: true });
                    input.dispatchEvent(changeEvent);
                }, 100);
            }
        },

        handleChange: function(event) {
            const input = event.target;
            this.validateField(input);
            this.updateSubmitButton(input.closest('form'));
        },

        handleBlur: function(event) {
            const input = event.target;
            this.validateField(input, true); // Show errors on blur
        },

        handleTouchStart: function(event) {
            // Ensure input is focused properly on mobile
            const input = event.target;
            if (input.type === 'text' || input.type === 'email' || input.type === 'tel') {
                input.focus();
            }
        },

        handleTouchEnd: function(event) {
            // Prevent double-tap zoom on mobile
            event.preventDefault();
        },

        validateField: function(input, showErrors = false) {
            const value = input.value.trim();
            const isRequired = input.hasAttribute('required');
            const fieldType = input.type;
            let isValid = true;
            let errorMessage = '';

            // Required field validation
            if (isRequired && !value) {
                isValid = false;
                errorMessage = `${this.getFieldLabel(input)} is required`;
            }

            // Type-specific validation
            if (value && isValid) {
                switch (fieldType) {
                    case 'email':
                        if (!this.isValidEmail(value)) {
                            isValid = false;
                            errorMessage = 'Please enter a valid email address';
                        }
                        break;
                    case 'tel':
                    case 'text':
                        if (input.name === 'contactNo' || input.id === 'contactNo') {
                            if (!this.isValidPhone(value)) {
                                isValid = false;
                                errorMessage = 'Please enter a valid 11-digit mobile number starting with 09';
                            }
                        }
                        break;
                }
            }

            // Update field appearance
            this.updateFieldAppearance(input, isValid, errorMessage, showErrors);
            
            return isValid;
        },

        updateFieldAppearance: function(input, isValid, errorMessage, showError) {
            const container = input.closest('.input-field') || input.parentElement;
            let errorElement = container.querySelector('.error-message');
            
            // Remove existing error styling
            input.classList.remove('invalid', 'error');
            input.style.borderColor = '';
            
            if (!isValid && (showError || input.value.trim() !== '')) {
                input.classList.add('invalid');
                input.style.borderColor = '#9a3a44';
                
                // Show error message
                if (!errorElement) {
                    errorElement = document.createElement('div');
                    errorElement.className = 'error-message';
                    errorElement.style.color = '#9a3a44';
                    errorElement.style.fontSize = '14px';
                    errorElement.style.marginTop = '5px';
                    errorElement.style.display = 'block';
                    container.appendChild(errorElement);
                }
                errorElement.textContent = errorMessage;
            } else {
                // Hide error message
                if (errorElement) {
                    errorElement.remove();
                }
            }
        },

        updateSubmitButton: function(form) {
            if (!form) return;
            
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (!submitBtn) return;

            const isValid = this.isFormValid(form);
            submitBtn.disabled = !isValid;
            
            if (isValid) {
                submitBtn.style.backgroundColor = '#7a222b';
                submitBtn.style.cursor = 'pointer';
                submitBtn.classList.remove('disabled');
            } else {
                submitBtn.style.backgroundColor = '#d1a1a6';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.classList.add('disabled');
            }
        },

        isFormValid: function(form) {
            const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            for (let field of requiredFields) {
                if (!this.validateField(field)) {
                    return false;
                }
            }
            
            // Check radio button groups
            const radioGroups = form.querySelectorAll('input[type="radio"][required]');
            const radioGroupNames = [...new Set(Array.from(radioGroups).map(r => r.name))];
            
            for (let groupName of radioGroupNames) {
                if (!form.querySelector(`input[name="${groupName}"]:checked`)) {
                    return false;
                }
            }
            
            return true;
        },

        handleSubmit: function(event) {
            const form = event.target;
            const isValid = this.isFormValid(form);
            
            if (!isValid) {
                event.preventDefault();
                this.showFormErrors(form);
                return false;
            }
            
            // Enhanced form submission handling for different devices
            if (DeviceUtils.isMobile()) {
                event.preventDefault();
                
                // Disable submit button to prevent double submission
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Submitting...';
                }
                
                // Use requestAnimationFrame for better timing
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        form.submit();
                    }, 150);
                });
            } else {
                // Desktop handling - ensure proper validation
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    setTimeout(() => {
                        submitBtn.disabled = false;
                    }, 2000);
                }
            }
            
            return true;
        },

        showFormErrors: function(form) {
            const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (!this.validateField(field, true)) {
                    hasErrors = true;
                }
            });
            
            if (hasErrors) {
                // Scroll to first error on mobile
                if (DeviceUtils.isMobile()) {
                    const firstError = form.querySelector('.invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            }
        },

        // Utility functions
        isValidEmail: function(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },

        isValidPhone: function(phone) {
            return /^09[0-9]{9}$/.test(phone);
        },

        getFieldLabel: function(input) {
            const label = input.closest('.input-field')?.querySelector('label') ||
                         document.querySelector(`label[for="${input.id}"]`);
            return label ? label.textContent.replace('*', '').trim() : input.name;
        },

        fixMobileInputIssues: function() {
            if (!DeviceUtils.isMobile()) return;
            
            // Fix mobile input zoom issues
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"], input[type="date"]');
            inputs.forEach(input => {
                // Ensure font-size is at least 16px to prevent zoom on iOS
                const computedStyle = window.getComputedStyle(input);
                if (parseFloat(computedStyle.fontSize) < 16) {
                    input.style.fontSize = '16px';
                }
                
                // Fix iOS Safari autocomplete issues
                input.setAttribute('autocomplete', 'on');
                
                // Fix Android Chrome input issues
                if (navigator.userAgent.includes('Chrome')) {
                    input.style.transform = 'translateZ(0)';
                }
            });
            
            // Fix select dropdown issues on mobile
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.style.fontSize = '16px';
                select.setAttribute('autocomplete', 'on');
            });
        },

        setupTouchHandlers: function() {
            if (!DeviceUtils.isTouchDevice()) return;
            
            // Add touch-friendly styles
            const style = document.createElement('style');
            style.textContent = `
                input, select, textarea, button {
                    -webkit-tap-highlight-color: rgba(0,0,0,0.1);
                    touch-action: manipulation;
                }
                
                button:active {
                    transform: scale(0.98);
                    transition: transform 0.1s ease;
                }
                
                .invalid {
                    border-color: #9a3a44 !important;
                    box-shadow: 0 0 5px rgba(154, 58, 68, 0.3);
                }
                
                .error-message {
                    animation: fadeIn 0.3s ease-in;
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(-10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            FormValidator.init();
        });
    } else {
        FormValidator.init();
    }

    // Export for global access
    window.MobileFormCompatibility = {
        DeviceUtils: DeviceUtils,
        FormValidator: FormValidator
    };

})();
