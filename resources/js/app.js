import LaravelCms from './lib/LaravelCms.js';

LaravelCms
    .loadGlobalMixins()
    .loadBaseComponents()
    .loadGlobalPlugins()
    .registerFlash()
    .setContainer('#app')
    .activateInternationalization()
    .activateInertia()
    .activateVueTailwind()
    .start();
