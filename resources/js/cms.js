import LaravelCms from './lib/cms';

/**
 * We create a factory on the window which can create a new LaravelCms instance
 */
(function () {
    this.CmsFactory = function (config) {
        return new LaravelCms(config)
    }
}).call(window);
