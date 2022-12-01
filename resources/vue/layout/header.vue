<template>
    <header class="sticky top-0 z-1000">

        <!-- Toolbar -->
        <div class="bg-sky-1000 flex justify-center relative z-2">
            <div class="flex justify-between container">

                <!-- Product -->
                <div class="flex items-center cursor-pointer py-4"
                    @click="redirect(isGuest() ? 'home' : 'dashboard.user')">

                    <!-- Logo -->
                    <img alt="Logo"
                         class="h-22px mr-3"
                         :src="asset('img/logo.svg')">

                    <!-- Name -->
                    <img alt="Name"
                         class="h-13px mt-1px"
                         :src="asset('img/name.svg')">

                    <!-- News -->
                    <v-news></v-news>

                </div>

                <!-- Menus -->
                <div class="flex items-center">

                    <!-- Guest -->
                    <div v-if="isGuest()">

                        <!-- Login -->
                        <v-link :url="route('login')"
                                class="text-13px text-gray-500 hover:text-gray-300 uppercase">

                            <!-- Text -->
                            Sign in

                        </v-link>

                    </div>

                    <!-- Authenticated -->
                    <div v-if="isAuthenticated()"
                         class="flex items-center">

                        <!-- Admin -->
                        <i title="Admin"
                           v-if="isEmployee()"
                           @click.stop="redirect('dashboard.admin')"
                           class="fas fa-lock text-18px text-gray-600 hover:text-white cursor-pointer transition duration-300 mr-7">
                        </i>

                        <!-- Avatar -->
                        <img title="Menu"
                             :alt="prop('user.name')"
                             :ref="`avatar-${prop('user.id')}`"
                             @click.stop="showMenu('navigator')"
                             :src="userAvatar(prop('user.avatar'))"
                             class="w-26px h-26px rounded-full cursor-pointer mt-1px"
                             @error="$refs[`avatar-${prop('user.id')}`].src = userAvatar()">

                    </div>

                </div>

            </div>
        </div>

        <!-- Mobile -->
        <div v-if="! dialog"
             class="bg-gray-100 border-b border-gray-300 flex justify-between lg:hidden px-6 py-4">

            <!-- Left -->
            <div @click.stop="showMenu('sidebar')"
                 class="flex items-center text-13px cursor-pointer">

                <!-- Hamburger -->
                <i class="fas fa-bars text-16px text-gray-500 relative top-1px mr-10px"></i>

                <!-- Text -->
                <span class="text-gray-800 relative top-1px">
                    Menu
                </span>

            </div>

            <!-- Right -->
            <div @click="window.scrollTo(0, 0)"
                 class="flex items-center justify-end text-13px cursor-pointer">

                <!-- Text -->
                <span class="text-gray-800 relative top-1px">
                    Top
                </span>

                <!-- Hamburger -->
                <i class="fas fa-arrow-up text-16px text-gray-500 relative top-1px ml-2"></i>

            </div>

        </div>

        <!-- Navigator -->
        <v-navigator :open="menus.navigator"
                     @closed="hideMenu('navigator')">
        </v-navigator>

        <!-- Sidebar -->
        <v-sidebar :open="menus.sidebar"
                   @closed="hideMenu('sidebar')">

            <!-- Slot -->
            <slot name="sidebar"></slot>

        </v-sidebar>

    </header>
</template>

<script>
    import SidebarPartial from './sidebar.vue';
    import NavigatorPartial from './navigator.vue';
    import LinkComponent from '@/components/link.vue';
    import NewsComponent from '@/components/news.vue';
    import InteractsWithImages from '@/mixins/InteractsWithImages';
    import InteractsWithAuthorization from '@/mixins/InteractsWithAuthorization';
    import InteractsWithAuthentication from '@/mixins/InteractsWithAuthentication';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithImages,
            InteractsWithAuthorization,
            InteractsWithAuthentication,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-link'      : LinkComponent,
            'v-navigator' : NavigatorPartial,
            'v-news'      : NewsComponent,
            'v-sidebar'   : SidebarPartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            menus : {
                sidebar   : false,
                navigator : false,
            },

            styles : [
                'fixed',
                'lg:static',
                'overflow-hidden',
                'lg:overflow-visible',
                'top-[54px]',
                'bottom-[72px]',
                'md:bottom-[54px]',
                'left-4',
            ]
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'dialog' : { type : Boolean, default : false },
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on('show-sidebar-menu', () => this.showMenu('sidebar'));
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('show-sidebar-menu');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Hide the given menu.
             *
             */
            hideMenu(menu)
            {
                this.menus[menu] = false;

                document.querySelector('section').classList.remove(...this.styles);
            },

            /**
             * Show the given menu.
             *
             */
            showMenu(menu)
            {
                if (this.menus[menu]) {
                    return this.hideMenu(menu);
                }

                for (let item in this.menus) {
                    this.menus[item] = false;
                }

                this.menus[menu] = true;

                document.querySelector('section').classList.add(...this.styles);
            },
        }
    }
</script>