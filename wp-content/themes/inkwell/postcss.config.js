module.exports = {
    plugins: [
        require('tailwindcss')(require('path').join(__dirname, 'tailwind.config.js')),
        require('autoprefixer'),
    ],
};
