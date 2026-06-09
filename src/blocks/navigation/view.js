document.addEventListener('DOMContentLoaded', function () {
    const navigations = document.querySelectorAll('.wp-block-divonex-navigation');

    navigations.forEach(function (nav) {
        const mobileBars = nav.querySelector('.mobile-bars');
        const mobileMenu = nav.querySelector('.divonex-mobile');
        const closeBtn = nav.querySelector('.close-btn');
        const overlay = nav.querySelector('.divonex-overlay');

        if (!mobileBars || !mobileMenu) return;

        mobileBars.addEventListener('click', function () {
            mobileMenu.classList.add('is-active');
            if (overlay) overlay.classList.add('is-active');
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                mobileMenu.classList.remove('is-active');
                if (overlay) overlay.classList.remove('is-active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function () {
                mobileMenu.classList.remove('is-active');
                overlay.classList.remove('is-active');
            });
        }
    });
});