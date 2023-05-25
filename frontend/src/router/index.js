import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Login.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "App",
      component: Login,
    },
    {
      path: "/login",
      name: "Login",
      component: () => import("@/views/Login.vue"),
    },
    {
      path: "/home/:showMessage",
      name: "Home",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "/usu/gestion",
      name: "Gestion",
      component: () => import("@/views/Usuarios/Gestion.vue"),
    },
    {
      path: "/man/usu/cargos",
      name: "Cargos",
      component: () => import("@/views/Mantenimiento/Usuarios/cargos.vue"),
    },
    {
      path: "/man/usu/agencias",
      name: "Agencias",
      component: () => import("@/views/Mantenimiento/Usuarios/agencias.vue"),
    },
    {
      path: "/man/usu/permisos",
      name: "Permisos",
      component: () => import("@/views/Mantenimiento/Usuarios/permisos.vue"),
    },
    {
      path: "/man/cre/sectores",
      name: "Sectores",
      component: () => import("@/views/Mantenimiento/Credito/sectores.vue"),
    },
    {
      path: "/man/cre/estados",
      name: "Estados",
      component: () => import("@/views/Mantenimiento/Credito/estados.vue"),
    },
  ],
});

export default router;
