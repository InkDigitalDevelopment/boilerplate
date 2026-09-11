/** @type {import('tailwindcss').Config} */
module.exports = {
    content: {
        relative: true,
        files: [
            './*.php',
            './inc/**/*.php',
            './template-parts/**/*.php',
            './page-templates/**/*.php',
            './src/**/*.{js,mjs,ts,jsx,tsx}',
            './blocks/**/*.{php,js,mjs,json}',
        ],
    },
    theme: {
        extend: {
            screens: {
                '2xl': '1500px',
                '3xl': '1940px',
            },            
        }
    },
    plugins: []
};
