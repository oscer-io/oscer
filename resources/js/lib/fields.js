import Vue from 'vue';

import FieldWrapper from "../components/fields/FieldWrapper";
import TextField from "../components/fields/TextField";
import CheckboxField from "../components/fields/CheckboxField";
import CheckboxGroupField from "../components/fields/CheckboxGroupField";
import TextAreaField from "../components/fields/TextAreaField";
import PasswordField from "../components/fields/PasswordField";
import TagsField from "../components/fields/TagsField";
import MarkdownField from "../components/fields/MarkdownField";
import ImageField from "../components/fields/ImageField";

Vue.component('field-wrapper', FieldWrapper);
Vue.component('text-field', TextField);
Vue.component('checkbox-field', CheckboxField);
Vue.component('checkbox-group-field', CheckboxGroupField);
Vue.component('textarea-field', TextAreaField);
Vue.component('password-field', PasswordField);
Vue.component('tags-field', TagsField);
Vue.component('markdown-field', MarkdownField);
Vue.component('image-field', ImageField);
