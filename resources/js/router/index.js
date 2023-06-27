import { createWebHistory, createRouter } from "vue-router";
// import store from "@/store";
import NProgress from "nprogress"; // progress bar
/* Guest Component */
import Auth from "./modules/auth";
/* Module Component */
import Error from "./modules/error";
import Dashboard from "./modules/dashboard";

NProgress.configure({ showSpinner: false }); // NProgress Configuration

export const constantRoutes = [
    {
        path: "/redirect",
        component: import("@/layout/index.vue"),
        hidden: true,
        children: [
            {
                path: "/redirect/:path(.*)",
                component: () => import("@/views/redirect"),
            },
        ],
    },
    ...Auth,
    ...Dashboard,
    ...Error,
];

//角色和code数组动态路由
export const roleCodeRoutes = [];

/**
 * asyncRoutes
 * the routes that need to be dynamically loaded based on user roles
 */
export const asyncRoutes = [
    // 404 page must be placed at the end !!!
    {
        path: "/:catchAll(.*)",
        name: "CatchAll",
        redirect: "/404",
        hidden: true,
    },
];

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior: () => ({ top: 0 }),
    routes: constantRoutes, // short for `routes: routes`
});

// router.beforeEach((to, from, next) => {
//     NProgress.start();
//     document.title = to.meta.title;
//     if (to.meta.middleware == "guest") {
//         if (store.state.auth.authenticated) {
//             next({ name: "dashboard" });
//         }
//         next();
//     } else {
//         if (store.state.auth.authenticated) {
//             next();
//         } else {
//             next({ name: "login" });
//         }
//     }
//     NProgress.done();
// });

router.afterEach(() => {
    // finish progress bar
    NProgress.done();
});

export default router;
