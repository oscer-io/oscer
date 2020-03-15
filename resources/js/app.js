import LaravelCms from './lib/LaravelCms.js';

LaravelCms
    .loadMixins()
    .loadBaseComponents()
    .loadDirectives()
    .registerFlash()
    .setContainer('#app')
    .activateInternationalization()
    .activateInertia()
    .start();
