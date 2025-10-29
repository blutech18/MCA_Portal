{{-- Modern Toast Notification System --}}
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; flex-direction: column; gap: 10px;"></div>

{{-- Modern Confirmation Modal --}}
<div id="confirmation-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 16px; padding: 0; max-width: 480px; width: 90%; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); overflow: hidden;">
        {{-- Header with accent border --}}
        <div id="modal-header" style="background: linear-gradient(135deg, #7a222b 0%, #5a1a20 100%); padding: 24px 32px; border-bottom: none;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div id="modal-icon" style="width: 56px; height: 56px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-size: 28px; border: 2px solid rgba(255, 255, 255, 0.3);"></div>
                <h3 id="modal-title" style="margin: 0; color: white; font-size: 22px; font-weight: 600; letter-spacing: -0.3px;"></h3>
            </div>
        </div>
        
        {{-- Body --}}
        <div style="padding: 32px; background: #fafafa;">
            <p id="modal-message" style="color: #4a5568; margin: 0; line-height: 1.7; font-size: 15px; font-weight: 400;"></p>
        </div>
        
        {{-- Footer --}}
        <div style="background: white; padding: 20px 32px; border-top: 1px solid #e5e7eb; display: flex; gap: 12px; justify-content: flex-end;">
            <button id="modal-cancel" style="padding: 12px 28px; background: #f9fafb; color: #374151; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s; min-width: 100px;"
                    onmouseover="this.style.background='#f3f4f6'" 
                    onmouseout="this.style.background='#f9fafb'">Cancel</button>
            <button id="modal-confirm" style="padding: 12px 28px; background: #7a222b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s; min-width: 100px;"
                    onmouseover="this.style.background='#5a1a20'" 
                    onmouseout="this.style.background='#7a222b'">Confirm</button>
        </div>
    </div>
</div>

<script>
    // Toast Notification System
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        const colors = {
            success: { bg: '#10b981', icon: '✓' },
            error: { bg: '#ef4444', icon: '✕' },
            warning: { bg: '#f59e0b', icon: '⚠' },
            info: { bg: '#3b82f6', icon: 'ℹ' }
        };
        
        const config = colors[type] || colors.info;
        
        toast.style.cssText = `
            background: white;
            border-left: 4px solid ${config.bg};
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
            min-width: 300px;
        `;
        
        toast.innerHTML = `
            <div style="background: ${config.bg}; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                ${config.icon}
            </div>
            <div style="flex: 1;">
                <div style="font-weight: 500; color: #2b0f12; margin-bottom: 4px;">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                <div style="color: #666; font-size: 14px;">${message}</div>
            </div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #999; cursor: pointer; font-size: 20px; line-height: 1;">×</button>
        `;
        
        container.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
        
        return toast;
    }
    
    // Confirmation Modal System
    function showConfirmation(title, message, icon = 'question') {
        return new Promise((resolve) => {
            const modal = document.getElementById('confirmation-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const modalIcon = document.getElementById('modal-icon');
            const confirmBtn = document.getElementById('modal-confirm');
            const cancelBtn = document.getElementById('modal-cancel');
            
            // Set content
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            
            // Set icon based on type
            const iconConfig = {
                question: { icon: '❓' },
                warning: { icon: '⚠️' },
                danger: { icon: '⚠️' },
                success: { icon: '✓' }
            };
            
            const config = iconConfig[icon] || iconConfig.question;
            modalIcon.textContent = config.icon;
            
            // Show modal
            modal.style.display = 'flex';
            
            // Event handlers
            const cleanup = () => {
                modal.style.display = 'none';
                confirmBtn.onclick = null;
                cancelBtn.onclick = null;
            };
            
            confirmBtn.onclick = () => {
                cleanup();
                resolve(true);
            };
            
            cancelBtn.onclick = () => {
                cleanup();
                resolve(false);
            };
        });
    }
    
    // Animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>

