import Vue from 'vue';

import FieldWrapper from "../fields/FieldWrapper";
import TextField from "../fields/TextField";
import TextAreaField from "../fields/TextAreaField";
import PasswordField from "../fields/PasswordField";
import TagsField from "../fields/TagsField";

Vue.component('field-wrapper', FieldWrapper);
Vue.component('text-field', TextField);
Vue.component('textarea-field', TextAreaField);
Vue.component('password-field', PasswordField);
Vue.component('tags-field', TagsField);
