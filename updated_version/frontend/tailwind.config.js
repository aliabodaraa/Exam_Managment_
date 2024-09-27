const path = require('path');
// const colors = require('tailwindcss/colors');
// const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  content: ['./src/**/*.{html,scss,ts,js}'],
  darkMode: "class",
  important: true,
  theme: {
    extend: {
      colors: {
        //primary
        'midnight-blue': '#033444',
        'teal': '#1C4B5D',
        'dark-turquoise': '#397D8A',
        'turquoise': '#0C97A8',
        'Blue': '#136298',
        //secondary
        'green': '#009D66',
        'dark-green': '#005247',
        'sage': '#418178',
        'olive-green': '#689F5B',
        'periwinkle': '#63698A',
        //special
        'mint-green': '#84C5BE',
        'aqua': '#4CA7CE',
        'lime-green': '#80B780',
        'medium-jungle-green': '#172D35',
        'rich-black': '#083240',
        'erie-black': '#1E1C1C',
        'munsell-blue': '#009DAD',
        'shadow-blue': '#7095A1',
        'slate-gray': '#668399',
        'light-turquoise': '#D0EFF3',
        'japanese-indigo': '#164158',
        'burnished-brown': '#A1A8B7',
        'licorice': '#160D0D',
        'state-green': '#033333',
        'raisin-black': '#252323',
        'chinese-black': '#141517',
        'police-blue': '#34505F',
        'dark-gunmetal': '#15262D',
        'bright-gray': '#E9E9E9',
        'granite-gray': '#656565',
        'lavender': '#E3E7F6',
        'charcol': '#35444E',
        'warn': '#DC2626',
        'cadet-blue': '#abb7cb',
        'middle-blue': '#80CCDD',
        'cg-blue': '#00759A',
        'yankees-blue': '#122944',
        'spanish-gray': '#95989A',
        'moonstone-blue': '#75a6bf',
        'peru': '#d57e49',
        'azureish-White': '#D9EAF0',
        'white-gray': '#E6E6E6',
        'dark-gray': '#B2B2B2',
        'white-smoke': '#F5F5F5',
        'maastricht-blue': '#0A2736',
        'dark-blue': '#0c4566',
        'light-gray': '#D5D5D5',
        'white-lotion': '#FAFAFA',
        'dark-silver': '#707070',
        'silver-chalice': '#aaabab',
        'dark-moonstone-blue': '#6db1c1',
        'dark-accent': '#022334',
        'white-dark': '#757575',
        'white-gray': '#D9D9D9',
        'antiFlash-white': '#F0F0F0',
        'blue-gray': '#909FBA',
        'dark-liver': '#4D4D4D',
        'whitesmoke-gray': '#e2e6ef',
        'orange': "#e68648",
        'dusky-blue': '#023444',
        'transparent-gray': '#242323',
        'dusky-gray': '#222425',
        'dusky-white': '#B7C2C5',
        'anti-flash-white': '#F2F2F2',
        'primary-Text': '#011D26'
      },
      backgroundImage: {
        'midnight-blue-to-300': 'linear-gradient(#033444 0%, #397D8A 100%)',
        'darkGreen-to-richBlack': 'linear-gradient(45deg, #0f162c, #043e3f)',
        'midnightBlue-to-turquoise': 'linear-gradient(180deg, #033444 0%, #0C97A8 100%)'
      },
      fontFamily: {
        'DIN-Next-LT': 'DIN Next LT',
      },
      fontSize: {
        '1.5xl': '22px',
        '2.5xl': '26px',
        '2.75xl': '28px',
        'xxsmall': '10px',
        'md': '16px',
        'md-extra': '18px',
        'xxxs': '9px',
        'xxxxs': '8px',
      },
      zIndex: {
        '-1': -1,
        '49': 49,
        '60': 60,
        '70': 70,
        '80': 80,
        '90': 90,
        '99': 99,
        '999': 999,
        '9999': 9999,
        '99999': 99999
      },
      lineHeight: {
        '12': '3rem'
      },
      extendedSpacing: {
        // Fractional values
        '1/2': '50%',
        '1/3': '33.333333%',
        '2/3': '66.666667%',
        '1/4': '25%',
        '2/4': '50%',
        '3/4': '75%',

        //missing values
        '15': '3.75rem',
        '43': '10.75rem',
        '47': '10.75rem',
        '50': '12.75rem',
        '65': '16.25rem',
        '68': '17rem',
        '70': '17.5rem',
        '71 ': '17.75rem',
        '75': '18.75rem',
        // Bigger values
        '100': '25rem',
        '110': '27.5rem',
        '120': '30rem',
        '125': '31.25rem',
        '128': '32rem',
        '140': '35rem',
        '154': '37.5rem',
        '155': '38.6rem',
        '160': '40rem',
        '180': '45rem',
        '192': '48rem',
        '200': '50rem',
        '213': '53.125rem',
        '233': '58.125rem',
        '240': '60rem',
        '243': '60.625rem',
        '256': '64rem',
        '280': '70rem',
        '320': '80rem',
        '360': '90rem',
        '400': '100rem',
        '480': '120rem',


      },
      height: theme => ({
        ...theme('extendedSpacing')
      }),
      minHeight: theme => ({
        ...theme('spacing'),
        ...theme('extendedSpacing')
      }),
      maxHeight: theme => ({
        ...theme('extendedSpacing'),
        none: 'none'
      }),
      width: theme => ({
        ...theme('extendedSpacing')
      }),
      minWidth: theme => ({
        ...theme('spacing'),
        ...theme('extendedSpacing'),
        screen: '100vw'
      }),
      maxWidth: theme => ({
        ...theme('spacing'),
        ...theme('extendedSpacing'),
        screen: '100vw'
      }),
      screens: {
        print: { 'raw': 'print' },
        sm: '600px',
        md: '960px',
        lg: '1280px',
        xl: '1440px',
        'ipad-mini-hor': { 'width': '1024px' },
        'ipad-air-hor': { 'width': '1180px' },
        'ipad-pro-hor': { 'width': '1366px' },
        'widescreen': { 'raw': '(min-aspect-ratio: 3/2)' },
        'tallscreen': { 'raw': '(max-aspect-ratio: 13/20)' }
      },
      keyframes: {
        'open-menu': {
          '0%': { transform: 'scaleY(0)' },
          '80%': { transform: 'scaleY(1.2)' },
          '100%': { transform: 'scaleY(1)' },
        },
        animation: {
          'open-menu': 'open-menu 0.5s ease-in-out forwards'
        }
      }
    },
  },
  plugins: [
    require(path.resolve(__dirname, ('src/app/tailwind/plugins/icon-size'))),
  ],
}
