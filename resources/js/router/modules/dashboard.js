/* Layouts */
const Layout = () => import("@/layout/index.vue");
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import("@/views/Dashboard.vue");
/* Authenticated Component */

export default [
    {
        path: "/",
        component: Layout,
        redirect: "/dashboard",
        children: [
            {
                name: "dashboard",
                path: "dashboard",
                component: Dashboard,
                meta: { title: "Dashboard", elSvgIcon: "Fold", affix: true },
            },
        ],
    },
];
