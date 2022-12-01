export default
{
    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Construct a url to an image using the given parameters.
         *
         */
        _image(id = null, resource = '')
        {
            return id ? file(`images/${id}.jpg`) : asset(`img/${resource}.jpg`);
        },

        /**
         * Construct a url to an article's banner.
         *
         */
        articleBanner(id = null)
        {
            return this._image(id, 'article');
        },

        /**
         * Construct a url to a project's gallery image.
         *
         */
        projectGalleryImage(id = null)
        {
            return this._image(id, 'project');
        },

        /**
         * Construct a url to a project's logo.
         *
         */
        projectLogo(id = null)
        {
            return this._image(id, 'project');
        },

        /**
         * Construct a url to a user's avatar.
         *
         */
        userAvatar(id = null)
        {
            return this._image(id, 'user');
        },
    }
}