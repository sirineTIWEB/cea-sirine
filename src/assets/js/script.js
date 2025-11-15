// Main JavaScript for theme-cea-prof

document.addEventListener('DOMContentLoaded', function() {
    console.log('Theme CEA Prof loaded');

    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-navigation');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
            mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Members Modal Functionality
    initMembresModal();
});

function initMembresModal() {
    const modal = document.getElementById('membre-modal');
    if (!modal) return;

    const modalContent = modal.querySelector('.modal-content');
    const modalDialog = modal.querySelector('.modal-dialog');
    const closeBtn = modal.querySelector('.modal-close');
    const viewButtons = document.querySelectorAll('.membre-view-btn');

    // Open modal
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const membreId = this.getAttribute('data-membre-id');
            const content = document.getElementById('modal-content-' + membreId);

            if (content && modalContent) {
                // Clone and inject content
                modalContent.innerHTML = content.innerHTML;

                // Show modal with animation
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden', 'false');

                // Prevent body scroll
                document.body.style.overflow = 'hidden';

                // Animate in
                setTimeout(() => {
                    modalDialog.style.opacity = '0';
                    modalDialog.style.transform = 'scale(0.95)';
                    modalDialog.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

                    requestAnimationFrame(() => {
                        modalDialog.style.opacity = '1';
                        modalDialog.style.transform = 'scale(1)';
                    });
                }, 10);
            }
        });
    });

    // Close modal function
    function closeModal() {
        // Animate out
        modalDialog.style.opacity = '0';
        modalDialog.style.transform = 'scale(0.95)';

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            modalContent.innerHTML = '';
        }, 300);
    }

    // Close button click
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Click outside to close
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // ESC key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}