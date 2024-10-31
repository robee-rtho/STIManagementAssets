/** @type {import('tailwindcss').Config} */
export default {
  content: ['./resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',],
  theme: {
    extend: {colors: {
      'custom-color-card': 'rgba(12, 97, 145, 0.6)',
    'custom-color-main': 'rgba(12,97,145,0.9)'},
      
    }
  },
  plugins: [],
}

