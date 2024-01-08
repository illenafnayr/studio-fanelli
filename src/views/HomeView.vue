<template>
  <div class="home">
    <CurlyBrackets :text="updatedText" @click="showPage = !showPage" />
    <Vignelli v-if="showPage" @text-updated="handleTextUpdate" />
    <!-- <Logo v-if="showPage" /> -->
  </div>
</template>

<script>
// @ is an alias to /src
// import Logo from '@/components/Logo.vue'
import Vignelli from '@/components/Vignelli.vue';
import CurlyBrackets from '@/components/CurlyBrackets.vue';

export default {
  name: 'HomeView',
  components: {
    // Logo,
    CurlyBrackets,
    Vignelli,
},
  methods: {
    handleTextUpdate(updatedText) {
      this.updatedText = updatedText;
    },
  },
  data() {
    return {
      showPage: false,
      updatedText: undefined,
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
