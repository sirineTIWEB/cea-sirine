// GSAP Animations for CEA Theme
// Initialize GSAP and ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', function() {
    console.log('GSAP Animations initialized');

    // 1. Hero Section - Contenu textuel apparaît de gauche à droite avec opacity
    initHeroAnimations();

    // 2. Header Sections - Tous les header-section apparaissent de gauche à droite avec opacity
    initHeaderSectionAnimations();

    // 3. Activités à venir - Éléments apparaissent de bas en haut avec stagger
    initActivitiesAnimations();

    // 4. Actualités - Images/boutons en scale up, textes de droite à gauche
    initNewsAnimations();

    // 5. Projets - Cartes apparaissent de droite à gauche avec stagger
    initProjectsAnimations();

    // 6. Colonnes - Apparition de bas en haut, items dedans de droite à gauche
    initColumnsAnimations();
});

// 1. Hero Section Animations
function initHeroAnimations() {
    const heroSection = document.querySelector('.hero-section');
    if (!heroSection) return;

    // Animate header-title elements
    const headerTitle = heroSection.querySelector('.header-title');
    if (headerTitle) {
        const h1 = headerTitle.querySelector('h1');
        const h3 = headerTitle.querySelector('h3');

        if (h1) {
            gsap.set(h1, { x: -100, opacity: 0 });
            gsap.to(h1, {
                x: 0,
                opacity: 1,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: h1,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }

        if (h3) {
            gsap.set(h3, { x: -100, opacity: 0 });
            gsap.to(h3, {
                x: 0,
                opacity: 1,
                duration: 1,
                delay: 0.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: h3,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }
    }

    // Animate header button
    const headerBtn = heroSection.querySelector('.header-btn');
    if (headerBtn) {
        gsap.set(headerBtn, { x: -100, opacity: 0 });
        gsap.to(headerBtn, {
            x: 0,
            opacity: 1,
            duration: 1,
            delay: 0.4,
            ease: "power3.out",
            scrollTrigger: {
                trigger: headerBtn,
                start: "top 80%",
                toggleActions: "play none none none"
            }
        });
    }

    // Animate hero h2 content
    const heroH2 = heroSection.querySelector('h2');
    if (heroH2) {
        gsap.set(heroH2, { x: -100, opacity: 0 });
        gsap.to(heroH2, {
            x: 0,
            opacity: 1,
            duration: 1,
            delay: 0.6,
            ease: "power3.out",
            scrollTrigger: {
                trigger: heroH2,
                start: "top 80%",
                toggleActions: "play none none none"
            }
        });
    }
}

// 2. Header Section Animations (tous les .header-section)
function initHeaderSectionAnimations() {
    const headerSections = document.querySelectorAll('.header-section');

    headerSections.forEach((headerSection, index) => {
        // Skip the hero section's header-section (already animated)
        if (headerSection.closest('.hero-section')) return;

        const headerTitle = headerSection.querySelector('.header-title');
        const headerBtn = headerSection.querySelector('.header-btn');

        if (headerTitle) {
            const h1 = headerTitle.querySelector('h1');
            const h3 = headerTitle.querySelector('h3');

            if (h1) {
                gsap.set(h1, { x: -100, opacity: 0 });
                gsap.to(h1, {
                    x: 0,
                    opacity: 1,
                    duration: 1,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: h1,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }

            if (h3) {
                gsap.set(h3, { x: -100, opacity: 0 });
                gsap.to(h3, {
                    x: 0,
                    opacity: 1,
                    duration: 1,
                    delay: 0.2,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: h3,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }
        }

        if (headerBtn) {
            gsap.set(headerBtn, { x: -100, opacity: 0 });
            gsap.to(headerBtn, {
                x: 0,
                opacity: 1,
                duration: 1,
                delay: 0.4,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: headerBtn,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }
    });
}

// 3. Activités Animations - Bas en haut avec stagger pour les enfants
function initActivitiesAnimations() {
    const activityCards = document.querySelectorAll('.activity-card');
    if (activityCards.length === 0) return;

    activityCards.forEach((card) => {
        // Get all child elements
        const children = card.children;

        gsap.set(children, { y: 50, opacity: 0 });
        gsap.to(children, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.15,
            ease: "power3.out",
            scrollTrigger: {
                trigger: card,
                start: "top 80%",
                toggleActions: "play none none none"
            }
        });
    });
}

// 4. Actualités Animations - Images/boutons en scale, textes de droite à gauche
function initNewsAnimations() {
    const newsSection = document.querySelector('.news-section');
    if (!newsSection) return;

    // Main news card
    const newsCard = newsSection.querySelector('.news-card');
    if (newsCard) {
        // Thumbnail - Scale up
        const thumbnail = newsCard.querySelector('.news-thumbnail');
        if (thumbnail) {
            gsap.set(thumbnail, { scale: 0, opacity: 0 });
            gsap.to(thumbnail, {
                scale: 1,
                opacity: 1,
                duration: 0.8,
                ease: "back.out(1.7)",
                scrollTrigger: {
                    trigger: thumbnail,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }

        // News content texts - Right to left
        const newsContent = newsCard.querySelector('.news-content');
        if (newsContent) {
            // Button - Scale up
            const btn = newsContent.querySelector('.btn-secondary');
            if (btn) {
                gsap.set(btn, { scale: 0, opacity: 0 });
                gsap.to(btn, {
                    scale: 1,
                    opacity: 1,
                    duration: 0.6,
                    ease: "back.out(1.7)",
                    scrollTrigger: {
                        trigger: btn,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }

            // Date - Right to left
            const date = newsContent.querySelector('.news-meta p');
            if (date) {
                gsap.set(date, { x: 100, opacity: 0 });
                gsap.to(date, {
                    x: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: 0.2,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: date,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }

            // Title - Right to left
            const title = newsContent.querySelector('h2');
            if (title) {
                gsap.set(title, { x: 100, opacity: 0 });
                gsap.to(title, {
                    x: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: 0.3,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: title,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }

            // Excerpt - Right to left
            const excerpt = newsContent.querySelector('.news-excerpt');
            if (excerpt) {
                gsap.set(excerpt, { x: 100, opacity: 0 });
                gsap.to(excerpt, {
                    x: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: 0.4,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: excerpt,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }
        }
    }

    // Preview card thumbnail - Scale up
    const prevCard = newsSection.querySelector('.news-prevcard');
    if (prevCard) {
        const prevThumbnail = prevCard.querySelector('.news-prevthumbnail');
        if (prevThumbnail) {
            gsap.set(prevThumbnail, { scale: 0, opacity: 0 });
            gsap.to(prevThumbnail, {
                scale: 1,
                opacity: 1,
                duration: 0.8,
                ease: "back.out(1.7)",
                scrollTrigger: {
                    trigger: prevThumbnail,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }

        // Preview card date - Right to left
        const prevDate = prevCard.querySelector('p');
        if (prevDate) {
            gsap.set(prevDate, { x: 100, opacity: 0 });
            gsap.to(prevDate, {
                x: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: prevDate,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }
    }

    // Navigation buttons - Scale up
    const btnPrevCard = newsSection.querySelector('.btn-prevcard');
    if (btnPrevCard) {
        const buttons = btnPrevCard.querySelectorAll('button');
        buttons.forEach((btn, index) => {
            gsap.set(btn, { scale: 0, opacity: 0 });
            gsap.to(btn, {
                scale: 1,
                opacity: 1,
                duration: 0.6,
                delay: index * 0.1,
                ease: "back.out(1.7)",
                scrollTrigger: {
                    trigger: btn,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        });
    }
}

// 5. Projets Animations - Cartes de droite à gauche avec stagger
function initProjectsAnimations() {
    const projectCards = document.querySelectorAll('.project-card');
    if (projectCards.length === 0) return;

    gsap.set(projectCards, { x: 100, opacity: 0 });
    gsap.to(projectCards, {
        x: 0,
        opacity: 1,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out",
        scrollTrigger: {
            trigger: projectCards[0],
            start: "top 80%",
            toggleActions: "play none none none"
        }
    });

    // Navigation button - Scale up
    const btnNavigate = document.getElementById('btn-projects-navigate');
    if (btnNavigate) {
        gsap.set(btnNavigate, { scale: 0, opacity: 0 });
        gsap.to(btnNavigate, {
            scale: 1,
            opacity: 1,
            duration: 0.6,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: btnNavigate,
                start: "top 80%",
                toggleActions: "play none none none"
            }
        });
    }
}

// 6. Colonnes Animations - Colonnes de bas en haut, items dedans de droite à gauche
function initColumnsAnimations() {
    // Find all grid columns that might need animation
    const gridColumns = document.querySelectorAll('.grid-cols-12 > *[class*="col-"]');

    gridColumns.forEach((column) => {
        // Skip if it's already animated by another function
        if (column.closest('.hero-section') ||
            column.closest('.header-section') ||
            column.closest('.activity-card') ||
            column.closest('.news-card') ||
            column.closest('.project-card')) {
            return;
        }

        // Animate column itself from bottom to top
        gsap.set(column, { y: 50, opacity: 0 });
        gsap.to(column, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power3.out",
            scrollTrigger: {
                trigger: column,
                start: "top 85%",
                toggleActions: "play none none none"
            }
        });

        // Animate direct children from right to left with stagger
        const children = Array.from(column.children).filter(child => {
            // Only animate text elements, not structural divs
            return child.tagName === 'H1' ||
                   child.tagName === 'H2' ||
                   child.tagName === 'H3' ||
                   child.tagName === 'P' ||
                   child.tagName === 'A' ||
                   child.classList.contains('animate-item');
        });

        if (children.length > 0) {
            gsap.set(children, { x: 50, opacity: 0 });
            gsap.to(children, {
                x: 0,
                opacity: 1,
                duration: 0.6,
                stagger: 0.1,
                delay: 0.3,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: column,
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });
        }
    });
}
