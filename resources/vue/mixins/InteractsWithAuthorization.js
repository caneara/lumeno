export default
{
    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Determine if the authenticated user has the 'associate' role.
         *
         */
        isAssociate()
        {
            return prop('member.role') === 2;
        },

        /**
         * Determine if the authenticated user has the 'employee' type.
         *
         */
        isEmployee()
        {
            return prop('user.type') === 2;
        },

        /**
         * Determine if the authenticated user has the 'manager' role.
         *
         */
        isManager()
        {
            return prop('member.role') === 1;
        },

        /**
         * Determine if the authenticated user has the 'manager' or 'associate' role.
         *
         */
        isManagerOrAssociate()
        {
            return this.isManager() || this.isAssociate();
        },
    }
}