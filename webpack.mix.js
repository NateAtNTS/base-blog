const mix = require("laravel-mix");
require("dotenv").config();

let devProxy = process.env.BASE_URL;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 | https://laravel-mix.com/docs
 | https://github.com/JeffreyWay/laravel-mix
 |
 */

mix
    .setPublicPath("public")
    //.setResourceRoot('prefix/for/resource/locators')

    .browserSync({
        browser: "google chrome",
        proxy: devProxy,
        files: [
            "src/templates/**/*.twig",
            "src/templates/**/*.html",
            "public/assets/css/theme.css",
            "public/assets/js/theme.js"
        ]
    })

    /* Configure Larval Mix with the options we want.  */
    .options({
        /*
        hmrOptions: {
          host: "localhost",
          port: 8080
        },
        */

        //extractVueStyles: false,
        processCssUrls: false, // default true
        //terser: {},
        //purifyCss: false,
        //purifyCss: {},

        /* Configure Mix's built in PostCSS to use the plugins we want including tailwindcss and purgecss */
        postCss: [
            require("tailwindcss")("tailwind.config.js"),
            ...(mix.inProduction()
                ? [
                    require("@fullhuman/postcss-purgecss")({
                        content: [
                            "templates/**/*.html",
                            "templates/**/*.twig",
                            "mix/js/theme.js"
                        ],
                        extractors: [
                            {
                                // for tailwind classes without a "." in the name you can use the following match regex: /[A-z0-9-:\/]+/g
                                extractor: content => content.match(/[\w-/.:]+(?<!:)/g) || [],
                                extensions: ["html", "twig", "js"]
                            }
                        ],
                        whitelistPatterns: [
                            /^(js-|is-|has-|sticky-|responsive-|submenu-|first-|opens-|position-)/
                        ],
                        whitelistPatternsChildren: [
                            /^(js-|is-|has-|sticky-|responsive-|submenu-|first-|opens-|position-)/
                        ]
                    })
                ]
                : []),
            require("autoprefixer")()
        ],
        clearConsole: mix.inProduction() ? true : false,
        cssNano: {
            discardComments: { removeAll: true }
        }
    })

    /* Process SCSS and PostCSS */
    .sass("src/mix/css/theme.scss", "public/assets/css/", {
        sassOptions: {
            outputStyle: "expanded"
        }
    })

    /* JS */
    .js("src/mix/js/theme.js", "public/assets/js/");

// versioning in Production only
if (mix.inProduction()) {
    mix.version();
}