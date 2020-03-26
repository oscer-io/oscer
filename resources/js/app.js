import Cms from './lib/cms';

/**
 * We create a factory on the window which can create a new LaravelCms instance
 */
(function () {
    this.CreateCms = function (config) {
        return new Cms(config)
    }
}).call(window);
