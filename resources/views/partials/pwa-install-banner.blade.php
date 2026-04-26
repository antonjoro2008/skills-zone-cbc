{{-- PWA install ribbon: shown when app is not running as installed PWA and user has not dismissed. --}}
<div
    id="pwaInstallRibbon"
    role="region"
    aria-label="Install Gravity CBC app"
    class="hidden sticky top-16 z-[45] border-b border-white/25 shadow-lg"
>
    <div
        class="bg-gradient-to-r from-[#EC2834] via-[#E368A7] to-[#8FC340] text-white"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-3.5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                <div class="flex items-start gap-3 min-w-0">
                    <span
                        class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/20 ring-1 ring-white/30 backdrop-blur-sm"
                        aria-hidden="true"
                    >
                        <i class="fas fa-mobile-screen-button text-lg"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="font-bold text-sm sm:text-base tracking-tight">
                            Install GravityCBC App
                        </p>
                        <p
                            id="pwaInstallSubtext"
                            class="mt-0.5 text-xs sm:text-sm text-white/95 leading-snug max-w-2xl"
                        >
                            Add Gravity CBC to your home screen for faster access and an app-like experience.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2 shrink-0 sm:pl-2">
                    <button
                        type="button"
                        id="pwaInstallBtn"
                        class="hidden items-center justify-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-bold text-[#1e293b] shadow-md transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#8FC340]"
                    >
                        <i class="fas fa-download text-[#8FC340]" aria-hidden="true"></i>
                        <span>Install app</span>
                    </button>
                    <button
                        type="button"
                        id="pwaInstallDismiss"
                        class="inline-flex items-center justify-center rounded-full border border-white/50 bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    >
                        Not now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var DISMISS_KEY = 'gravitycbc_pwa_install_dismissed';
    var ribbon = document.getElementById('pwaInstallRibbon');
    var btnInstall = document.getElementById('pwaInstallBtn');
    var btnDismiss = document.getElementById('pwaInstallDismiss');
    var sub = document.getElementById('pwaInstallSubtext');

    if (!ribbon || !btnInstall || !btnDismiss) {
        return;
    }

    function isStandalone() {
        return (
            window.matchMedia('(display-mode: standalone)').matches ||
            window.matchMedia('(display-mode: fullscreen)').matches ||
            (typeof window.navigator.standalone === 'boolean' && window.navigator.standalone)
        );
    }

    function wasDismissed() {
        try {
            return window.localStorage.getItem(DISMISS_KEY) === '1';
        } catch (e) {
            return false;
        }
    }

    function isIos() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent) ||
            (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    }

    function canUseServiceWorker() {
        return (
            'serviceWorker' in navigator &&
            (location.protocol === 'https:' || location.hostname === 'localhost' || location.hostname === '127.0.0.1')
        );
    }

    var deferredPrompt = null;

    function showRibbon() {
        ribbon.classList.remove('hidden');
    }

    function hideRibbon() {
        ribbon.classList.add('hidden');
    }

    function registerSw() {
        if (!canUseServiceWorker()) {
            return;
        }
        navigator.serviceWorker
            .register(@json(asset('sw.js')))
            .catch(function () { /* non-fatal */ });
    }

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        btnInstall.classList.remove('hidden');
        btnInstall.classList.add('inline-flex');
        if (sub) {
            sub.textContent =
                'Install the app for one-tap access from your home screen — updates stay in sync automatically.';
        }
        showRibbon();
    });

    if (isStandalone() || wasDismissed()) {
        registerSw();
        return;
    }

    showRibbon();

    if (isIos() && sub) {
        sub.innerHTML =
            'On iPhone or iPad: tap <strong class="font-semibold text-white">Share</strong> ' +
            '<span class="opacity-90">(square and arrow)</span>, then ' +
            '<strong class="font-semibold text-white">Add to Home Screen</strong>.';
    }

    btnDismiss.addEventListener('click', function () {
        try {
            window.localStorage.setItem(DISMISS_KEY, '1');
        } catch (err) { /* ignore */ }
        hideRibbon();
    });

    btnInstall.addEventListener('click', function () {
        if (!deferredPrompt) {
            return;
        }
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then(function (choice) {
            if (choice.outcome === 'accepted') {
                try {
                    window.localStorage.setItem(DISMISS_KEY, '1');
                } catch (err) { /* ignore */ }
                hideRibbon();
            }
        }).finally(function () {
            deferredPrompt = null;
            btnInstall.classList.add('hidden');
            btnInstall.classList.remove('inline-flex');
        });
    });

    registerSw();
})();
</script>
