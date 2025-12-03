/**
 * Theme Switcher with Cookie Storage
 * Supports three modes: 'light', 'dark', 'auto'
 */

const THEME_COOKIE = 'theme_preference';
const THEME_AUTO = 'auto';
const THEME_LIGHT = 'light';
const THEME_DARK = 'dark';

/**
 * Get cookie value by name
 */
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

/**
 * Set cookie with 1 year expiration
 */
function setCookie(name, value) {
    const expires = new Date();
    expires.setFullYear(expires.getFullYear() + 1);
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
}

/**
 * Check if system prefers dark mode
 */
function systemPrefersDark() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

/**
 * Apply theme to document
 */
function applyTheme(theme) {
    const isDark = theme === THEME_DARK || (theme === THEME_AUTO && systemPrefersDark());

    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

/**
 * Get current theme preference
 */
function getThemePreference() {
    const saved = getCookie(THEME_COOKIE);
    return saved || THEME_AUTO;
}

/**
 * Set theme preference and apply it
 */
function setThemePreference(theme) {
    setCookie(THEME_COOKIE, theme);
    applyTheme(theme);
    updateThemeButton(theme);
}

/**
 * Update theme button text/icon
 */
function updateThemeButton(theme) {
    const button = document.getElementById('theme-switcher-btn');
    if (!button) return;

    const icons = {
        [THEME_LIGHT]: '☀️',
        [THEME_DARK]: '🌙',
        [THEME_AUTO]: '🔄'
    };

    const labels = {
        [THEME_LIGHT]: 'Light',
        [THEME_DARK]: 'Dark',
        [THEME_AUTO]: 'Auto'
    };

    button.innerHTML = `${icons[theme]} <span class="ml-1">${labels[theme]}</span>`;
}

/**
 * Cycle to next theme: auto -> light -> dark -> auto
 */
function cycleTheme() {
    const current = getThemePreference();
    let next;

    if (current === THEME_AUTO) {
        next = THEME_LIGHT;
    } else if (current === THEME_LIGHT) {
        next = THEME_DARK;
    } else {
        next = THEME_AUTO;
    }

    setThemePreference(next);
}

/**
 * Initialize theme on page load
 */
function initTheme() {
    const theme = getThemePreference();
    applyTheme(theme);
    updateThemeButton(theme);

    // Listen for system theme changes when in auto mode
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (getThemePreference() === THEME_AUTO) {
                applyTheme(THEME_AUTO);
            }
        });
    }
}

// Run immediately to prevent flash
initTheme();

// Export for global use
window.cycleTheme = cycleTheme;
window.initTheme = initTheme;
