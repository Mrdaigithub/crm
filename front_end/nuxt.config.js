module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    title: 'Crm system',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Crm system project' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#3B8070' },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** Run ESLINT on save
    */
    extend (config, ctx) {
      if (ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    },

    vendor: ['axios', 'element-ui', 'echarts']
  },

  plugins: ['~plugins/element-ui', '~plugins/router-protect'],

  css: ['element-ui/lib/theme-default/index.css', '~static/fonts/iconfont.css'],
  router: {
    middleware: 'loading',
    scrollBehavior: function (to, from, savedPosition) {
      return { x: 0, y: 0 }
    }
  }
}
