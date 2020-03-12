<template>
    <div class="editor">
        <editor-menu-bar :editor="editor" v-slot="{ commands, isActive, focused }">
            <div
                class="menubar is-hidden"
                :class="{ 'is-focused': focused }"
            >

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.bold() }"
                    @click="commands.bold"
                >
                    bold
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.italic() }"
                    @click="commands.italic"
                >
                    italic
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.strike() }"
                    @click="commands.strike"
                >
                    strike
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.underline() }"
                    @click="commands.underline"
                >
                    underline
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.code() }"
                    @click="commands.code"
                >
                    code
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.paragraph() }"
                    @click="commands.paragraph"
                >
                    paragraph
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.heading({ level: 1 }) }"
                    @click="commands.heading({ level: 1 })"
                >
                    H1
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 })"
                >
                    H2
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.heading({ level: 3 }) }"
                    @click="commands.heading({ level: 3 })"
                >
                    H3
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.bullet_list() }"
                    @click="commands.bullet_list"
                >
                    ul
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.ordered_list() }"
                    @click="commands.ordered_list"
                >
                    ol
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.blockquote() }"
                    @click="commands.blockquote"
                >
                    quote
                </button>

                <button type="button"
                    class="menubar__button"
                    :class="{ 'is-active': isActive.code_block() }"
                    @click="commands.code_block"
                >
                    code
                </button>

            </div>
        </editor-menu-bar>
        <editor-content class="editor__content border rounded p-2" :editor="editor" />
    </div>
</template>

<script>
    import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
    import {
        CodeBlockHighlight,
        Blockquote,
        BulletList,
        CodeBlock,
        HardBreak,
        Heading,
        ListItem,
        OrderedList,
        TodoItem,
        TodoList,
        Bold,
        Code,
        Italic,
        Link,
        Strike,
        Underline,
        History,
    } from 'tiptap-extensions'
    import javascript from 'highlight.js/lib/languages/javascript'
    import php from 'highlight.js/lib/languages/php'
    import css from 'highlight.js/lib/languages/css'
    export default {
        props: {
          value: String
        },
        components: {
            EditorContent,
            EditorMenuBar
        },
        data() {
            return {
                editor: new Editor({
                    extensions: [
                        new CodeBlockHighlight({
                            languages: {
                                javascript,
                                css,
                                php,
                            },
                        }),
                        new Blockquote(),
                        new BulletList(),
                        new CodeBlock(),
                        new HardBreak(),
                        new Heading({ levels: [1, 2, 3] }),
                        new ListItem(),
                        new OrderedList(),
                        new TodoItem(),
                        new TodoList(),
                        new Link(),
                        new Bold(),
                        new Code(),
                        new Italic(),
                        new Strike(),
                        new Underline(),
                        new History(),
                    ],
                    content: this.value,
                    onUpdate: this.valueChanged
                }),
            }
        },
        methods: {
            valueChanged(state){
                this.$emit('input',state.getHTML());
            }
        }
    }
</script>

<style lang="scss">
    .editor__content{
        min-height: 400px;
    }
    pre {
        &::before {
            content: attr(data-language);
            text-transform: uppercase;
            display: block;
            text-align: right;
            font-weight: bold;
            font-size: 0.6rem;
        }
        code {
            .hljs-comment,
            .hljs-quote {
                color: #999999;
            }
            .hljs-variable,
            .hljs-template-variable,
            .hljs-attribute,
            .hljs-tag,
            .hljs-name,
            .hljs-regexp,
            .hljs-link,
            .hljs-name,
            .hljs-selector-id,
            .hljs-selector-class {
                color: #f2777a;
            }
            .hljs-number,
            .hljs-meta,
            .hljs-built_in,
            .hljs-builtin-name,
            .hljs-literal,
            .hljs-type,
            .hljs-params {
                color: #f99157;
            }
            .hljs-string,
            .hljs-symbol,
            .hljs-bullet {
                color: #99cc99;
            }
            .hljs-title,
            .hljs-section {
                color: #ffcc66;
            }
            .hljs-keyword,
            .hljs-selector-tag {
                color: #6699cc;
            }
            .hljs-emphasis {
                font-style: italic;
            }
            .hljs-strong {
                font-weight: 700;
            }
        }
    }
</style>
