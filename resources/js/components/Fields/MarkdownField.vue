<template>
    <div class="markdown-field">
        <textarea id="editor"></textarea>
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

        data(){
          return {
              editor: null
          }
        },

        mounted() {
            this.editor = CodeMirror.fromTextArea(document.getElementById('editor'), {
                value: this.value || '',
                mode: 'gfm',
                keyMap: 'sublime',
                lineWrapping: true,
                autoRefresh: true,
            });

            this.editor.on('change', cm => {
                this.updateValue(cm.doc.getValue())
            })
        },

        methods: {
          updateValue(value){
              this.value = value;
              this.$emit('input', this.value);
          }
        },

    }
</script>
