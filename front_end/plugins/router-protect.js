export default ({app}) => {
  app.router.beforeEach((to, from, next) => {
    next()
  })

  app.router.afterEach(route => {
    if (!sessionStorage.token && route.name !== 'login') app.router.replace('/dashboard')
    if (sessionStorage.token && (route.name === 'home' || route.name === 'index')) app.router.replace('/home/dashboard')
  })
}
