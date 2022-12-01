<template>
    <v-panel :tab="tab"
             :active="active">

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Photo
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Upload an image, then zoom or scroll
                its content to adjust the used crop.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">
                Images will be scaled to 512 x 512 pixels,
                so you should ideally use an image that is
                larger than this to avoid pixelation.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">

                <!-- Text -->
                Be sure to include a profile picture, as you will

                <!-- Warning -->
                <span class="font-semibold text-red-700">
                    not appear
                </span>

                <!-- Text -->
                in recruitment search results if you are using
                the default image. In addition, the image must
                be a photo of yourself.

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
                                 @change="setAvatar"
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
                         :message="session.forms.avatar.errors.avatar">
                </v-error>

                <!-- File Selector -->
                <input ref="file"
                       dusk="file"
                       type="file"
                       class="hidden"
                       accept="image/*"
                       @change="loadImage($event.target)" />

                <!-- Actions -->
                <div class="flex justify-center md:justify-end">

                    <!-- Choose File -->
                    <v-button color="gray"
                              class="mr-7"
                              scheme="light"
                              label="Choose"
                              @click="$refs.file.click()"
                              icon="camera-alt top-half-px">
                    </v-button>

                    <!-- Update -->
                    <v-button label="Update"
                              id="save-avatar"
                              :disabled="original"
                              class="md:flex justify-end"
                              :processing="session.forms.avatar.processing"
                              @click="submit(session.forms.avatar, 'avatar.update', 'patch', { preserveScroll : true })">
                    </v-button>

                </div>

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

            'v-button' : ButtonComponent,
            'v-error'  : ErrorComponent,
            'v-panel'  : PanelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            source   : '',
            painted  : false,
            original : ! prop('account.avatar'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'tab'    : { type : String, default : '' },
            'active' : { type : String, default : '' },
        },

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            this.fetchExistingImage();

            events.on('set-active-tab-general', () => this.paint());
        },

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('set-active-tab-general');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the user's existing avatar.
             *
             */
            async fetchExistingImage()
            {
                if (this.tab === this.active) {
                    return this.paint();
                }

                let url = this.userAvatar(prop('account.avatar'));

                session.forms.avatar.avatar = await fetch(url).then(response => response.blob());
            },

            /**
             * Retrieve the given image source and assign it.
             *
             */
            loadImage(input)
            {
                if (! input.files || ! input.files[0]) return;

                let reader = new FileReader();

                reader.onload = (event) => this.source = event.target.result;

                reader.readAsDataURL(input.files[0]);

                this.original = false;
            },

            /**
             * Display the avatar for the first time or when switching tabs.
             *
             */
            paint()
            {
                if (this.painted) {
                    setTimeout(() => this.$refs.cropper.refresh(), 100);
                } else {
                    setTimeout(() => this.source = this.userAvatar(prop('account.avatar')), 100);
                }

                setTimeout(() => this.painted = true, 200);
            },

            /**
             * Update the content of the user's avatar.
             *
             */
            setAvatar(response)
            {
                session.forms.avatar.errors.avatar = '';

                response.canvas.toBlob(blob => session.forms.avatar.avatar = blob, 'image/jpeg');
            },
        }
    }
</script>