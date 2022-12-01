export default
{
    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Determine if daylight savings time is being observed.
         *
         */
        _isDaylightSavingsObserved()
        {
            let offset = Math.max(
                new Date(new Date().getFullYear(), 0, 1).getTimezoneOffset(),
                new Date(new Date().getFullYear(), 6, 1).getTimezoneOffset()
            );

            return new Date().getTimezoneOffset() < offset;
        },

        /**
         * Retrieve the user's country using their browser configuration.
         *
         */
        getUserCountry()
        {
            let code = (navigator.language.split('-')[1] ?? navigator.language).toUpperCase();

            return code ? code : null;
        },

        /**
         * Retrieve the repository identifier for the user's country.
         *
         */
        getUserCountryID(repository = 'countries')
        {
            let code = this.getUserCountry();

            return code ? prop(repository).find(item => item.code === code)?.id : null;
        },

        /**
         * Retrieve the user's currency using their browser configuration.
         *
         */
        getUserCurrency(repository = 'countries')
        {
            let code = this.getUserCountry();

            return code ? prop(repository).find(item => item.code === code)?.currency : null;
        },

        /**
         * Retrieve the repository identifier for the user's currency.
         *
         */
        getUserCurrencyID(repository = 'currencies')
        {
            let code = this.getUserCurrency();

            return code ? prop(repository).find(item => item.code === code)?.id : null;
        },

        /**
         * Retrieve the user's language using their browser configuration.
         *
         */
        getUserLanguage()
        {
            let code = navigator.language.split('-')[0].toUpperCase();

            return code ? code : null;
        },

        /**
         * Retrieve the repository identifier for the user's language.
         *
         */
        getUserLanguageID(repository = 'languages')
        {
            let code = this.getUserLanguage();

            return code ? prop(repository).find(item => item.code === code)?.id : null;
        },

        /**
         * Retrieve the user's time zone using their browser configuration.
         *
         */
        getUserTimeZone()
        {
            let minutes = new Date().getTimezoneOffset();

            if (this._isDaylightSavingsObserved()) {
                minutes += 60;
            }

            if (minutes < 0) {
                return parseInt(Math.abs(minutes) / 60);
            } else {
                return -Math.abs(parseInt(minutes / 60));
            }
        },

        /**
         * Retrieve the repository identifier for the user's time zone.
         *
         */
        getUserTimeZoneID(repository = 'time_zones')
        {
            let offset = this.getUserTimeZone();

            return prop(repository).find(item => item.offset === offset)?.id;
        },
    }
}