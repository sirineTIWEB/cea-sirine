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

    // Projects Carousel Functionality
    initProjectsCarousel();
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

// Projects Carousel
function initProjectsCarousel() {
    const projectsGrid = document.querySelector('.projects-grid');
    if (!projectsGrid) return;

    const projects = JSON.parse(projectsGrid.dataset.projects);
    if (projects.length <= 2) return; // No need for carousel if 2 or fewer projects

    const btnNavigate = document.getElementById('btn-projects-navigate');
    const projectCards = document.querySelectorAll('.project-card');

    let currentPairIndex = 0; // 0 means showing projects 0 and 1
    let direction = 'right';

    function updateProjects(index1, index2) {
        const card1 = projectCards[0];
        const card2 = projectCards[1];

        // Update first card
        updateProjectCard(card1, projects[index1], direction);

        // Update second card
        updateProjectCard(card2, projects[index2], direction);
    }

    function updateProjectCard(card, project, animDirection) {
        // Update date
        const dateElement = card.querySelector('h1 span');
        dateElement.textContent = project.date;

        // Update thumbnail with animation (same pattern as news carousel)
        let thumbnailDiv = card.querySelector('.project-thumbnail');

        // Ensure thumbnail div always exists to maintain layout
        if (!thumbnailDiv) {
            thumbnailDiv = document.createElement('div');
            thumbnailDiv.className = 'project-thumbnail';
            card.insertBefore(thumbnailDiv, card.querySelector('.project-content'));
        }

        const thumbnail = thumbnailDiv.querySelector('a');

        if (project.thumbnail) {
            if (thumbnail) {
                thumbnail.href = project.permalink;
                const oldImg = thumbnail.querySelector('img');

                if (oldImg) {
                    // Determine animation classes based on direction
                    const slideInClass = animDirection === 'right' ? 'slide-in-right' : 'slide-in-left';
                    const slideOutClass = animDirection === 'right' ? 'slide-out-left' : 'slide-out-right';

                    // Create new image element
                    const newImg = document.createElement('img');
                    newImg.src = project.thumbnail;
                    newImg.alt = project.title;
                    newImg.className = slideInClass;

                    // Add old image slide-out animation
                    oldImg.classList.add(slideOutClass);

                    // Add new image to container
                    thumbnail.appendChild(newImg);

                    // After animation completes, remove old image
                    setTimeout(() => {
                        oldImg.remove();
                        newImg.classList.remove(slideInClass);
                    }, 600);
                } else {
                    // No existing image, just add it
                    const newImg = document.createElement('img');
                    newImg.src = project.thumbnail;
                    newImg.alt = project.title;
                    thumbnail.appendChild(newImg);
                }
            } else {
                // No existing link, create the structure
                thumbnailDiv.innerHTML = `
                    <a href="${project.permalink}">
                        <img src="${project.thumbnail}" alt="${project.title}">
                    </a>
                `;
            }
        } else {
            // Keep the div but empty it to maintain spacing
            thumbnailDiv.innerHTML = '';
        }

        // Update title
        const titleLink = card.querySelector('h2 a');
        titleLink.href = project.permalink;
        titleLink.textContent = project.title;

        // Update excerpt
        const excerptElement = card.querySelector('.project-excerpt');
        if (project.excerpt) {
            if (excerptElement) {
                excerptElement.textContent = project.excerpt;
            } else {
                // Create excerpt element
                const newExcerpt = document.createElement('h3');
                newExcerpt.className = 'project-excerpt';
                newExcerpt.textContent = project.excerpt;
                card.querySelector('.project-content').insertBefore(
                    newExcerpt,
                    card.querySelector('.btn-secondary')
                );
            }
        } else {
            // Remove excerpt if none
            if (excerptElement) {
                excerptElement.remove();
            }
        }

        // Update button link
        const btnLink = card.querySelector('.btn-secondary');
        btnLink.href = project.permalink;
    }

    function navigate() {
        if (direction === 'right') {
            // Move forward by 2 to show next pair without overlap
            currentPairIndex += 2;

            // Check if we've reached or passed the last pair
            if (currentPairIndex + 1 >= projects.length) {
                // Adjust to show the last valid pair
                currentPairIndex = projects.length - 2;
                direction = 'left';
                btnNavigate.textContent = '←';
                btnNavigate.dataset.direction = 'left';
            }
        } else {
            // Move backward by 2
            currentPairIndex -= 2;

            // Check if we've reached the first pair
            if (currentPairIndex <= 0) {
                currentPairIndex = 0;
                direction = 'right';
                btnNavigate.textContent = '→';
                btnNavigate.dataset.direction = 'right';
            }
        }

        // Update the displayed projects
        const index1 = currentPairIndex;
        const index2 = currentPairIndex + 1;

        updateProjects(index1, index2);
    }

    // Attach event listener
    btnNavigate.addEventListener('click', navigate);
}
