<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Create Project
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Add a new personal, educational or business project. It will be
                included within your public profile for other IT professionals, as
                well as potential employers to discover.
            </p>

            <!-- Sections -->
            <v-type></v-type>
            <v-overview></v-overview>
            <v-logo></v-logo>
            <v-gallery></v-gallery>
            <v-link></v-link>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Jump to section
            </span>

            <!-- Actions -->
            <v-actions :border="false"
                       :items="actions.jump">
            </v-actions>

            <!-- Actions -->
            <v-actions :items="actions.links"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import LogoPartial from './logo.vue';
    import TypePartial from './type.vue';
    import LinkPartial from './link.vue';
    import Layout from '@/layout/index.vue';
    import GalleryPartial from './gallery.vue';
    import OverviewPartial from './overview.vue';
    import ActionComponent from '@/components/actions.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'  : ActionComponent,
            'v-gallery'  : GalleryPartial,
            'v-layout'   : Layout,
            'v-link'     : LinkPartial,
            'v-logo'     : LogoPartial,
            'v-overview' : OverviewPartial,
            'v-type'     : TypePartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            actions : {
                jump : [
                    {
                        id      : 'scroll-type',
                        show    : true,
                        icon    : 'code',
                        color   : 'text-emerald-600/70',
                        title   : 'Type',
                        action  : () => document.querySelector('#title-type').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-overview',
                        show    : true,
                        icon    : 'font',
                        color   : 'text-sky-600/70',
                        title   : 'Overview',
                        action  : () => document.querySelector('#title-overview').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-logo',
                        show    : true,
                        icon    : 'image',
                        color   : 'text-red-700/70',
                        title   : 'Logo',
                        action  : () => document.querySelector('#title-logo').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-gallery',
                        show    : true,
                        icon    : 'images',
                        color   : 'text-yellow-600/70',
                        title   : 'Gallery',
                        action  : () => document.querySelector('#title-gallery').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-link',
                        show    : true,
                        icon    : 'link',
                        color   : 'text-gray-600/70',
                        title   : 'Link',
                        action  : () => document.querySelector('#title-link').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    },
                ],
                links : [
                    {
                        id      : 'back-to-index',
                        show    : true,
                        icon    : 'arrow-left',
                        color   : 'text-gray-700/70',
                        title   : 'View projects',
                        summary : 'Back to main directory',
                        action  : () => redirect('projects'),
                    }, {
                        id      : 'reset-logo',
                        show    : true,
                        icon    : 'camera',
                        color   : 'text-purple-700/70',
                        title   : 'Use default logo',
                        summary : 'Remove your project logo',
                        action  : () => confirmAction('This will reset the logo.', () => events.emit('reset-logo')),
                    },
                ],
            }
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            session.form = createInertiaForm({
                type         : '',
                logo         : '',
                title        : '',
                summary      : '',
                url          : '',
                first_tag    : '',
                second_tag   : '',
                third_tag    : '',
                fourth_tag   : '',
                first_image  : '',
                second_image : '',
                third_image  : '',
                uploading    : false,
            }, 'create');
        },
    }
</script>