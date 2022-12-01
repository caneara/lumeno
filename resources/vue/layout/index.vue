<template>
    <main class="flex flex-col justify-between min-h-screen">

        <!-- Notification -->
        <v-notification></v-notification>

        <!-- Header -->
        <v-header :dialog="dialog">
            <template #sidebar>

                <!-- Slot -->
                <slot name="sidebar"></slot>

                <!-- Advert -->
                <v-advert target="mobile"></v-advert>

            </template>
        </v-header>

        <!-- Banner -->
        <slot name="banner"></slot>

        <!-- Section -->
        <v-section :dialog="dialog"
                   :invert="invert"
                   :padding="padding">

            <!-- Default -->
            <slot></slot>

            <!-- Content -->
            <template #content>
                <slot name="content"></slot>
            </template>

            <!-- Sidebar -->
            <template #sidebar>

                <!-- Slot -->
                <slot name="sidebar"></slot>

                <!-- Advert -->
                <v-advert target="desktop"></v-advert>

            </template>

            <!-- Other -->
            <template #other>
                <slot name="other"></slot>
            </template>

        </v-section>

        <!-- Footer -->
        <v-footer :dialog="dialog"
                  :invert="invert">
        </v-footer>

    </main>
</template>

<script>
    import HeaderPartial from './header.vue';
    import FooterPartial from './footer.vue';
    import SectionPartial from './section.vue';
    import LinkComponent from '@/components/link.vue';
    import AdvertComponent from '@/components/advert.vue';
    import NotificationComponent from '@/components/notification.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-advert'       : AdvertComponent,
            'v-footer'       : FooterPartial,
            'v-header'       : HeaderPartial,
            'v-link'         : LinkComponent,
            'v-notification' : NotificationComponent,
            'v-section'      : SectionPartial,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'dialog'  : { type : Boolean, default : false },
            'invert'  : { type : Boolean, default : false },
            'padding' : { type : Boolean, default : true },
        },

        /**
         * Execute actions when the component is created.
         *
         */
        created()
        {
            document.querySelector('title').innerHTML = prop('title');
        },

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            setTimeout(() => {
                document.querySelector(`.${prop('data.scroll_to', '_')}`)
                    ?.scrollIntoView({ behavior : 'smooth', block : 'center' });
            }, 100);
        },

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            if (session.hasOwnProperty('ads')) {
                delete session.ads;
            }
        },
    }
</script>