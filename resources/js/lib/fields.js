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

Vue.component('FieldWrapper', FieldWrapper);
Vue.component('TextField', TextField);
Vue.component('CheckboxField', CheckboxField);
Vue.component('CheckboxGroupField', CheckboxGroupField);
Vue.component('TextareaField', TextAreaField);
Vue.component('PasswordField', PasswordField);
Vue.component('TagsField', TagsField);
Vue.component('MarkdownField', MarkdownField);
Vue.component('ImageField', ImageField);

import DetailTextField from '../components/details/TextField';
import DetailTextareaField from '../components/details/TextareaField';
import DetailImageField from '../components/details/ImageField';
import DetailCheckboxGroupField from '../components/details/CheckboxGroupField';
import DetailMarkdownField from '../components/details/MarkdownField'
import DetailTagsField from '../components/details/TagsField'

Vue.component('DetailTextField', DetailTextField);
Vue.component('DetailTextareaField', DetailTextareaField);
Vue.component('DetailImageField', DetailImageField);
Vue.component('DetailCheckboxGroupField', DetailCheckboxGroupField);
Vue.component('DetailMarkdownField', DetailMarkdownField);
Vue.component('DetailTagsField', DetailTagsField);

import IndexTextField from '../components/index/TextField';
import IndexTextareaField from '../components/index/TextareaField';
import IndexImageField from '../components/index/ImageField';
import IndexCheckboxGroupField from '../components/index/CheckboxGroupField';
import IndexMarkdownField from '../components/index/MarkdownField';
import IndexTagsField from '../components/index/TagsField';

Vue.component('IndexTextField', IndexTextField);
Vue.component('IndexTextareaField', IndexTextareaField);
Vue.component('IndexImageField', IndexImageField);
Vue.component('IndexCheckboxGroupField', IndexCheckboxGroupField);
Vue.component('IndexMarkdownField', IndexMarkdownField);
Vue.component('IndexTagsField', IndexTagsField);
