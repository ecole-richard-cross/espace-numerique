const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/scripts/app.js')

    .addEntry('symfony-collection', './assets/scripts/symfony-collection.js')
    .addEntry('profile-error-feedback', './assets/scripts/profile-error-feedback.js')
    .addEntry('register_country_switch', './assets/scripts/register_country_switch.js')
    .addEntry('new_avatar_preview', './assets/scripts/new_avatar_preview.js')
    .addEntry('tag-select', './assets/scripts/tag-select.js')
    .addEntry('seminar-filter', './assets/scripts/seminar-filter.js')
    .addEntry('seminar-nav', './assets/scripts/seminar-nav.js')

    .addEntry('trix_toolbar_handler', './assets/scripts/trix_toolbar_handler.js')
    .addEntry('comment_reply', './assets/scripts/comment_reply.js')
    .addStyleEntry('new_discussion_form', './assets/styles/new_discussion_form.scss')

    .addEntry('ea-block-form', './assets/scripts/admin/ea-block-form.js')
    .addEntry('ea-consultation-no-duplicates', './assets/scripts/admin/ea-consultation-no-duplicates.js')
    .addEntry('ea-force-media-type-value', './assets/scripts/admin/ea-force-media-type-value.js')
    .addEntry('ea-media-form', './assets/scripts/admin/ea-media-form.js')
    .addEntry('ea-nested-text-editor-fix', './assets/scripts/admin/ea-nested-text-editor-fix.js')
    .addEntry('remove-xml-batch-popup', './assets/scripts/admin/remove-xml-batch-popup.js')

    .addStyleEntry('fontawesome', '/assets/styles/fontawesome/css/all.css')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push("@babel/plugin-syntax-jsx");
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    // .enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // add a plugin
    // .addPlugin()

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]'
    })
    ;

module.exports = Encore.getWebpackConfig();
