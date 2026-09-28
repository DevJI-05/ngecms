import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import GasLayout from '@/layouts/GasLayout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

function resolveAppName(): string {
    try {
        const page = JSON.parse(
            document.getElementById('app')?.dataset.page ?? '{}',
        );

        return (
            page?.props?.siteSettings?.company_name ||
            import.meta.env.VITE_APP_NAME ||
            'Laravel'
        );
    } catch {
        return import.meta.env.VITE_APP_NAME || 'Laravel';
    }
}

const appName = resolveAppName();

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: () => GasLayout,
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
