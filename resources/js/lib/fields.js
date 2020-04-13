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
import SelectField from "../components/fields/SelectField";

Vue.component('FieldWrapper', FieldWrapper);
Vue.component('TextField', TextField);
Vue.component('CheckboxField', CheckboxField);
Vue.component('CheckboxGroupField', CheckboxGroupField);
Vue.component('SelectField', SelectField);
Vue.component('TextareaField', TextAreaField);
Vue.component('PasswordField', PasswordField);
Vue.component('TagsField', TagsField);
Vue.component('MarkdownField', MarkdownField);
Vue.component('ImageField', ImageField);
