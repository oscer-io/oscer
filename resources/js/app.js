import Cms from './lib/cms';

/**
 * Register all global components and fields
 */
import './lib/components';
import './lib/fields';

/**
 * We create a factory on the window which can create a new LaravelCms instance
 */
(function () {
    this.CreateCms = function (config) {
        return new Cms(config)
    }
}).call(window);
