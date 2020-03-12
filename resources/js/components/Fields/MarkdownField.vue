<template>
    <div>
        <div class="markdown-toolbar">
            <div class="markdown-modes my-3">
                <ul class="flex border-b">
                    <li class="-mb-px mr-1">
                        <button type="button" @click="mode = 'write'"
                                :class="( mode === 'write' ? 'active bg-white text-indigo-700 ': 'border-transparent ') +
                                    'py-1 px-2 inline-block border-l border-t border-r rounded-t text-indigo-500 hover:text-blue-800 font-semibold focus:outline-none'">
                            Write
                        </button>
                    </li>
                    <li class="-mb-px mr-1">
                        <button type="button" @click="mode = 'preview'"
                                :class="( mode === 'preview' ? 'active bg-white text-indigo-700 ': 'border-transparent ') +
                                    'py-1 px-2 inline-block border-l border-t border-r rounded-t text-indigo-500 hover:text-blue-800 font-semibold focus:outline-none'">
                            Preview</button>
                    </li>
                </ul>
            </div>
        </div>
        <div v-show="mode === 'write'" class="editor" ref="codemirror"></div>
        <div v-show="mode === 'preview'" v-html="markdownPreviewText" class="markdown-preview clean-content"></div>
    </div>
</template>
<script>
    let CodeMirror = require('codemirror');

    require('codemirror/addon/edit/closebrackets');
    require('codemirror/addon/edit/matchbrackets');
    require('codemirror/addon/display/autorefresh');
    require('codemirror/mode/htmlmixed/htmlmixed');
    require('codemirror/mode/xml/xml');
    require('codemirror/mode/markdown/markdown');
    require('codemirror/mode/gfm/gfm');
    require('codemirror/mode/javascript/javascript');
    require('codemirror/mode/css/css');
    require('codemirror/mode/clike/clike');
    require('codemirror/mode/php/php');
    require('codemirror/mode/yaml/yaml');
    require('codemirror/addon/edit/continuelist');

    // Keymaps
    import 'codemirror/lib/codemirror.css'
    import 'codemirror/keymap/sublime'

    export default {
        props: {
            value: String
        },
        data: function () {
            return {
                data: this.value || '',
                mode: 'write',
                codemirror: null, // the CodeMirror instance
            };
        },
        watch: {
            data(data) {
                this.update(data);
            },
        },
        mounted() {
            let self = this;

            self.codemirror = CodeMirror(this.$refs.codemirror, {
                value: self.data,
                mode: 'gfm',
                keyMap: 'sublime',
                lineWrapping: true,
                autoRefresh: true,
            });

            self.codemirror.on('change', function (cm) {
                self.data = cm.doc.getValue();
            });

            // update CodeMirror if we change the value independently of CodeMirror
            this.$watch('value', function (val) {
                if (val !== self.codemirror.doc.getValue()) {
                    self.codemirror.doc.setValue(val);
                }
            });
        },
        methods: {
            update(value) {
                this.$emit('input', value);
            },
        },
        computed: {
            markdownPreviewText() {
                return markdown(this.data);
            },
        }
    }
</script>
