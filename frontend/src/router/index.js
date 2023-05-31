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
      path: "/home",
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
      path: "/man/cre/sectores",
      name: "Sectores",
      component: () => import("@/views/Mantenimiento/Credito/sectores.vue"),
    },
    {
      path: "/man/cre/productos",
      name: "Productos",
      component: () => import("@/views/Mantenimiento/Credito/productos.vue"),
    },
    {
      path: "/man/cre/categorias",
      name: "Categorias",
      component: () => import("@/views/Mantenimiento/Credito/categorias.vue"),
      
    },
    {
      path: "/man/cre/subcategorias",
      name: "Subcategorias",
      component: () => import("@/views/Mantenimiento/Credito/subcategorias.vue"),
      
    },
  ],
});

export default router;
