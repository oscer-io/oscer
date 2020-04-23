import Vue from "vue";
import VueI18n from 'vue-i18n';
import languageBundle
    from '@kirschbaum-development/laravel-translations-loader/php?parameters={{ $1 }}!@kirschbaum-development/laravel-translations-loader';

Vue.use(VueI18n);

export default new VueI18n({
    // the locale needs to be filled dynamically
    locale: window.locale,
    messages: languageBundle,
});
