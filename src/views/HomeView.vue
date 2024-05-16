<template>
  <div class="home">
    <CurlyBrackets :text="updatedText" @click="showPage = !showPage" />
    <Vignelli @text-updated="handleTextUpdate" :expression="palette" />
    <FacialRecognition :active="facialRecognitionActive" @current-expression="updatePalette($event)" />
    <button v-if="!facialRecognitionActive" @click="toggleFacialRecognition" class="emotion-button">Try our emotion detection</button>
    <div class="emotion-tools--container" v-if="facialRecognitionActive">
      <span class="small-text">{{palette}}</span>
      <span class="small-text">Try to smile!</span>
      <button @click="toggleFacialRecognition" class="emotion-button">Turn off emotion detection</button>
    </div>

    <span class="small-text">{{!facialRecognitionActive ? 'Clicking button will activate your camera for visual effect only.' : ''}} Nothing is recorded or saved!</span>
    <div class="text">Studio Fanelli transcends traditional digital solutions. We guide you through your technological
      journey, provide inspiration, unlock innovative and creative approaches to propel your business into new realms of
      possibility.</div>
  </div>
</template>

<script>
// @ is an alias to /src
import Vignelli from '@/components/Vignelli.vue';
import CurlyBrackets from '@/components/CurlyBrackets.vue';
import FacialRecognition from '@/components/FacialRecognition.vue';

export default {
  name: 'HomeView',
  components: {
    CurlyBrackets,
    Vignelli,
    FacialRecognition,
  },
  data() {
    return {
      showPage: false,
      updatedText: undefined,
      palette: 'neutral',
      facialRecognitionActive: false,
      useCamera: false,
    }
  },
  methods: {
    handleTextUpdate(updatedText) {
      this.updatedText = updatedText;
    },
    updatePalette(expression) {
      console.log("event: ", expression);
      this.palette = expression
    },
    toggleFacialRecognition() {
      this.facialRecognitionActive = !this.facialRecognitionActive;
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

  .emotion-tools--container {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .text {
    width: 66.666%;
    font-size: 2rem;
    font-weight: bold;
    letter-spacing: 10px;
  }

  .emotion-button {
    background-color: #ffffff;
    border: 1px solid black;
    color: black;
    padding: 0.5rem;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 1rem;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    cursor: pointer;
    border-radius: 3px;
    transition: all 0.2s ease-in-out;

    &:hover {
      background-color: #b8b8b8;
      color: white;
    }
  }

  .small-text {
    font-size: 0.8rem;
    color: gray;
  }
}
</style>
