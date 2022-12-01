<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Projects
            </h4>

            <!-- Information -->
            <p class="mb-9">
                Manage the personal, educational or business projects that you have
                worked on, or are currently working on. Your projects are included
                within your public profile for other professionals, as well as
                potential employers to discover.
            </p>

            <!-- Empty -->
            <v-empty :visible="isPaginatorEmpty()"
                     message="You have not added any projects"
                     :action="{ command : () => redirect('projects.create') }">
            </v-empty>

            <!-- Projects -->
            <div :key="project.id"
                 v-show="! isPaginatorEmpty()"
                 class="border-t border-gray-300/50"
                 v-for="(project, index) in prop('projects.data')"
                 :class="index === prop('projects.data').length - 1 ? 'pt-10' : 'py-10'">

                <!-- Header -->
                <div class="flex justify-between items-center mb-5">

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
                            <h5 @click="redirect(['projects.edit', project.id])"
                                class="flex font-semibold text-17px cursor-pointer mb-0">

                                <!-- Text -->
                                {{ project.title }}

                            </h5>

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

                    <!-- Actions -->
                    <v-menu :items="context(project)"
                            :id="`context-projects-${project.id}`">
                    </v-menu>

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

            <!-- Pagination -->
            <v-pagination :paginator="paginator"></v-pagination>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Total -->
            <v-statistic icon="cube"
                         :text="metric(prop('total'), 'project')">
            </v-statistic>

            <!-- Permitted -->
            <v-statistic icon="cubes"
                         :text="`${prop('limit')} permitted`">
            </v-statistic>

            <!-- Remaining -->
            <v-statistic icon="hourglass"
                         :text="`${prop('limit') - prop('total')} remaining`">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import GalleryPartial from './gallery.vue';
    import LinkComponent from '@/components/link.vue';
    import MenuComponent from '@/components/menu.vue';
    import EmptyComponent from '@/components/empty.vue';
    import ImageComponent from '@/components/image.vue';
    import ActionComponent from '@/components/actions.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import PaginationComponent from '@/components/pagination.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithPagination from '@/mixins/InteractsWithPagination';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
            InteractsWithPagination,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'    : ActionComponent,
            'v-empty'      : EmptyComponent,
            'v-gallery'    : GalleryPartial,
            'v-image'      : ImageComponent,
            'v-layout'     : Layout,
            'v-link'       : LinkComponent,
            'v-menu'       : MenuComponent,
            'v-pagination' : PaginationComponent,
            'v-statistic'  : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            paginator : 'projects',

            modal : false,

            current : {},

            image : '',

            actions : [
                {
                    id      : 'create-project',
                    show    : (prop('limit') - prop('total')) > 0,
                    icon    : 'plus',
                    color   : 'text-emerald-700/70',
                    title   : 'Create project',
                    summary : 'Add to your profile',
                    action  : () => redirect('projects.create'),
                },
            ],
        }},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the menu options for the given project.
             *
             */
            context(project)
            {
                return [
                    {
                        id     : `context-projects-${project.id}-edit`,
                        icon   : 'edit',
                        show   : true,
                        type   : 'link',
                        label  : 'Edit project',
                        action : () => redirect(['projects.edit', project.id]),
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-projects-${project.id}-delete`,
                        icon   : 'trash-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Delete project',
                        action : () => confirmAction('This will delete the project.', () => submit(
                            createInertiaForm(), ['projects.delete', project.id], 'delete')
                        ),
                    }
                ];
            },

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