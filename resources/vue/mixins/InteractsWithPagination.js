export default
{
    /**
     * Define the computed properties.
     *
     */
    computed :
    {
        /**
         * Retrieve the items within the paginator.
         *
         */
        paginatorItems()
        {
            return prop(`${this.paginator}.data`, []);
        },
    },

    /**
     * Execute actions when the component is instantiated.
     *
     */
    created()
    {
        this.resetPaginator();
    },

    /**
     * Define the watch methods.
     *
     */
    watch :
    {
        /**
         * Watch the 'paginatorItems' computed property.
         *
         */
        paginatorItems : function(current, previous)
        {
            this.resetPaginator();
        }
    },

    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Mark an item in the paginator instance as deleted.
         *
         */
        deletePaginatorItem(item, key = 'id')
        {
            item.deleted = true;

            this.updatePaginatorItem(item, key);

            this.markPaginatorAsDirty();
        },

        /**
         * Retrieve the correct message to display for a paginator with no items.
         *
         */
        getPaginatorEmptyMessage(message, keys = 'search')
        {
            if (! Array.isArray(keys)) {
                return queryString(keys) ? '' : message;
            }

            let present = false;

            keys.forEach(key => queryString(key) ? present = true : null);

            return present ? '' : message;
        },

        /**
         * Determine if the paginator has no items.
         *
         */
        isPaginatorEmpty()
        {
            return blank(prop(`${this.paginator}.data`));
        },

        /**
         * Indicate that the paginator's underlying collection has been changed.
         *
         */
        markPaginatorAsDirty()
        {
            prop([`${this.paginator}.dirty`, true]);
        },

        /**
         * Perform a partial reload to fetch refreshed data from the server.
         *
         */
        reloadPaginator(term, key = 'search')
        {
            if (session.search !== undefined) {
                Object.keys(session.search.data()).forEach(field => session.search[field] = '');

                session.search[key] = term;
            }

            let url = `${location.origin}${location.pathname}${term ? `?${key}=` : ''}${term}`;

            this.$inertia.visit(url, {
                only           : [this.paginator.split('.')[0]],
                preserveScroll : true,
                preserveState  : true,
            });
        },

        /**
         * Reload the paginator if it should be reverted to the first page.
         *
         */
        resetPaginator()
        {
            if (this.shouldRevertToFirstPage()) {
                this.reloadPaginator('');
            }
        },

        /**
         * Determine whether to redirect to the first page.
         *
         */
        shouldRevertToFirstPage()
        {
            let page = prop(`${this.paginator}.current_page`, 1);

            return page !== 1 && this.isPaginatorEmpty();
        },

        /**
         * Update an item in the paginator instance.
         *
         */
        updatePaginatorItem(item, key = 'id')
        {
            let index = prop(`${this.paginator}.data`).findIndex(
                i => i[key] === item[key]
            );

            prop([`${this.paginator}.data.${index}`, item]);
        }
    }
}