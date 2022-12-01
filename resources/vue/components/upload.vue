<template>
    <div class="upload">

        <!-- Control -->
        <div @mouseover="hover = true"
             @mouseout="hover = false"
             class="control rounded relative w-full transition duration-400 bg-white border border-gray-400/75 cursor-pointer">

            <!-- Hidden -->
            <input type="hidden"
                   :value="modelValue"
                   :id="`${name}_file_value`"
                   :name="`${name}_file_value`" />

            <!-- Input -->
            <input :id="name"
                   ref="file"
                   type="file"
                   :name="name"
                   :dusk="name"
				   :accept="types"
                   @change="upload()"
                   :class="dusk() ? '' : 'hidden'" />

			<!-- File Name -->
			<input readonly
                   type="text"
				   :value="display"
				   @click="selectNew()"
                   :id="`${name}_file_name`"
                   :name="`${name}_file_name`"
				   class="field rounded appearance-none bg-inherit w-full text-gray-900 px-3 pb-7px pt-25px cursor-pointer" />

            <!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     v-if="! dusk()"
                     :optional="optional"
                     :value="display !== ''">
            </v-label>

            <!-- Clear -->
            <v-clear :focus="focus"
                     :hover="hover"
                     v-if="! dusk()"
                     @clear="reset(true)"
                     :value="display !== ''">
            </v-clear>

        </div>

        <!-- Progress Bar -->
        <div ref="bar"
             class="bg-gray-200 h-6px w-full relative rounded-sm hidden mt-2">

            <!-- Progress -->
            <div ref="progress"
                 class="bg-teal-600 h-6px absolute top-0 left-0 rounded-sm transition-all duration-200">
            </div>

        </div>

        <!-- Error -->
        <v-error :message="message"></v-error>

    </div>
</template>

<script>
    import Vapor from '../../js/vapor';
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
            cancel   : null,
            display  : '',
            disabled : false,
        }},

        /**
         * Define the events.
         *
         */
        emits : ['error', 'progress', 'reset', 'uploading', 'uploaded'],

		/**
		 * Define the public properties.
		 *
		 */
		props: {
			'size'     : { type : Number,  default : 1048576 },
			'types'    : { type : String,  default : '' },
            'optional' : { type : Boolean, default : false },
		},

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on(`upload-select-file-${this.name}`, () => this.$refs.file.click());
            events.on(`upload-reset-${this.name}`, (complete = true) => this.reset(complete));
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener(`upload-reset-${this.name}`);
            clearEventListener(`upload-select-file-${this.name}`);
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Clear the state of the component.
             *
             */
            reset(complete)
            {
                this.$refs.file.value = null;
                this.$refs.bar.classList.add('hidden');
                this.$refs.progress.style.width = '0px';

                this.display = complete ? '' : this.display;

                complete ? this.$emit('reset') : null;
                complete ? this.cancel.cancel() : null;
            },

            /**
             * Clear the existing selected file and allow for the selection of a new one.
             *
             */
            selectNew()
            {
                this.reset(false);

                this.$refs.file.click();
            },

            /**
             * Update the current upload progress.
             *
             */
            setProgress(progress)
            {
                let percent = Math.round(progress * 100);

                this.$emit('progress', percent);

                this.$refs.progress.style.width = `${percent}%`;
            },

            /**
             * Stream the chosen file to the server.
             *
             */
            upload()
            {
                let file = this.$refs.file.files[0];

				if (file.size > this.size) {
					this.message = 'The file is too large. Please select a smaller file.';

                    return this.$emit('error', this.message);
				}

				if (! this.types.replaceAll(' ', '').split(',').includes(file.type.toLowerCase())) {
					this.message = 'The chosen file is not a supported format.';

                    return this.$emit('error', this.message);
				}

                this.message = '';
                this.display = file.name;
                this.cancel  = axios.CancelToken.source();

                this.$emit('error', '');
                this.$emit('uploading', file);

                this.$refs.bar.classList.remove('hidden');

                Vapor.store(file, {
                    progress    : progress => this.setProgress(progress),
                    visibility  : 'public-read',
                    cancelToken : this.cancel.toke,
                }).then(response => {
                    this.$emit('uploaded', response.uuid);
                    this.reset(false);
                });
            },
        }
    }
</script>