<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6 id="title-gallery">
            Gallery
        </h6>

        <!-- Text -->
        <p class="mb-4">
            Upload up to three photos, graphics or screenshots
            that showcase the project.
        </p>

        <!-- Tip -->
        <p class="text-14px text-gray-600/90">
            Images will be scaled to a maximum width
            of 1000 pixels, so you should ideally use
            a larger image than this to avoid pixelation.
        </p>

        <!-- Images -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- First Image -->
            <div class="flex flex-col items-center">

                <!-- Box -->
                <div class="relative mb-4"
                     v-if="session.form.first_image">

                    <!-- Image -->
                    <img :src="projectGalleryImage(session.form.first_image)"
                         class="w-full min-w-100px min-h-100px object-cover object-center rounded-md">

                    <!-- Remove -->
                    <div class="flex justify-center items-center absolute inset-0">

                        <!-- Circle -->
                        <span class="w-40px h-40px bg-black/70 flex justify-center items-center rounded-full">

                            <!-- Icon -->
                            <i title="Remove image"
                               @click="() => { session.form.first_image = ''; events.emit('upload-reset-first_image') }"
                               class="fas fa-times text-20px text-gray-500 hover:text-gray-300 cursor-pointer transition duration-300 relative top-1px">
                            </i>

                        </span>

                    </div>

                </div>

                <!-- Upload -->
                <v-upload icon="image"
                          class="w-full"
                          :size="3145728"
                          id="first_image"
                          :optional="true"
                          label="Select image..."
                          types="image/png, image/jpeg"
                          :error="session.form.errors.first_image"
                          @uploading="session.form.uploading = true"
                          @uploaded="uploaded($event, 'first_image')"
                          @reset="session.form.first_image = ''; session.form.errors.first_image = ''">
                </v-upload>

            </div>

            <!-- Second Image -->
            <div class="flex flex-col items-center">

                <!-- Box -->
                <div class="relative mb-4"
                     v-if="session.form.second_image">

                    <!-- Image -->
                    <img :src="projectGalleryImage(session.form.second_image)"
                         class="w-full min-w-100px min-h-100px object-cover object-center rounded-md">

                    <!-- Remove -->
                    <div class="flex justify-center items-center absolute inset-0">

                        <!-- Circle -->
                        <span class="w-40px h-40px bg-black/70 flex justify-center items-center rounded-full">

                            <!-- Icon -->
                            <i title="Remove image"
                               @click="() => { session.form.second_image = ''; events.emit('upload-reset-second_image') }"
                               class="fas fa-times text-20px text-gray-500 hover:text-gray-300 cursor-pointer transition duration-300 relative top-1px">
                            </i>

                        </span>

                    </div>

                </div>

                <!-- Second Image -->
                <v-upload icon="image"
                          class="w-full"
                          :size="3145728"
                          :optional="true"
                          id="second_image"
                          label="Select image..."
                          types="image/png, image/jpeg"
                          :error="session.form.errors.second_image"
                          @uploading="session.form.uploading = true"
                          @uploaded="uploaded($event, 'second_image')"
                          @reset="session.form.second_image = ''; session.form.errors.second_image = ''">
                </v-upload>

            </div>

            <!-- Third Image -->
            <div class="flex flex-col items-center">

                <!-- Box -->
                <div class="relative mb-4"
                     v-if="session.form.third_image">

                    <!-- Image -->
                    <img :src="projectGalleryImage(session.form.third_image)"
                         class="w-full min-w-100px min-h-100px object-cover object-center rounded-md">

                    <!-- Remove -->
                    <div class="flex justify-center items-center absolute inset-0">

                        <!-- Circle -->
                        <span class="w-40px h-40px bg-black/70 flex justify-center items-center rounded-full">

                            <!-- Icon -->
                            <i title="Remove image"
                               @click="() => { session.form.third_image = ''; events.emit('upload-reset-third_image') }"
                               class="fas fa-times text-20px text-gray-500 hover:text-gray-300 cursor-pointer transition duration-300 relative top-1px">
                            </i>

                        </span>

                    </div>

                </div>

                <!-- Third Image -->
                <v-upload icon="image"
                          :size="3145728"
                          id="third_image"
                          :optional="true"
                          class="w-full mb-4"
                          label="Select image..."
                          types="image/png, image/jpeg"
                          :error="session.form.errors.third_image"
                          @uploading="session.form.uploading = true"
                          @uploaded="uploaded($event, 'third_image')"
                          @reset="session.form.third_image = ''; session.form.errors.third_image = ''">
                </v-upload>

            </div>

        </div>

        <!-- Update -->
        <v-button label="Update"
                  class="flex justify-end"
                  :disabled="session.form.uploading"
                  :processing="session.form.processing"
                  @click="submit(session.form, ['projects.update', prop('project.id')], 'patch', { preserveScroll : true })">
        </v-button>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
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
            'v-button' : ButtonComponent,
            'v-panel'  : PanelComponent,
            'v-upload' : UploadComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            image : createAjaxForm({
                uuid : '',
            }),
        }},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Handle the gallery 'uploaded' event.
             *
             */
            uploaded(uuid, index)
            {
                this.image.uuid = uuid;

                submit(this.image, 'images.store').then(response => {
                    session.form.uploading = false;

                    session.form[index] = response.data.id;
                });
            },
        },
    }
</script>