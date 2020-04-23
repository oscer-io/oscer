import Cms from './lib/cms';

/**
 * Register all global mixins, components and fields
 */
import './lib/mixins';
import './lib/components';
import './lib/fields';

/**
 * We create a factory on the window which can create a new Cms instance
 */
(function () {
    this.CreateCms = function (config) {
        return new Cms(config)
    }
}).call(window);
