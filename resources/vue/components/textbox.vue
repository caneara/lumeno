<template>
    <div class="textbox"
         :class="lines === -1 ? 'h-full' : ''">

        <!-- Control -->
        <div @mouseover="hover = true"
             @mouseout="hover = false"
             class="control rounded relative w-full transition duration-400 bg-white"
             :class="[border ? 'border border-gray-400/75' : '', lines === -1 ? 'h-full' : '']">

            <!-- Input -->
            <input :id="name"
                   type="text"
                   :name="name"
                   v-if="lines === 1"
                   :value="modelValue"
                   :autocomplete="fill"
                   @focus="focus = true"
                   :placeholder="placeholder"
                   @input="change($event.target.value)"
                   :class="[font, small ? 'small py-7px' : 'pb-7px pt-25px']"
                   @focusout="($event) => { focus = false; registerCursor($event) }"
                   class="field rounded appearance-none bg-inherit w-full text-gray-900 px-3" />

            <!-- Textarea -->
            <textarea :id="name"
                      :name="name"
                      v-if="lines !== 1"
                      :value="modelValue"
                      :autocomplete="fill"
                      @focus="focus = true"
                      :placeholder="placeholder"
                      :rows="lines ? lines : null"
                      @input="change($event.target.value)"
                      @focusout="($event) => { focus = false; registerCursor($event) }"
                      :class="[font, simple ? 'px-10 py-9' : 'pt-25px pl-3 pr-11', lines === -1 ? 'h-full' : '']"
                      class="field textarea rounded appearance-none bg-inherit w-full text-gray-900 resize-none leading-snug">
            </textarea>

            <!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     :small="small"
                     :optional="optional"
                     v-if="! simple && ! dusk()"
                     :value="filled(modelValue)">
            </v-label>

            <!-- Clear -->
            <v-clear :focus="focus"
                     :hover="hover"
                     :small="small"
                     @clear="change('')"
                     v-if="! simple && ! dusk()"
                     :value="filled(modelValue)">
            </v-clear>

        </div>

        <!-- Error -->
        <v-error :message="message"></v-error>

    </div>
</template>

<script>
    import ClearComponent from './clear.vue';
    import ErrorComponent from './error.vue';
    import LabelComponent from './label.vue';
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
            'v-clear' : ClearComponent,
            'v-error' : ErrorComponent,
            'v-label' : LabelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            cursor : 0,
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'font'        : { type : String,  default : 'font-sans' },
            'lines'       : { type : Number,  default : 1 },
            'small'       : { type : Boolean, default : false },
            'simple'      : { type : Boolean, default : false },
            'border'      : { type : Boolean, default : true },
            'optional'    : { type : Boolean, default : false },
            'placeholder' : { type : String,  default : '' },
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on(`textbox-insert-${this.name}`, (content) => this.insertText(content));
            events.on(`textbox-wrap-${this.name}`, (content) => this.wrapSelection(content));
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener(`textbox-insert-${this.name}`);
            clearEventListener(`textbox-wrap-${this.name}`);
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Insert the given text into the component.
             *
             */
            insertText(content)
            {
                let revised = this.modelValue.substring(0, this.cursor.start)
                            + content
                            + this.modelValue.substring(this.cursor.start, this.modelValue.length);

                this.change(revised);
            },

            /**
             * Store the current cursor selection.
             *
             */
            registerCursor(event)
            {
                this.cursor = {
                    start : event.target.selectionStart,
                    end   : event.target.selectionEnd,
                };
            },

            /**
             * Wrap the currently selected text with the given content.
             *
             */
            wrapSelection(content)
            {
                let left  = Array.isArray(content) ? content[0] : content;
                let right = Array.isArray(content) ? content[1] : content;

                let revised = this.modelValue.substring(0, this.cursor.start)
                            + left
                            + this.modelValue.substring(this.cursor.start, this.cursor.end)
                            + right
                            + this.modelValue.substring(this.cursor.end, this.modelValue.length);

                this.change(revised);
            },
        },
    }
</script>