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

    // Projets Page Carousel Functionality
    initProjetsCarousel();

    // Year Filter for Membres Page
    initYearFilter();

    // Membre Content Truncate
    initMembreContentTruncate();

    // Initialize button swipe animation
    initButtonSwipe();
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
                newImg.className = 'h-full w-auto object-cover hover:scale-110 transition-transform duration-300 slide-in-right';

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
                newImg.className = 'w-full h-full object-cover hover:scale-110 transition-transform duration-300 slide-in-right';

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
                    newImg.className = `hover:scale-110 transition-transform duration-300 ${slideInClass}`;

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
                    newImg.className = 'hover:scale-110 transition-transform duration-300';
                    thumbnail.appendChild(newImg);
                }
            } else {
                // No existing link, create the structure
                thumbnailDiv.innerHTML = `
                    <a href="${project.permalink}">
                        <img src="${project.thumbnail}" alt="${project.title}" class="hover:scale-110 transition-transform duration-300">
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

// Projets Page Carousel - Loop Effect with Active State at Row 7
function initProjetsCarousel() {
    const projGrid = document.querySelector('.proj-grid');
    if (!projGrid) return;

    const projetsData = JSON.parse(projGrid.dataset.newsArticles);
    if (!projetsData || projetsData.length === 0) return;

    let currentActiveIndex = 0;

    const btnPrev = document.getElementById('btn-proj-prev');
    const btnNext = document.getElementById('btn-proj-next');

    if (!btnPrev || !btnNext) return;

    const projCards = document.querySelectorAll('.proj-card');
    const projDates = document.querySelectorAll('.proj-date');

    // Set initial active state
    function setActiveCard(index, direction = 'next') {
        // Remove active class from all cards
        projCards.forEach(card => card.classList.remove('active'));

        // Add active class to current card
        if (projCards[index]) {
            projCards[index].classList.add('active');
        }

        // Update all cards with their data
        projCards.forEach((card, cardIndex) => {
            const dataIndex = (index + cardIndex) % projetsData.length;
            updateCard(card, projetsData[dataIndex], projDates[cardIndex], direction);
        });
    }

    // Update individual card content
    function updateCard(card, projet, dateElement, direction = 'next') {
        // Update thumbnail with slide animation
        const thumbnail = card.querySelector('.proj-thumbnail a');
        if (thumbnail && projet.thumbnail) {
            thumbnail.href = projet.permalink;
            const oldImg = thumbnail.querySelector('img');

            if (oldImg && projet.thumbnail) {
                const newImg = document.createElement('img');
                newImg.src = projet.thumbnail;
                newImg.alt = projet.title;

                // Choose animation based on direction
                if (direction === 'next') {
                    // Right arrow: slide from right to left
                    newImg.className = 'h-full w-auto object-cover hover:scale-110 transition-transform duration-300 slide-in-right';
                    oldImg.classList.add('slide-out-left');
                } else {
                    // Left arrow: slide from left to right
                    newImg.className = 'h-full w-auto object-cover hover:scale-110 transition-transform duration-300 slide-in-left';
                    oldImg.classList.add('slide-out-right');
                }

                thumbnail.appendChild(newImg);

                setTimeout(() => {
                    oldImg.remove();
                    newImg.classList.remove('slide-in-right', 'slide-in-left');
                }, 600);
            }
        }

        // Update title
        const titleLink = card.querySelector('.proj-content h2 a');
        if (titleLink) {
            titleLink.href = projet.permalink;
            titleLink.textContent = projet.title;
        }

        // Update content (h3)
        const contentElement = card.querySelector('.proj-content h3');
        if (contentElement && projet.content) {
            contentElement.innerHTML = projet.content;
        }

        // Update date element (only visible for active card)
        if (dateElement) {
            const dateP = dateElement.querySelector('p');
            if (dateP) {
                dateP.textContent = projet.date;
            }
        }
    }

    // Navigate to next project
    function nextProject(e) {
        e.preventDefault();
        currentActiveIndex = (currentActiveIndex + 1) % projetsData.length;
        setActiveCard(currentActiveIndex, 'next');
    }

    // Navigate to previous project
    function prevProject(e) {
        e.preventDefault();
        currentActiveIndex = (currentActiveIndex - 1 + projetsData.length) % projetsData.length;
        setActiveCard(currentActiveIndex, 'prev');
    }

    // Attach event listeners
    btnNext.addEventListener('click', nextProject);
    btnPrev.addEventListener('click', prevProject);

    // Initialize first active card
    setActiveCard(currentActiveIndex);
}

// Year Filter for Membres Page
function initYearFilter() {
    const select = document.getElementById('annee-select');
    const compositions = document.querySelectorAll('.composition-ca');
    const yearTitle = document.querySelector('.header-title h3');

    if (!select || compositions.length === 0) return;

    select.addEventListener('change', function() {
        const selectedIndex = this.value;
        const selectedOption = this.options[this.selectedIndex];
        const selectedYear = selectedOption.textContent.trim();

        // Hide all compositions
        compositions.forEach(function(composition) {
            composition.style.display = 'none';
        });

        // Show selected composition with fade effect
        const selectedComposition = document.querySelector('[data-composition-index="' + selectedIndex + '"]');
        if (selectedComposition) {
            selectedComposition.style.display = 'block';
            selectedComposition.style.opacity = '0';
            setTimeout(function() {
                selectedComposition.style.transition = 'opacity 0.3s ease-in-out';
                selectedComposition.style.opacity = '1';
            }, 10);
        }

        // Update the year in the title
        if (yearTitle) {
            yearTitle.textContent = 'Ses membres ' + selectedYear;
        }

        // Re-check truncation for the newly displayed composition
        setTimeout(function() {
            checkTruncation();
        }, 350); // After fade-in animation
    });
}

// Check truncation for all membre contents
function checkTruncation() {
    const membreContents = document.querySelectorAll('.membre-content');

    membreContents.forEach(function(content) {
        // Reset classes first
        content.classList.remove('truncated', 'expanded');

        // Check if content is truncated
        if (content.scrollHeight > content.clientHeight) {
            content.classList.add('truncated');
        }
    });
}

// Membre Content Truncate and Expand
function initMembreContentTruncate() {
    const membreContents = document.querySelectorAll('.membre-content');

    // Initial check
    setTimeout(function() {
        checkTruncation();
    }, 100);

    membreContents.forEach(function(content) {
        const wrapper = content.parentElement;
        const expandBtn = wrapper.querySelector('.membre-expand');
        let collapseTimeout;


        // Click on "...plus" to expand
        if (expandBtn) {
            expandBtn.addEventListener('click', function() {
                content.classList.add('expanded');
                content.classList.remove('truncated');
                expandBtn.style.display = 'none';

                // Set timeout to collapse after 20 seconds if mouse leaves
                collapseTimeout = setTimeout(function() {
                    collapseContent();
                }, 20000); // 20 seconds
            });
        }

        // Mouse leave handler
        content.addEventListener('mouseleave', function() {
            if (content.classList.contains('expanded')) {
                // Clear existing timeout first
                if (collapseTimeout) {
                    clearTimeout(collapseTimeout);
                }
                // Start 20-second countdown
                collapseTimeout = setTimeout(function() {
                    collapseContent();
                }, 20000); // 20 seconds
            }
        });

        // Mouse enter handler - cancel collapse
        content.addEventListener('mouseenter', function() {
            if (collapseTimeout) {
                clearTimeout(collapseTimeout);
                collapseTimeout = null;
            }
        });

        function collapseContent() {
            content.classList.remove('expanded');
            content.classList.add('truncated');
            if (expandBtn) {
                expandBtn.style.display = 'inline';
            }
        }
    });
}

// Initialize button swipe animation
function initButtonSwipe() {
    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-nav, .btn-nav-mobile');

    buttons.forEach(button => {
        // Skip select elements
        if (button.tagName === 'SELECT') return;
        // Get the text content (includes the arrow from CSS ::after)
        let text = button.textContent.trim();

        // Remove any existing arrow from the text if present
        text = text.replace(/\s*→\s*$/, '').trim();

        // Add arrow only for primary and secondary buttons, not nav or mobile nav
        const isNav = button.classList.contains('btn-nav') || button.classList.contains('btn-nav-mobile');
        const displayText = isNav ? text : text + ' →';

        // Store it in data attribute for CSS to use
        button.setAttribute('data-text', displayText);

        // For mobile nav, preserve the span structure
        if (button.classList.contains('btn-nav-mobile')) {
            button.innerHTML = `<span><div class="btn-text">${displayText}</div></span>`;
        } else {
            // Wrap the content in a div with class btn-text (not span to avoid span styling)
            button.innerHTML = `<div class="btn-text">${displayText}</div>`;
        }
    });
}
