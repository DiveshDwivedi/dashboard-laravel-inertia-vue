/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'selector', // dark theme manuall config...
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        Montserrat: ["Montserrat", "serif"] // google font cdn added 
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'), // installed tailwind module for form
  ],
}

