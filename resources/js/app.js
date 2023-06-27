/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import App from "./App.vue";
import router from "@/router";
import { createApp } from "vue/dist/vue.esm-bundler";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import * as ElementPlusIconsVue from "@element-plus/icons-vue";

//import theme
import "./theme/index.scss";

//import unocss
import "uno.css";

import "@/styles/index.scss"; // global css
//i18n
import { setupI18n } from "@/lang";
//import element-plus
import ElementPlus from "element-plus";
//svg-icon
import "virtual:svg-icons-register";
import svgIcon from "@/icons/SvgIcon.vue";
import directive from "@/directives";

//import router intercept
import "./permission";

//import element-plus
import "element-plus/dist/index.css";
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp(App);
//router
app.use(router);

//pinia
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
app.use(pinia);

//i18n
app.use(setupI18n);
app.component("SvgIcon", svgIcon);
for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
    app.component(key, component);
}
directive(app);

//element-plus
app.use(ElementPlus);
// import ExampleComponent from "./components/ExampleComponent.vue";
// app.component("example-component", ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount("#app");
