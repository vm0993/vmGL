const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");
const { styles } = require("@ckeditor/ckeditor5-dev-utils");
const CKERegex = {
    svg: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
    css: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css/,
};

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

Mix.listen("configReady", (webpackConfig) => {
    const rules = webpackConfig.module.rules;
    const targetSVG = /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/;
    const targetFont = /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/;
    const targetCSS = /\.p?css$/;

    for (let rule of rules) {
        if (rule.test.toString() === targetSVG.toString()) {
            rule.exclude = CKERegex.svg;
        } else if (rule.test.toString() === targetFont.toString()) {
            rule.exclude = CKERegex.svg;
        } else if (rule.test.toString() === targetCSS.toString()) {
            rule.exclude = CKERegex.css;
        }
    }
});

mix.js("resources/js/app.js", "public/dist/js")
    .sass("resources/sass/app.scss", "public/dist/css")
    .options({
        processCssUrls: false,
        postCss: [tailwindcss("./tailwind.config.js")],
    })
    .autoload({
        "cash-dom": ["cash"],
    })
    .webpackConfig({
        module: {
            rules: [
                {
                    test: CKERegex.svg,
                    use: ["raw-loader"],
                },
                {
                    test: CKERegex.css,
                    use: [
                        {
                            loader: "style-loader",
                            options: {
                                injectType: "singletonStyleTag",
                                attributes: {
                                    "data-cke": true,
                                },
                            },
                        },
                        "css-loader",
                        {
                            loader: "postcss-loader",
                            options: {
                                postcssOptions: styles.getPostCssConfig({
                                    themeImporter: {
                                        themePath: require.resolve(
                                            "@ckeditor/ckeditor5-theme-lark"
                                        ),
                                    },
                                    minify: true,
                                }),
                            },
                        },
                    ],
                },
            ],
        },
    })
    .copyDirectory("resources/json", "public/dist/json")
    .copyDirectory("resources/fonts", "public/dist/fonts")
    .copyDirectory("resources/images", "public/dist/images")
    .browserSync({
        proxy: "vima.test",
        files: ["resources/**/*.*"],
    });
