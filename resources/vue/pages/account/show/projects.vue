<template>
    <v-panel :stack="true"
             :border="false">

        <!-- Description (Empty) -->
        <p v-if="blank(prop('account.projects'))">
            {{ prop('account.name') }} has not added any projects.
        </p>

        <!-- Description (Not Empty) -->
        <p v-if="filled(prop('account.projects'))">
            Review the projects that {{ prop('account.name') }} has worked on.
            Note that Lumeno does not verify any of the information supplied. If
            you are considering this person for a position, then you will need
            to verify their résumé yourself.
        </p>

        <!-- Projects -->
        <div :key="project.id"
             v-if="filled(prop('account.projects'))"
             v-for="project in prop('account.projects')"
             class="border-t border-gray-300/50 py-10 last-of-type:pb-0 first-of-type:mt-10">

            <!-- Header -->
            <div class="flex justify-between items-center mb-4">

                <!-- Detail -->
                <div class="flex items-center">

                    <!-- Logo -->
                    <v-image type="project"
                             :source="project"
                             class="w-[45px] h-[45px] min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] rounded-md mr-5">
                    </v-image>

                    <!-- Overview -->
                    <div class="flex flex-col">

                        <!-- Title -->
                        <a target="_blank"
                           :href="project.url"
                           class="font-inter font-semibold text-17px text-gray-900 hover:text-gray-900 tracking-tight leading-tight mb-0">

                            <!-- Text -->
                            {{ project.title }}

                        </a>

                        <!-- Type -->
                        <div class="flex items-center text-14px text-gray-600 mt-1">

                            <!-- Icon -->
                            <i class="fas fa-code text-10px text-purple-600/70 mr-2"></i>

                            <!-- Text -->
                            <span class="mr-5">
                                {{ prop('types').find(type => type.id === project.type).name }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Summary -->
            <p class="text-gray-800 clamp three-lines leading-normal">
                {{ project.summary }}
            </p>

            <!-- Footer -->
            <div class="flex flex-col xl:flex-row flex-wrap justify-between">

                <!-- Tags -->
                <div class="flex flex-wrap">

                    <!-- Tag -->
                    <div :key="tag"
                         v-for="tag in ['first_tag', 'second_tag', 'third_tag', 'fourth_tag']">

                        <!-- Pill -->
                        <div v-if="project[tag]"
                             class="bg-sky-100/70 font-medium text-11px text-sky-800 uppercase rounded-full px-2 py-1 mr-2">

                            <!-- Text -->
                            {{ project[tag] }}

                        </div>

                    </div>

                </div>

                <!-- Actions -->
                <div class="flex xl:justify-end ml-1 mt-5 xl:ml-0 xl:mt-0">

                    <!-- Images -->
                    <span class="block font-medium text-12px text-gray-700 uppercase"
                          v-if="project.first_image || project.second_image || project.third_image">

                        <!-- Icon -->
                        <i class="fa-fw fas fa-image text-13px text-purple-700/50 -ml-9px"></i>

                        <!-- Link -->
                        <v-link :action="() => project.images = true">
                            Images
                        </v-link>

                    </span>

                </div>

            </div>

            <!-- Gallery -->
            <div class="flex flex-wrap mt-6"
                 v-if="project?.images ?? false">

                <!-- First Image -->
                <v-image :source="project"
                         type="first_project_image"
                         v-if="project.first_image"
                         @click="showImage(project, 'first_image')"
                         class="w-full md:w-100px md:h-100px md:min-w-100px md:min-h-100px md:max-w-100px md:max-h-100px rounded-md cursor-pointer mb-3 md:mb-0 md:mr-4">
                </v-image>

                <!-- Second Image -->
                <v-image :source="project"
                         type="second_project_image"
                         v-if="project.second_image"
                         @click="showImage(project, 'second_image')"
                         class="w-full md:w-100px md:h-100px md:min-w-100px md:min-h-100px md:max-w-100px md:max-h-100px rounded-md cursor-pointer mb-3 md:mb-0 md:mr-4">
                </v-image>

                <!-- Third Image -->
                <v-image :source="project"
                         type="third_project_image"
                         v-if="project.third_image"
                         @click="showImage(project, 'third_image')"
                         class="w-full md:w-100px md:h-100px md:min-w-100px md:min-h-100px md:max-w-100px md:max-h-100px rounded-md cursor-pointer">
                </v-image>

                <!-- Gallery Modal -->
                <v-gallery v-if="modal"
                           :image="image"
                           :visible="modal"
                           :project="current"
                           @closed="modal = false">
                </v-gallery>

            </div>

        </div>

    </v-panel>
</template>

<script>
    import GalleryPartial from './gallery.vue';
    import LinkComponent from '@/components/link.vue';
    import ImageComponent from '@/components/image.vue';
    import PanelComponent from '@/components/panel.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-gallery' : GalleryPartial,
            'v-image'   : ImageComponent,
            'v-link'    : LinkComponent,
            'v-panel'   : PanelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            modal : false,

            current : {},

            image : '',
        }},

		/**
		 * Define the supporting methods.
		 *
		 */
		methods :
        {
            /**
             * Display the given project image at full size.
             *
             */
            showImage(project, index)
            {
                this.image   = index;
                this.current = project;

                this.modal = true;
            },
        }
    }
</script>