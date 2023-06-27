/* Layouts */
const Layout = () => import("@/layout/index.vue");
/* Layouts */

export default [
    {
        path: "/404",
        component: () => import("@/views/error-page/404.vue"),
        hidden: true,
    },
    {
        path: "/401",
        component: () => import("@/views/error-page/401.vue"),
        hidden: true,
    },
    {
        path: "/",
        component: Layout,
        children: [
            {
                name: "coming-soon",
                path: "coming-soon",
                component: () => import("@/views/error-page/coming-soon.vue"),
                meta: {
                    title: "Cooming Soon",
                    elSvgIcon: "Loading",
                    affix: true,
                },
            },
        ],
    },
    {
        path: "/error-log",
        component: Layout,
        meta: { title: "Error Log", icon: "eye" },
        alwaysShow: true,
        children: [
            {
                path: "error-log",
                component: () => import("@/views/error-log/index.vue"),
                name: "ErrorLog",
                meta: { title: "Error Index" },
            },
            {
                path: "error-generator",
                component: () =>
                    import("@/views/error-log/error-generator.vue"),
                name: "ErrorGenerator",
                meta: { title: "Error Generator" },
            },
        ],
    },
];
