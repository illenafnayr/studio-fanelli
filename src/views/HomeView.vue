<template>
  <div class="home">
    <CurlyBrackets @click="showPage = !showPage"/>
    <Logo v-if="showPage" />
  </div>
</template>

<script>
// @ is an alias to /src
import Logo from '@/components/Logo.vue'
import CurlyBrackets from '@/components/CurlyBrackets.vue';

export default {
  name: 'HomeView',
  components: {
    Logo,
    CurlyBrackets
  },
  data() {
    return {
      showPage: false
    }
  }
}
</script>

<style scoped lang="scss">
  .home {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
</style>
