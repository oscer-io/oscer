import Vue from 'vue'

// Import frequently used (base) components globally & automatically
const baseComponents = require.context('../components', true, /Base[A-Z]\w+\.(vue|js)$/);
baseComponents.keys().forEach(fileName => {
    const baseComponent = baseComponents(fileName);
    const baseComponentName = baseComponent.name || (
        fileName
            .split('/')
            .pop()
            .replace(/\.\w+$/, '')
    );
    Vue.component(
        baseComponentName,
        baseComponent.default || baseComponent
    )
});
