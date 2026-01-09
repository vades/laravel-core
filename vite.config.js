import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import path from 'path';

export default defineConfig(() => {
    // Check if SITE is defined
    const site = process.env.SITE;

    // Determine the public root
    // If SITE exists, resolve to external domain. If not, use default 'public'.
    const publicDir = site
        ? path.resolve(__dirname, '..', 'domains', site, 'public_html')
        : 'public';

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
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
