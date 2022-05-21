const defaultTheme = require('tailwindcss/defaultTheme');



module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                head: ['Outfit'],
            },
            colors: {
                RFM: {
                    Light: '#62EEE4',
                    Cyan: '#00E0E3',
                    Cerulean: '#009FD3',
                    DarkBlue: '#004195',
                    Pear: '#CAD52B',
                    Forest: '#008E28',
                    ForestDark: '#004C20',
                    DarkGray: '#212121',
                    Black: '#161616',
                    LightGray: '#E1E1E1',
                    White: '#F1F1F1',
                    Newblue: '#033458',
                    Lightgreen: '#CAD52B',
                    Pink: '#F10051',
                    Pink_hover: '#ba003f',
                    Orange: '#EC4E12',
                    Gray: '#E6E6E6',
                    Green: '#24AB21'

                }
                },
        }
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },
    purge: {
        content: [
            './app/**/*.php',
            './resources/**/*.html',
            './resources/**/*.js',
            './resources/**/*.jsx',
            './resources/**/*.ts',
            './resources/**/*.tsx',
            './resources/**/*.php',
            './resources/**/*.vue',
            './resources/**/*.twig',
        ],
        options: {
            defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ]
};
