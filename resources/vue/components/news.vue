<template>
    <div class="news relative">
        <div class="headway absolute -top-4 left-2px">
            <!-- Content -->
        </div>
    </div>
</template>

<script>
    export default {

        /**
         * Actions to perform when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            loadScript('https://cdn.headwayapp.co/widget.js');

            when(() => window.Headway, () => this.show());
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Display the component.
             *
             */
            show()
            {
                this.$el.firstChild.innerHTML = '';

                Headway.init({
                    account      : 'JlODQ7',
                    selector     : '.headway',
                    translations : {
                        title    : 'The Latest News',
                        footer   : 'Read more',
                        readMore : 'Read more',
                    }
                });
            },
        }
    }
</script>