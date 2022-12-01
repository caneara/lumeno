<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-logo">

                <!-- Text -->
                Logo

                <!-- Optional -->
                <v-optional></v-optional>

            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Upload an image, then zoom or scroll
                its content to adjust the used crop.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Images will be scaled to 512 x 512 pixels,
                so you should ideally use an image that is
                larger than this to avoid pixelation.
            </p>

        </template>

        <!-- Right -->
        <template #right>
            <div class="flex flex-col items-end">

                <!-- Avatar -->
                <div :style="`background-image: url('${asset('img/border.svg')}');`"
                     class="flex justify-center items-center rounded-md w-225px h-225px mb-8">

                    <!-- Editor -->
                    <div class="w-175px h-175px rounded-md">
                        <cropper :src="source"
                                 ref="cropper"
                                 minWidth="512"
                                 minHeight="512"
                                 @change="setLogo"
                                 class="cropper w-full h-full"
                                 :canvas="{ fillColor : '#FFFFFF' }"
                                 backgroundClass="bg-white-important"
                                 foregroundClass="bg-white-important"
                                 :stencil-props="{ aspectRatio : 1 }">
                        </cropper>
                    </div>

                </div>

                <!-- Error Message -->
                <v-error class="mb-6"
                         :message="session.form.errors.logo">
                </v-error>

                <!-- File Selector -->
                <input ref="file"
                       dusk="file"
                       type="file"
                       class="hidden"
                       accept="image/*"
                       @change="loadImage($event.target)" />

                <!-- Choose File -->
                <v-button color="gray"
                          scheme="light"
                          label="Choose"
                          @click="$refs.file.click()"
                          icon="camera-alt top-half-px">
                </v-button>

            </div>
        </template>

    </v-panel>
</template>

<script>
    import 'vue-advanced-cropper/dist/style.css';
    import { Cropper } from 'vue-advanced-cropper';
    import ErrorComponent from '@/components/error.vue';
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import OptionalComponent from '@/components/optional.vue';
    import InteractsWithImages from '@/mixins/InteractsWithImages';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithImages,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            Cropper,

            'v-button'   : ButtonComponent,
            'v-error'    : ErrorComponent,
            'v-optional' : OptionalComponent,
            'v-panel'    : PanelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            source : '',
        }},

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            events.on('reset-logo', () => this.useDefault());

            setTimeout(() => this.useDefault(), 100);
        },

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('reset-logo');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve an image from the file system.
             *
             */
            loadImage(input)
            {
                if (! input.files || ! input.files[0]) return;

                let reader = new FileReader();

                reader.onload = (event) => this.source = event.target.result;

                reader.readAsDataURL(input.files[0]);
            },

            /**
             * Update the content of the project's logo.
             *
             */
            setLogo(response)
            {
                session.form.errors.logo = '';

                response.canvas.toBlob(blob => session.form.logo = blob, 'image/jpeg');
            },

            /**
             * Restore the project's logo to the default image.
             *
             */
            useDefault()
            {
                this.$refs.file.value = null;

                session.form.errors.logo = '';

                this.source = this.projectLogo();
            },
        }
    }
</script>