/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                inter: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                border: 'hsl(var(--border))',
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                'pulse-glow': 'pulseGlow 2s infinite',
            },
            keyframes: {
                fadeInUp: {
                    '0%':   { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseGlow: {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgba(59, 130, 246, 0.4)' },
                    '50%':      { boxShadow: '0 0 0 8px rgba(59, 130, 246, 0)' },
                },
            },
            boxShadow: {
                'blue-lg': '0 10px 40px rgba(59, 130, 246, 0.2)',
            },
        },
    },
    plugins: [],
};
