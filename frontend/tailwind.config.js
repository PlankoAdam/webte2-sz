/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        shakespeare: {
          50: '#f4f6fb',
          100: '#e7edf7',
          200: '#cad8ed',
          300: '#9cb6dd',
          400: '#6690ca',
          500: '#416faf',
          600: '#325a97',
          700: '#29487b',
          800: '#253e67',
          900: '#243656',
          950: '#182339'
        }
      }
    }
  },
  plugins: [
    function ({ addBase, theme }) {
      function extractColorVars(colorObj, colorGroup = '') {
        return Object.keys(colorObj).reduce((vars, colorKey) => {
          const value = colorObj[colorKey]

          const newVars =
            typeof value === 'string'
              ? { [`--color${colorGroup}-${colorKey}`]: value }
              : extractColorVars(value, `-${colorKey}`)

          return { ...vars, ...newVars }
        }, {})
      }

      addBase({
        ':root': extractColorVars(theme('colors'))
      })
    }
  ]
}
