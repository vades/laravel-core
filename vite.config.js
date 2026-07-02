import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import path from 'path';
import dotenv from 'dotenv';

// Load .env into process.env before anything else
dotenv.config();
export default defineConfig(() => {
    // Check if SITE is defined
    //const site = process.env.MY_PROJECT_SLUG;
    const site = process.env.npm_config_site || process.env.MY_PROJECT_SLUG || undefined;
    console.log(`SITE environment variable: ${site}`);

    let mappedDomain;

    switch (site) {
        case 'ivnbg':
            mappedDomain = 'ivnbg.com';
            break;
        case 'vades':
            mappedDomain = 'vades.dev';
            break;
        case 'martinvach':
            mappedDomain = 'martinvach.com';
            break;
        default:
            mappedDomain = site;
            break;
    }

    const publicDir = mappedDomain
        ? path.resolve(__dirname, '..', 'domains', mappedDomain, 'public_html')
        : 'public';

    const domainResourceDir = site || 'default';

    console.log(`Using public directory: ${publicDir}`);

    return {
        plugins: [
            laravel({
                input: ['resources/css/'+ domainResourceDir  + '/app.css', 'resources/js/app.js'],
                refresh: true,

                // Pass the dynamic directory here
                publicDirectory: publicDir,

                // Keep this as 'build'. It will be appended to whichever publicDir is active.
                buildDirectory: 'build',
            }),
            tailwindcss(),
        ],
        build: {
            // Important: Allow Vite to empty a directory that is outside
            // the root of the current project
            emptyOutDir: true,
        },
        server: {
            cors: true,
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
    };
});
