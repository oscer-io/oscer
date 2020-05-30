import Vue from 'vue';

// Misc
Vue.component('FieldWrapper', require('./FieldWrapper').default);

// Card
Vue.component('FormCard', require('./Form/Card').default);
Vue.component('DetailCard', require('./Detail/Card').default);

// Text Field
Vue.component('FormTextField', require('./Form/TextField').default);
Vue.component('DetailTextField', require('./Detail/TextField').default);
Vue.component('IndexTextField', require('./Index/TextField').default);

// Textarea Field
Vue.component('FormTextareaField', require('./Form/TextareaField').default);
Vue.component('DetailTextareaField', require('./Detail/TextareaField').default);
Vue.component('IndexTextareaField', require('./Index/TextareaField').default);

// Image Field
Vue.component('FormImageField', require('./Form/ImageField').default);
Vue.component('DetailImageField', require('./Detail/ImageField').default);
Vue.component('IndexImageField', require('./Index/ImageField').default);

// Tags Field
Vue.component('FormTagsField', require('./Form/TagsField').default);
Vue.component('DetailTagsField', require('./Detail/TagsField').default);
Vue.component('IndexTagsField', require('./Index/TagsField').default);

// Markdown Field
Vue.component('FormMarkdownField', require('./Form/MarkdownField').default);
Vue.component('DetailMarkdownField', require('./Detail/MarkdownField').default);
Vue.component('IndexMarkdownField', require('./Index/MarkdownField').default);

// Select Field
Vue.component('FormSelectField', require('./Form/SelectField').default);
Vue.component('DetailSelectField', require('./Detail/TextField').default);
Vue.component('IndexSelectField', require('./Index/TextField').default);

// Checkbox Field
Vue.component('FormCheckboxField', require('./Form/CheckboxField').default);

// CheckboxGroup Field
Vue.component('FormCheckboxGroupField', require('./Form/CheckboxGroupField').default);
Vue.component('DetailCheckboxGroupField', require('./Detail/CheckboxGroupField').default);
Vue.component('IndexCheckboxGroupField', require('./Index/CheckboxGroupField').default);

// Password Field @TODO What do we do on detail and index with the password ?
Vue.component('FormPasswordField', require('./Form/PasswordField').default);

// Menu Items Field @TODO What do we do on detail and index with the password ?
Vue.component('FormMenuItemsField', require('./Form/MenuItemsField').default);
