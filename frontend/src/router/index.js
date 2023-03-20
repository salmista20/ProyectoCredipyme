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
      path: "/gestion",
      name: "Gestion",
      component: () => import("@/views/Usuarios/Gestion.vue"),
    },
  ],
});

export default router;
