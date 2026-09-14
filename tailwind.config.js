import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f0f5ff',
                    100: '#e0ebff',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    navy: '#0f172a',
                    slate: '#1e293b',
                },
                syndic: {
                    primary: '#3b82f6',
                    secondary: '#0f172a',
                    accent: '#06b6d4',
                    bg: '#f8fafc',
                },
                status: {
                    success: '#10b981',
                    'success-bg': '#ecfdf5',
                    'success-text': '#047857',
                    warning: '#f59e0b',
                    'warning-bg': '#fffbeb',
                    'warning-text': '#b45309',
                    danger: '#ef4444',
                    'danger-bg': '#fef2f2',
                    'danger-text': '#b91c1c',
                    info: '#3b82f6',
                    'info-bg': '#eff6ff',
                    'info-text': '#1d4ed8',
                }
            },
            boxShadow: {
                'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                'card': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03)',
                'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04)',
            }
        },
    },

    plugins: [forms],
};
