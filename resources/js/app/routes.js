import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "./pages/dashboard/Dashboard.vue";

//? Auth
import Login from "./pages/auth/Login.vue";
import Perfil from "./pages/auth/Perfil.vue";

//? Reportes
import RepGeneral from "./pages/reports/General/RepGeneral.vue";
import RepUnico from "./pages/reports/Unico/RepUnico.vue";
import RepMensual from "./pages/reports/Mensual/RepMensual.vue";
import RepDonadores from "./pages/reports/Donadores/RepDonadores.vue";

//? Usuarios
import Usuarios from "./pages/usuarios/Usuarios.vue";

//? Campaña
import Campaign from "./pages/campaign/Campaign.vue";



Vue.use(VueRouter);


export const routes = [
    {
        path: "/",
        component: Dashboard,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/login",
        component: Login,
        meta: {
            guest: true,
        },
    },
    {
        path: "/dashboard",
        component: Dashboard,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/perfil",
        component: Perfil,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/usuarios",
        component: Usuarios,
        meta: {
            requireAuth: true,
            roles: ["admin"],
        },
    },
    {
        path: "/campaign",
        component: Campaign,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/general",
        component: RepGeneral,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/unico",
        component: RepUnico,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/mensual",
        component: RepMensual,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
    {
        path: "/donadores",
        component: RepDonadores,
        meta: {
            requireAuth: true,
            roles: ["admin", "usuario"],
        },
    },
];
