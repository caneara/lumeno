<template>
    <nav v-if="open"
         class="w-full bg-sky-1050 overflow-y-auto fixed z-1 top-[54px] bottom-0 right-0 md:bottom-auto lg:right-auto p-6 pb-16 md:p-10 md:pb-16 lg:px-0">

        <!-- Menus -->
        <div class="md:px-2 lg:container xl:pr-2">
            <div class="flex xl:justify-center flex-wrap gap-y-10 xl:max-w-[1280px]">

                 <!-- Menu -->
                <div v-for="menu in menus"
                     v-show="menu?.show ?? true"
                     :key="menu.name.toLowerCase()"
                     class="w-full md:w-1/3 lg:w-1/4 xl:w-1/5">

                     <!-- Title -->
                    <div class="font-semibold text-12px text-gray-600 uppercase mb-4">
                        {{ menu.name }}
                    </div>

                     <!-- Links -->
                    <v-link target="_self"
                            :key="link.route"
                            v-for="link in menu.links"
                            v-show="link?.show ?? true"
                            :inertia="link?.inertia ?? true"
                            class="block text-15px text-gray-500 hover:text-gray-500 hover:bg-sky-800/20 rounded-md px-1 py-10px md:mr-6"
                            :url="(link?.inertia ?? true) ? (Array.isArray(link.route) ? route(...link.route) : route(link.route)) : link.route">

                             <!-- Icon -->
                            <i class="fas fa-fw text-16px mr-5px"
                               :class="[link.color, `fa-${link.icon}`]">
                            </i>

                             <!-- Text -->
                            {{ link.text }}

                     </v-link>

                 </div>

            </div>
        </div>

    </nav>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import InteractsWithOutside from '@/mixins/InteractsWithOutside';
    import InteractsWithAuthorization from '@/mixins/InteractsWithAuthorization';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithOutside,
            InteractsWithAuthorization,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-link' : LinkComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            menus : [
                {
                    name  : 'Account',
                    links : [
                        {
                            icon  : 'home',
                            text  : 'Home',
                            route : 'dashboard.user',
                            color : 'text-emerald-500/60',
                        }, {
                            icon  : 'cog',
                            text  : 'Manage',
                            route : 'account.edit',
                            color : 'text-gray-500/60',
                        }, {
                            icon  : 'comments',
                            text  : 'Support',
                            route : 'support',
                            color : 'text-sky-500/60',
                        }, {
                            icon  : 'right-from-bracket',
                            text  : 'Sign out',
                            color : 'text-purple-400/70',
                            route : 'logout',
                        },
                    ],
                }, {
                    name  : 'Profile',
                    links : [
                        {
                            icon  : 'tools',
                            text  : 'Skills',
                            color : 'text-yellow-400/50',
                            route : 'skills',
                        }, {
                            icon  : 'cube',
                            text  : 'Projects',
                            color : 'text-sky-500/60',
                            route : 'projects',
                        }, {
                            icon  : 'newspaper',
                            text  : 'Articles',
                            color : 'text-purple-400/70',
                            route : 'articles',
                        }, {
                            icon  : 'graduation-cap',
                            text  : 'Schools',
                            color : 'text-emerald-500/60',
                            route : 'schools',
                        }, {
                            icon  : 'briefcase',
                            text  : 'Workplaces',
                            color : 'text-cyan-500/60',
                            route : 'workplaces',
                        },
                    ],
                }, {
                    name  : 'Organization',
                    links : [
                        {
                            icon  : 'cog',
                            text  : 'Manage',
                            color : 'text-gray-500/60',
                            route : 'organization',
                            show  : this.isManager(),
                        }, {
                            icon  : 'plus',
                            text  : 'Create',
                            color : 'text-emerald-500/60',
                            route : 'organization.create',
                            show  : ! prop('organization'),
                        }, {
                            icon  : 'users',
                            text  : 'Members',
                            color : 'text-emerald-500/60',
                            route : 'members',
                            show  : this.isManagerOrAssociate(),
                        }, {
                            icon  : 'id-card-alt',
                            text  : 'Vacancies',
                            color : 'text-sky-500/60',
                            route : 'vacancies',
                            show  : this.isManagerOrAssociate(),
                        },
                    ],
                },
            ],
        }},

        /**
         * Define the events.
         *
         */
        emits : ['closed'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'open' : { type : Boolean, default : false },
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
	    	/**
	    	 * Hide the component.
	    	 *
	    	 */
	    	closeComponent()
	    	{
                this.$emit('closed');
	    	},

	    	/**
	    	 * Determine if the component is open or visible.
	    	 *
	    	 */
	    	isComponentOpen()
	    	{
                return this.open;
	    	},
        },
    }
</script>