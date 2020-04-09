import Vue from 'vue';

import FieldWrapper from "../fields/FieldWrapper";
import TextField from "../fields/TextField";
import CheckboxField from "../fields/CheckboxField";
import CheckboxGroupField from "../fields/CheckboxGroupField";
import TextAreaField from "../fields/TextAreaField";
import PasswordField from "../fields/PasswordField";
import TagsField from "../fields/TagsField";
import MarkdownField from "../fields/MarkdownField";
import ImageField from "../fields/ImageField";

Vue.component('field-wrapper', FieldWrapper);
Vue.component('text-field', TextField);
Vue.component('checkbox-field', CheckboxField);
Vue.component('checkbox-group-field', CheckboxGroupField);
Vue.component('textarea-field', TextAreaField);
Vue.component('password-field', PasswordField);
Vue.component('tags-field', TagsField);
Vue.component('markdown-field', MarkdownField);
Vue.component('image-field', ImageField);
