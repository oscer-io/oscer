import LaravelCms from './bootstrap/LaravelCms.js';

LaravelCms
    .loadMixins()
    .loadBaseComponents()
    .loadDirectives()
    .registerFlash()
    .setContainer('#app')
    .activateInternationalization()
    .activateInertia()
    .start();
