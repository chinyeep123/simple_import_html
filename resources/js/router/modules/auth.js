const Login = () => import("@/views/auth/Login.vue");
const Register = () => import("@/views/auth/Register.vue");

export default [
    {
        name: "login",
        path: "/login",
        component: Login,
        hidden: true,
        meta: {
            middleware: "guest",
            title: `Login`,
        },
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        hidden: true,
        meta: {
            middleware: "guest",
            title: `Register`,
        },
    },
];
