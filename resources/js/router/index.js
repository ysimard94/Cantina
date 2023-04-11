import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import AboutView from "@/views/AboutView.vue";
import ShowProductView from "@/views/ShowProductView.vue";
import AddProductView from "@/views/AddProductView.vue";
import UpdateProductView from "@/views/UpdateProductView.vue";
import ProductView from "@/views/ProductView.vue";
import ContactView from "@/views/ContactView.vue";
import AddTestForm from "@/views/AddTestForm.vue";
import store from "@/store";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomeView,
    },
    {
        path: "/about",
        name: "about",
        component: AboutView,
    },
    {
        path: "/show-product/:id",
        name: "show-product",
        component: ShowProductView,
    },
    {
        path: "/products",
        name: "products",
        component: ProductView,
    },
    {
        path: "/contact",
        name: "contact",
        component: ContactView,
    },
    {
        path: "/add-product",
        name: "add-product",
        component: AddProductView,
    },
    {
        path: "/update-product/:id",
        name: "update-product",
        component: UpdateProductView,
    },
    {
        path: "/test-form",
        name: "test-form",
        component: AddTestForm,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL || "/"),
    routes,
});

router.beforeEach((to, from, next) => {
    console.log("before");
    store.dispatch("setLoading", true);
    console.log(store.getters.isLoading);
    next();
});

router.afterEach(() => {
    console.log("after");
    store.dispatch("setLoading", false);
    console.log(store.getters.isLoading);
});

export { router };
