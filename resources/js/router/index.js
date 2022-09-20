import { createRouter, createWebHistory } from "vue-router";

import notFound from "../components/NotFound.vue";
import invoiceIndex from "../components/invoices/index.vue";
import invoiceForm from "../components/invoices/create.vue";

const routes = [
    {
        path: "/",
        component: invoiceIndex,
    },
    {
        path: "/create",
        component: invoiceForm,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
