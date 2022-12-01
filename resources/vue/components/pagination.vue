<template>
    <div class="pagination"
         :class="! infinite && (prop(`${paginator}.prev_page_url`) || prop(`${paginator}.next_page_url`)) ? styles : ''">

        <!-- Back & Forth -->
        <div class="flex items-center"
             :class="prop(`${paginator}.dirty`) ? 'justify-end' : 'justify-between'"
             v-if="! infinite && (prop(`${paginator}.prev_page_url`) || prop(`${paginator}.next_page_url`))">

            <!-- Position -->
            <span v-html="getFooterMessage()"
                  v-if="! prop(`${paginator}.dirty`)"
                  class="uppercase font-medium text-gray-600/60 text-12px relative top-6px mt-20px md:mt-1 mb-4 md:mb-0">
            </span>

            <!-- Toolbar -->
            <div :class="prop(`${paginator}.dirty`) ? 'mt-20px' : ''"
                 class="pagination flex justify-end pl-0 rounded mt-4 mb-0 flex-wrap">

                <!-- Previous Page (Disabled) -->
                <div v-if="blank(prop(`${paginator}.prev_page_url`))"
                     class="bg-gray-100 py-2 pl-13px pr-3 select-none rounded rounded-r-none border border-gray-400/80 cursor-not-allowed border-r-0">

                    <!-- Arrow -->
                    <i class="fas fa-arrow-left text-14px text-gray-500/50"></i>

                </div>

                <!-- Previous Page (Enabled) -->
                <div title="Previous Page"
                     v-if="prop(`${paginator}.prev_page_url`)"
                     class="bg-white select-none rounded rounded-r-none border border-gray-400/80 border-r-0 group cursor-pointer
                            hover:bg-orange-200/25 transition duration-300">

                    <!-- Link -->
                    <v-link :scroll="scroll"
                            :url="createUrl(prop(`${paginator}.prev_page_url`))">

                        <!-- Icon -->
                        <i class="fas fa-arrow-left py-9px px-3 text-14px text-gray-800/50 relative top-1px"></i>

                    </v-link>

                </div>

                <!-- Next Page (Enabled) -->
                <div title="Next Page"
                     v-if="prop(`${paginator}.next_page_url`)"
                     class="bg-white select-none rounded rounded-l-none border border-gray-400/80 group cursor-pointer
                            hover:bg-orange-200/25 transition duration-300">

                    <!-- Link -->
                    <v-link :scroll="scroll"
                            :url="createUrl(prop(`${paginator}.next_page_url`))">

                        <!-- Icon -->
                        <i class="fas fa-arrow-right py-9px px-3 text-14px text-gray-800/50 relative top-1px"></i>

                    </v-link>

                </div>

                <!-- Next Page (Disabled) -->
                <div v-if="! prop(`${paginator}.next_page_url`)"
                     class="bg-gray-100 py-2 px-3 select-none rounded rounded-l-none border border-gray-400/80 cursor-not-allowed">

                    <!-- Arrow -->
                    <i class="fas fa-arrow-right text-14px text-gray-500/50"></i>

                </div>

            </div>

        </div>

        <!-- Infinite -->
        <div class="flex items-center mt-4 mb-5 md:mt-6 md:mb-0"
             v-if="infinite && prop(`${paginator}.next_page_url`)">

            <!-- Left Line -->
            <div class="bg-gray-300 h-2px flex-1"></div>

            <!-- Load More -->
            <div @click="loadMore()"
                 dusk="paginator-load-more"
                 class="bg-white hover:bg-gray-100 border border-gray-300
                        font-semibold text-13px text-gray-600 uppercase rounded
                        cursor-pointer transition duration-300 px-6 py-3">

                <!-- Text -->
                Load More

            </div>

            <!-- Right Line -->
            <div class="bg-gray-300 h-2px flex-1"></div>

        </div>

    </div>
</template>

<script>
    import LinkComponent from './link.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link' : LinkComponent,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'scroll'    : { type : Boolean, default : false },
            'styles'    : { type : String,  default : '' },
            'message'   : { type : String,  default : '' },
            'infinite'  : { type : Boolean, default : false },
            'paginator' : { type : String,  default : '' },
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Generate a URL using the given link.
             *
             */
            createUrl(link)
            {
                let pair = link.split('?')[1].split('=');

                let query = queryString();

                query.set(pair[0], pair[1]);

                return `${link.split('?')[0]}?${query.toString()}`;
            },

            /**
             * Retrieve the summary of the current position within the paginator.
             *
             */
            getFooterMessage()
            {
                let from = prop(`${this.paginator}.from`, '').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                let to   = prop(`${this.paginator}.to`, '').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                let page = prop(`${this.paginator}.current_page`, '').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                return `
                    <span class="font-medium">Page</span>
                    <span class="mx-1px text-gray-700/80">${page},</span>
                    <span class="ml-1 font-medium">Items</span>
                    <span class="ml-1px text-gray-700/80">${from}</span>
                    <span class="-mx-1px relative -top-half-px">-</span>
                    <span class="ml-1px text-gray-700/80">${to}</span>
                `;
            },

            /**
             * Retrieve the next batch of items.
             *
             */
            loadMore()
            {
                let options = {
                    headers : {
                        'Content-Type'                : 'application/json',
                        'X-Inertia'                   : true,
                        'X-Inertia-Partial-Component' : vue.$inertia.page.component,
                        'X-Inertia-Partial-Data'      : this.paginator,
                    }
                }

                axios.get(prop(`${this.paginator}.next_page_url`), {}, options)
                    .then(({data}) => this.updatePaginator(data.props[this.paginator]));
            },

            /**
             * Synchronize the given data with the existing paginator.
             *
             */
            updatePaginator(data)
            {
                prop([`${this.paginator}.current_page`, data.current_page]);
                prop([`${this.paginator}.next_page_url`, data.next_page_url]);

                data.data.forEach(item => prop(`${this.paginator}.data`).push(item));
            }
        },
    }
</script>