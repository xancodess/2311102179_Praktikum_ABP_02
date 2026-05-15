/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                display: ['"Syne"', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'monospace'],
            },
            colors: {
                ink: {
                    50:  '#f4f4f5',
                    100: '#e4e4e7',
                    200: '#d4d4d8',
                    300: '#a1a1aa',
                    400: '#71717a',
                    500: '#52525b',
                    600: '#3f3f46',
                    700: '#27272a',
                    800: '#18181b',
                    900: '#09090b',
                },
                jade: {
                    50:  '#edfdf5',
                    100: '#d3f9e5',
                    200: '#aaf0ce',
                    300: '#73e2b1',
                    400: '#3acb8d',
                    500: '#17b171',
                    600: '#0d915b',
                    700: '#0b744b',
                    800: '#0c5c3d',
                    900: '#0b4c33',
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.4s ease-out',
                'slide-up': 'slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1)',
                'slide-in-right': 'slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(16px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
            },
            boxShadow: {
                'card': '0 1px 3px 0 rgba(0,0,0,.06), 0 1px 2px -1px rgba(0,0,0,.04)',
                'card-hover': '0 4px 16px 0 rgba(0,0,0,.08), 0 2px 4px -1px rgba(0,0,0,.04)',
                'modal': '0 20px 60px -10px rgba(0,0,0,.25)',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
