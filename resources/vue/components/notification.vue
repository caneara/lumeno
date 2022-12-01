<template>
    <div v-show="filled(message)"
         class="notification fixed top-0 right-0 z-1002 min-w-200px max-w-350px mt-21 xl:mt-20">

        <!-- Content -->
        <div class="content flex items-center border border-gray-400/80 shadow-sm rounded-lg mr-18px
                    hidden bg-white pl-15px pr-6 py-3 relative z-30 transition duration-500
                    translate-x-350px md:translate-x-450px">

            <!-- Icon -->
            <div class="opacity-70 mr-3 relative top-half-px flex self-stretch">
                <svg width="24"
                     height="24"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     :class="[(scheme.class || ''), 'fill-none']">

                    <!-- Graphic -->
                    <path stroke-width="2"
                          :d="scheme.svg || ''"
                          stroke-linecap="round"
                          stroke-linejoin="round" />

                </svg>
            </div>

            <!-- Message -->
            <span v-html="message"
                  class="message text-gray-800 text-14px relative top-2px leading-normal break-words">
            </span>

        </div>

    </div>
</template>

<script>
    export default
    {
        /**
         * Define the data model.
         *
         */
        data() { return {
            scheme  : {},
            message : '',
            schemes : {
                info    : { class : 'text-blue-700',  svg : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
                error   : { class : 'text-red-700',   svg : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' },
                success : { class : 'text-green-700', svg : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
            },
        }},

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            window.events.on('hide-notification', () => this.hide());
            window.events.on('show-notification', (payload) => this.show(...payload));

            this.flashNotification();
        },

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('hide-notification');
            clearEventListener('show-notification');
        },

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'flash' property.
             *
             */
            flash : function(current, previous)
            {
                this.flashNotification();
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Hide the notification from view.
             *
             */
            hide()
            {
                this.$el.classList.add('hidden');
            },

            /**
             * Flash a waiting notification to the user.
             *
             */
            flashNotification()
            {
                if (! prop('notification')) return;

                this.show(
                    prop('notification.message'),
                    prop('notification.type'),
                    prop('notification.fixed')
                );
            },

            /**
             * Display the notification to the user.
             *
             */
            show(message, type, fixed)
            {
                this.message = message;
                this.scheme  = this.schemes[type];

                let content = this.$el.firstElementChild;

                content.classList.add('duration-500');
                content.classList.remove('hidden');

                setTimeout(() => content.classList.remove('translate-x-350px', 'md:translate-x-450px'), 100);

                if (! fixed) {
                    let extra = message.length > 45 ? 1500 : 0;

                    setTimeout(() => content.classList.remove('duration-500'), 3000 + extra);
                    setTimeout(() => content.classList.add('translate-x-350px', 'md:translate-x-450px', 'duration-1000'), 3000 + extra);
                    setTimeout(() => content.classList.add('hidden'), 4000 + extra);
                    setTimeout(() => content.classList.remove('duration-1000'), 4000 + extra);
                }
            },
        },
    }
</script>