import Vue from "vue";
import Router from "vue-router";
import UserList from "./views/UserList.vue";
import UserSkill from "./views/UserSkill.vue";
import NotFound from "./views/NotFound.vue";

Vue.use(Router);

const router = new Router({
  mode: "history",
  linkExactActiveClass: "vue-school-active-class",
  routes: [
    {
      path: "/",
      name: "home",
      component: UserList,
      props: true
    },
    {
      path: "/user/:username",
      name: "UserSkill",
      component: UserSkill,
      props: true
    },
    {
      path: "/404",
      alias: "*",
      name: "notFound",
      component: NotFound
    }
  ]
});

export default router;
