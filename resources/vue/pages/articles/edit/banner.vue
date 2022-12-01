<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6>
            Banner
        </h6>

        <!-- Description -->
        <p class="mb-4">
            Make your article more engaging when shared on
            social media by adding a banner image.
        </p>

        <!-- Tip -->
        <p class="text-14px text-gray-600/90">
            The image will be resized, or cropped from the center to ensure
            that it equals 1000 x 527 pixels. Therefore, you should supply a
            JPEG or PNG image that is larger than this to avoid pixelation.
            The image must also be less than 3 MB in size.
        </p>

        <!-- Banner -->
        <div class="relative mb-4"
             v-if="session.form.banner">

            <!-- Banner -->
            <img :src="articleBanner(session.form.banner)"
                 class="w-full h-100px md:h-250px object-cover object-center rounded-md relative">

            <!-- Remove -->
            <div class="flex justify-center items-center absolute inset-0">

                <!-- Circle -->
                <span class="w-40px h-40px bg-black/70 flex justify-center items-center rounded-full">

                    <!-- Icon -->
                    <i title="Remove image"
                       @click="() => { session.form.banner = ''; events.emit('upload-reset-banner') }"
                       class="fas fa-times text-20px text-gray-500 hover:text-gray-300 cursor-pointer transition duration-300 relative top-1px">
                    </i>

                </span>

            </div>

        </div>

        <!-- Banner -->
        <v-upload id="banner"
                  icon="image"
                  :size="3145728"
                  label="Select an image..."
                  @uploaded="uploaded($event)"
                  types="image/png, image/jpeg"
                  :error="session.form.errors.banner"
                  @uploading="session.uploading = true"
                  @reset="session.form.banner = ''; session.form.errors.banner = ''">
        </v-upload>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import UploadComponent from '@/components/upload.vue';
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
            'v-panel'  : PanelComponent,
            'v-upload' : UploadComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            image : createAjaxForm({
                uuid   : '',
                format : 'social',
            }),
        }},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Handle the banner 'uploaded' event.
             *
             */
            uploaded(uuid)
            {
                this.image.uuid = uuid;

                submit(this.image, 'images.store').then(response => {
                    session.uploading = false;

                    session.form.banner = response.data.id;
                });
            },
        },
    }
</script>