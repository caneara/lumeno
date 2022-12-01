<template>
    <div class="writer"
         :class="fullscreen ? 'flex flex-col fixed inset-0 bg-gray-200 z-1000 p-10 min-h-screen' : ''">

        <!-- Tabs -->
        <div class="flex md:justify-between">

            <!-- Left Side -->
            <div class="flex">

                <!-- Write -->
                <div @click="preview = false"
                     class="px-5 pt-11px pb-3 rounded-t border border-b-0 cursor-pointer"
                     :class="preview ? 'border-transparent' : 'bg-gray-100 border-gray-400/75'">

                    <!-- Icon -->
                    <i class="fas fa-edit md:mr-2 text-sky-600/70 text-15px md:text-13px"></i>

                    <!-- Text -->
                    <span class="hidden md:inline text-gray-600 select-none uppercase text-13px font-semibold">
                        Write
                    </span>

                </div>

                <!-- Preview -->
                <div @click="preview = true"
                     :class="preview ? 'bg-gray-100 border-gray-400/75' : 'border-transparent'"
                     class="px-5 pt-11px pb-3 rounded-t border border-b-0 border-gray-400/75 cursor-pointer">

                    <!-- Icon -->
                    <i class="fas fa-eye md:mr-2 text-emerald-600/70 text-15px md:text-13px relative"></i>

                    <!-- Text -->
                    <span class="hidden md:inline text-gray-600 select-none uppercase text-13px font-semibold">
                        Preview
                    </span>

                </div>

            </div>

            <!-- Right Side -->
            <div class="flex">

                <!-- Image -->
                <div @click="events.emit('upload-select-file-markdown_editor_upload')"
                     class="border border-b-0 border-transparent pt-11px px-5 cursor-pointer">

                    <!-- Icon -->
                    <i class="fas fa-upload mr-4 md:mr-2 text-purple-600/60 text-15px md:text-13px relative"></i>

                    <!-- Text -->
                    <span class="hidden md:inline text-gray-600 select-none uppercase text-13px font-semibold">
                        Image
                    </span>

                </div>

                <!-- Expand -->
                <div @click="expand()"
                     class="border border-b-0 border-transparent pt-11px pl-2 cursor-pointer">

                    <!-- Icon -->
                    <i :class="fullscreen ? 'fa-window-restore' : 'fa-window-maximize'"
                       class="far md:mr-10px text-amber-600/70 text-15px md:text-13px relative">
                    </i>

                    <!-- Text -->
                    <span class="hidden md:inline text-gray-600 select-none uppercase text-13px font-semibold">
                        {{ fullscreen ? 'Compact' : 'Full Screen' }}
                    </span>

                </div>

            </div>

        </div>

        <!-- Content -->
        <div class="bg-white border border-gray-400/75 flex flex-col flex-1 h-500px relative"
             :class="[preview ? (fullscreen ? 'rounded overflow-scroll' : 'rounded max-h-[500px] overflow-scroll') : 'rounded-b rounded-r']">

            <!-- Progress Bar -->
            <div ref="bar"
                 class="bg-gray-200 h-6px w-full absolute top-0 left-0 right-0 rounded-tr z-1 hidden overflow-hidden">

                <!-- Progress -->
                <div ref="progress"
                    class="bg-teal-600 h-6px absolute top-0 left-0 transition-all duration-200">
                </div>

            </div>

            <!-- Toolbar -->
            <div v-show="! preview"
                 class="bg-sky-50 border-b border-gray-300 text-gray-600 flex flex-wrap px-2">

                <!-- Heading 1 -->
                <span @click="events.emit('textbox-insert-markdown_editor', '# ')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-heading"></i>

                    <!-- Number -->
                    <span class="relative top-1px -left-2px">
                        1
                    </span>

                </span>

                <!-- Heading 2 -->
                <span @click="events.emit('textbox-insert-markdown_editor', '## ')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-heading"></i>

                    <!-- Number -->
                    <span class="relative top-1px -left-2px">
                        2
                    </span>

                </span>

                <!-- Heading 3 -->
                <span @click="events.emit('textbox-insert-markdown_editor', '### ')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-heading"></i>

                    <!-- Number -->
                    <span class="relative top-1px -left-2px">
                        3
                    </span>

                </span>

                <!-- Bold -->
                <span @click="events.emit('textbox-wrap-markdown_editor', '**')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-bold"></i>

                </span>

                <!-- Italic -->
                <span @click="events.emit('textbox-wrap-markdown_editor', '*')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-italic"></i>

                </span>

                <!-- List -->
                <span @click="events.emit('textbox-insert-markdown_editor', '* ')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-list"></i>

                </span>

                <!-- Blockquote -->
                <span @click="events.emit('textbox-insert-markdown_editor', '> ')"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-quote-left"></i>

                </span>

                <!-- Code -->
                <span @click="events.emit('textbox-wrap-markdown_editor', ['```\n', '\n```'])"
                      class="hover:text-black transition duration-300 cursor-pointer relative top-1px p-3">

                    <!-- Icon -->
                    <i class="fas fa-code"></i>

                </span>

            </div>

            <!-- Writer -->
            <v-textbox :lines="-1"
                       :simple="true"
                       :border="false"
                       v-model="value"
                       v-show="! preview"
                       id="markdown_editor"
                       @change="change($event)"
                       placeholder="Write something amazing...">
            </v-textbox>

            <!-- Preview -->
            <div v-show="preview"
                 class="px-10 py-9 max-w-1000px">

                <!-- Markdown -->
                <div ref="preview"
                     class="markdown pb-9">
                </div>

            </div>

        </div>

        <!-- Upload -->
        <v-upload class="hidden"
                  :size="3145728"
                  @uploading="uploading()"
                  @error="message = $event"
                  id="markdown_editor_upload"
                  ref="markdown_editor_upload"
                  types="image/png, image/jpeg"
                  @progress="$refs.progress.style.width = `${$event}%`"
                  @uploaded="form.uuid = $event; submit(form, 'images.store').then(response => uploaded(response))">
        </v-upload>

        <!-- Error -->
        <v-error :message="message"></v-error>

    </div>
</template>

<script>
    import markdownit from 'markdown-it';
    import hljs from 'highlight.js/lib/common';
    import ErrorComponent from './error.vue';
    import UploadComponent from './upload.vue';
    import TextBoxComponent from './textbox.vue';
    import 'highlight.js/styles/stackoverflow-light.css';
    import InteractsWithField from '@/mixins/InteractsWithField';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithField,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-error'   : ErrorComponent,
            'v-textbox' : TextBoxComponent,
            'v-upload'  : UploadComponent,
        },

        /**
         * Define the events.
         *
         */
        emits : ['uploading', 'uploaded'],

        /**
         * Define the data model.
         *
         */
        data() { return {
            form       : createAjaxForm({ uuid : '' }),
            value      : this.modelValue,
            preview    : false,
            renderer   : null,
            fullscreen : false,
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            let options = {
                html        : false,
                linkify     : true,
                typographer : true,
                quotes      : '“”‘’',
                highlight   : (text, language) => this.formatCodeBlock(text, language),
            };

            this.renderer = markdownit('commonmark', options).enable('table');
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            when(() => document.getElementById('markdown_editor') !== null, () => {
                document.getElementById('markdown_editor').addEventListener('keydown', (event) => {
                    this.interceptKeystroke(event);
                });
            });
		},

		/**
		 * Define the watch methods.
		 *
		 */
		watch :
        {
			/**
			 * Watch the 'preview' property.
			 *
			 */
			preview : function(current, previous)
			{
                if (current === true && previous === false) {
                    this.$refs.preview.innerHTML = this.renderer.render(this.value);
                }
			}
		},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Expand the editor to fill the browser.
             *
             */
            expand()
            {
                document.body.style.overflow = this.fullscreen ? 'visible' : 'hidden';

                this.fullscreen = ! this.fullscreen;
            },

            /**
             * Insert line numbers and render code blocks.
             *
             */
            formatCodeBlock(text, language)
            {
                if (blank(language) || blank(hljs.getLanguage(language))) {
                    return '';
                }

                try {
                    let rendered = hljs.highlight(text, { language : language }).value;

                    const rows = rendered.trim().split('\n').map((line, idx) => {
                        return `<tr>
                                <td class="line-number">${idx + 1}</td>
                                <td class="code-line">${line}</td>
                            </tr>`;
                    });

                    return `<div class="hljs"><table class="code-block"><tbody>${rows.join('')}</tbody></table></div>`;
                } catch {
                    return '';
                }
            },

            /**
             * Intercept any key-presses and replace them with their appropriate characters.
             *
             */
            interceptKeystroke(event)
            {
                if (event.keyCode !== 9) return;

                event.preventDefault();

                let editor = document.getElementById('markdown_editor');

                let start = editor.selectionStart;
                let end   = editor.selectionEnd;

                editor.value = editor.value.substring(0, start) + "\t" + editor.value.substring(end);

                editor.selectionStart = editor.selectionEnd = start + 1;
            },

            /**
             * Handle the 'uploaded' event.
             *
             */
            uploaded(response)
            {
                this.$emit('uploaded');

                this.$refs.progress.style.width = '0%';

                this.$refs.bar.classList.add('hidden');

                events.emit('textbox-insert-markdown_editor', `![](${file(`images/${response.data.id}.jpg`)})`);
            },

            /**
             * Handle the 'uploading' event.
             *
             */
            uploading()
            {
                this.$emit('uploading');

                this.$refs.bar.classList.remove('hidden');
            },
        }
    }
</script>