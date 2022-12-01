<template>
	<div class="flex items-end overflow-x-auto">

        <!-- Tabs -->
        <div @click="switchTab(tab)"
             :dusk="`set-tab-${tab.id}`"
             class="group cursor-pointer whitespace-nowrap select-none transition duration-300 relative z-1"
             v-for="(tab, index) in tabs.filter(tab => (tab?.show ?? true) && ((tab?.fill ?? false) === false))">

            <!-- Tab -->
            <div class="px-4 py-3 md:px-3"
                 :class="index === 0 ? 'md:-ml-1 md:mr-1' : 'md:mx-1'">

                <!-- Icon -->
                <i :title="tab.label"
                   class="fas text-20px lg:text-13px transition duration-300 lg:mr-3"
                   :class="[`fa-${tab.icon}`, tab.id === active ? 'text-sky-600 mr-4' : 'text-gray-500/65']">
                </i>

                <!-- Label -->
                <span v-html="tab.label"
                      :class="tab.id === active ? 'text-sky-600' : 'hidden lg:inline text-gray-600'"
                      class="font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                </span>

            </div>

            <!-- Border (Top) -->
            <div class="w-full h-1px transition duration-300 relative z-1"
                 :class="tab.id === active ? 'bg-sky-600/80' : 'group-hover:bg-sky-600/80'">
            </div>

            <!-- Border (Bottom) -->
            <div class="w-full h-1px transition duration-300 relative z-1"
                 :class="tab.id === active ? 'bg-sky-600/80' : 'bg-gray-300 group-hover:bg-sky-600/80'">
            </div>

        </div>

        <!-- Filler -->
        <div class="w-full h-1px bg-gray-300 rounded-lg relative z-2"></div>

        <!-- Tabs -->
        <div @click="switchTab(tab)"
             :dusk="`set-tab-${tab.id}`"
             class="group cursor-pointer whitespace-nowrap select-none transition duration-300 relative z-1"
             v-for="(tab, index) in tabs.filter(tab => (tab?.show ?? true) && ((tab?.fill ?? false) === true))">

            <!-- Tab -->
            <div class="px-4 py-3 md:px-3 md:mx-1">

                <!-- Icon -->
                <i :title="tab.label"
                   class="fas text-20px lg:text-13px transition duration-300 lg:mr-3"
                   :class="[`fa-${tab.icon}`, tab.id === active ? 'text-sky-600 mr-4' : 'text-gray-500/65']">
                </i>

                <!-- Label -->
                <span v-html="tab.label"
                      :class="tab.id === active ? 'text-sky-600' : 'hidden lg:inline text-gray-600'"
                      class="font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                </span>

            </div>

            <!-- Border (Top) -->
            <div class="w-full h-1px transition duration-300 relative z-1"
                 :class="tab.id === active ? 'bg-sky-600/80' : 'group-hover:bg-sky-600/80'">
            </div>

            <!-- Border (Bottom) -->
            <div class="w-full h-1px transition duration-300 relative z-1"
                 :class="tab.id === active ? 'bg-sky-600/80' : 'bg-gray-300 group-hover:bg-sky-600/80'">
            </div>

        </div>

	</div>
</template>

<script>
	export default
    {
        /**
         * Define the events.
         *
         */
        emits : ['change'],

		/**
		 * Define the public properties.
		 *
		 */
		props : {
			'id'     : { type : String,  default : '' },
			'tabs'   : { type : Array,   default : [] },
			'active' : { type : String,  default : '' },
		},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Change the currently active tab.
             *
             */
            switchTab(tab)
            {
                if (tab?.action) {
                    return tab.action();
                }

                localStorage.setItem(`tab_${this.id}`, tab.id);

                this.$emit('change', tab.id);
            },
        },
	}
</script>