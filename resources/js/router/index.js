import { createRouter, createWebHistory } from "vue-router";

import notFound from "../components/NotFound.vue";
import invoiceIndex from "../components/invoices/index.vue";
import invoiceForm from "../components/invoices/create.vue";
import invoiceShow from "../components/invoices/show.vue";
import invoiceEdit from "../components/invoices/edit.vue";

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
        path: "/show/:id",
        component: invoiceShow,
        props: true,
    },
    {
        path: "/edit/:id",
        component: invoiceEdit,
        props: true,
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
