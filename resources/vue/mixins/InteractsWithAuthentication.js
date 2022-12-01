export default
{
    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Determine if the user is signed in.
         *
         */
        isAuthenticated()
        {
            return ! this.isGuest();
        },

        /**
         * Determine if the user is not signed in.
         *
         */
        isGuest()
        {
            return prop('guest');
        },
    }
}