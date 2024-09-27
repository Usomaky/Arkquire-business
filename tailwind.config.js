/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                Fraunces: ['Fraunces', 'sans-serif'],
                DMSans: ['DM Sans', 'sans-serif'],
            },
            colors: {
                'primary' : {
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    400: '#4ade80',
                    500: '#22c55e',
                }
            },
            
        },
        
    },
    plugins: [
        require('tailwind-scrollbar-hide'),
    ],
}

