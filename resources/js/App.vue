<template>
  <div>
    <component :is="this.$route.meta.layout || 'div'">
      <router-view />
    </component>
  </div>
</template>

<script>
import Nav from "./components/Nav.vue";
import axios from "axios";

export default {
  async created() {
    console.log('getting user')
    //const response = await axios.get("user");
    // this.$store.dispatch('user', response.data);
    // console.log(response.data)
    // window.user = response.data
  },
};
</script>

<style>
</style>
