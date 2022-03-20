<template>
  <main>
    <Navbar v-if="isLoggedIn"></Navbar>
    <Sidebar v-if="isLoggedIn"></Sidebar>
    <transition name="zoom" mode="out-in">
      <router-view class="view"></router-view>
    </transition>
  </main>
</template>

<script>
import GlobalComponents from "../globalComponents";
export default {
  name: "App",
  data() {
    return {
      user: {},
    };
  },
  components: {
    ...GlobalComponents,
  },
  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
  },
  created() {
    if (this.isLoggedIn) {
      this.$store.dispatch("getUser");
      document.body.classList.remove("blank-page");
    }
  },
};
</script>
