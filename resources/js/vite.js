import { defineConfig } from 'vite';

const { default : vue } = await import(`${process.cwd()}/node_modules/@vitejs/plugin-vue/dist/index.mjs`);
const { default : laravel } = await import(`${process.cwd()}/node_modules/laravel-vite-plugin/dist/index.js`);

let plugins = [
    laravel.default([`${process.cwd()}/resources/js/app.js`]),
    vue({ template: { transformAssetUrls: { base : null, includeAbsolute : false } } }),
];

let aliases = {
    '@' : `${process.cwd()}/resources/vue`,
    vue : `${process.cwd()}/node_modules/vue/dist/vue.esm-bundler.js`,
};

export default defineConfig({
    plugins : plugins,
    build   : { chunkSizeWarningLimit : 1250 },
    resolve : { alias : aliases },
});