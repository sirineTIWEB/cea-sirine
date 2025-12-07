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

    // News Carousel Functionality
    initNewsCarousel();
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

// News carousel functionality
function initNewsCarousel() {
    // Get articles data from data attribute
    const carouselContainer = document.querySelector('[data-news-articles]');
    if (!carouselContainer) return;

    const articles = JSON.parse(carouselContainer.dataset.newsArticles);
    if (!articles || articles.length === 0) return;

    let currentIndex = 0;

    // Get DOM elements
    const mainCard = document.querySelector('.news-card');
    const prevCard = document.querySelector('.news-prevcard');
    const btnPrev = document.getElementById('btn-news-prev');
    const btnNext = document.getElementById('btn-news-next');

    if (!mainCard || !prevCard || !btnPrev || !btnNext) return;

    // Update main article display
    function updateMainArticle(index) {
        const article = articles[index];

        // Update thumbnail with animation
        const thumbnail = mainCard.querySelector('.news-thumbnail a');
        if (thumbnail && article.thumbnail) {
            thumbnail.href = article.permalink;
            const oldImg = thumbnail.querySelector('img');

            if (oldImg && article.thumbnail) {
                // Create new image element
                const newImg = document.createElement('img');
                newImg.src = article.thumbnail;
                newImg.alt = article.title;
                newImg.className = 'h-full w-auto object-cover slide-in-right';

                // Add old image slide-out animation
                oldImg.classList.add('slide-out-left');

                // Add new image to container
                thumbnail.appendChild(newImg);

                // After animation completes, remove old image
                setTimeout(() => {
                    oldImg.remove();
                    newImg.classList.remove('slide-in-right');
                }, 600);
            }
        }

        // Update date
        const date = mainCard.querySelector('.news-meta p');
        if (date) date.textContent = article.date;

        // Update read more link
        const readMore = mainCard.querySelector('.news-meta a');
        if (readMore) readMore.href = article.permalink;

        // Update title
        const title = mainCard.querySelector('h2 a');
        if (title) {
            title.href = article.permalink;
            title.textContent = article.title;
        }

        // Update excerpt
        const excerpt = mainCard.querySelector('.news-excerpt');
        if (excerpt) excerpt.textContent = article.excerpt;
    }

    // Update preview article display
    function updatePreviewArticle(index) {
        const article = articles[index];

        // Update date
        const date = prevCard.querySelector('p');
        if (date) date.textContent = article.date;

        // Update thumbnail with animation
        const thumbnail = prevCard.querySelector('.news-prevthumbnail a');
        if (thumbnail && article.thumbnail_medium) {
            thumbnail.href = article.permalink;
            const oldImg = thumbnail.querySelector('img');

            if (oldImg && article.thumbnail_medium) {
                // Create new image element
                const newImg = document.createElement('img');
                newImg.src = article.thumbnail_medium;
                newImg.alt = article.title;
                newImg.className = 'w-full h-full object-cover slide-in-right';

                // Add old image slide-out animation
                oldImg.classList.add('slide-out-left');

                // Add new image to container
                thumbnail.appendChild(newImg);

                // After animation completes, remove old image
                setTimeout(() => {
                    oldImg.remove();
                    newImg.classList.remove('slide-in-right');
                }, 600);
            }
        }
    }

    // Navigate to next article
    function nextArticle(e) {
        e.preventDefault();
        currentIndex = (currentIndex + 1) % articles.length;
        const previewIndex = (currentIndex + 1) % articles.length;

        updateMainArticle(currentIndex);
        updatePreviewArticle(previewIndex);
    }

    // Navigate to previous article
    function prevArticle(e) {
        e.preventDefault();
        currentIndex = (currentIndex - 1 + articles.length) % articles.length;
        const previewIndex = (currentIndex + 1) % articles.length;

        updateMainArticle(currentIndex);
        updatePreviewArticle(previewIndex);
    }

    // Attach event listeners
    btnNext.addEventListener('click', nextArticle);
    btnPrev.addEventListener('click', prevArticle);
}
