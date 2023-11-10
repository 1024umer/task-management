import dashboard from '@/routes/dashboard.js' 
import baseroutes from '@/routes/baseroutes.js' 
const routesWithPrefix = (prefix, routes) => {
    return routes.map(route => {
        route.path = `${prefix}${route.path}`
        return route
    })
}
const routes = routesWithPrefix('/backend', 
[
    ...baseroutes,
    ...dashboard,
])
// const routes = [
//     ...baseroutes,
//     ...dashboard,
// ]
export default routes