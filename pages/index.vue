<template>
  <div class="home" @mousemove="updateCursor" style="cursor: none;">
    <div @mouseenter="showText">
      <Vignelli @text-updated="handleTextUpdate" :expression="palette" class="hover-target" />
    </div>
    <div @mouseenter="showText">
      <CurlyBrackets id="curly-brackets" :text="updatedText" @click="showPage = !showPage" class="hover-target" />
    </div>

    <FacialRecognition :active="facialRecognitionActive" @current-expression="updatePalette($event)" />
    <div class="emotion-tools--container" v-if="facialRecognitionActive">
      <span class="small-text">{{ palette }}</span>
      <span class="small-text">Try to smile!</span>
    </div>

    <h1 class="text margin-top-l">Digital Solutions That Speak Your Story</h1>
    <h2 class="text medium-text">Creative web development that unlocks innovative approaches to propel your business into new realms of digital possibility</h2>

    <div class="duck-to-action margin-top-l">
      <img id="duck" src="../assets/anna-duck.svg" alt="" class="animated-image">
      <div class="text small-text">start your technological journey here</div>
    </div>

    <!-- <div class="text medium-text">Throughout your technological journey, we provide inspiration, unlock innovative and
      creative approaches to propel your business into new realms of digital possibility.</div> -->
    <div class="cursor" v-if="showCursor" :style="{ top: cursorY + 'px', left: cursorX + 'px' }"></div>
    <!-- <button v-if="!facialRecognitionActive" @click="toggleFacialRecognition" class="emotion-button"><img
        src="../assets/emotion-icon.png" alt="">
      <div>Emotion Detector</div>
      <span class="small-text">
        {{ !facialRecognitionActive ? 'Clicking button will activate your camera for visual effect only.' : '' }}
        Nothing
        is recorded or saved!</span>
    </button>
    <button v-if="facialRecognitionActive" @click="toggleFacialRecognition" class="emotion-button">Turn off emotion
      detection</button> -->
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
      showCursor: false,
      cursorX: 0,
      cursorY: 0,
      textVisible: false,
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
      if (this.facialRecognitionActive) {
        this.handleTextUpdate("Smile")
      }
    },
    updateCursor(event) {
      this.cursorX = event.clientX;
      this.cursorY = event.clientY;
      this.showCursor = true;
    },
    showText() {
      this.textVisible = true;
      this.$nextTick(() => {
        this.$el.querySelectorAll('.text').forEach(textElement => {
          textElement.classList.add('visible');
        });
      });
    }
  }
}
</script>

<style scoped lang="scss">
#curly-brackets {
  margin-top: 4rem;
}

.margin-top-l {
  margin-top: 7.5rem;
}

.home {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  .duck-to-action {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
  
    #duck {
      width: 5rem;
    }
  }


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
    opacity: 0;
    transition: opacity 0.7s ease;
    margin: 0.5rem;
  }

  .text.visible {
    opacity: 1;
  }

  .hover-target:hover~.text {
    opacity: 1;
  }

  .emotion-button {
    background-color: #ffffff;
    border: none;
    color: black;
    padding: 0.5rem;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 1rem;
    margin-top: 2rem;
    // margin-bottom: 2rem;
    // cursor: pointer;
    border-radius: 3px;
    transition: all 0.2s ease-in-out;

    img {
      height: 2rem;
    }

    &:hover {
      scale: 105%;
      color: #505050;
    }
  }

  .small-text {
    font-size: 1rem;
    letter-spacing: 5px;
  }

  .medium-text {
    font-size: 1.5rem;
    font-weight: 400;
  }
}

.cursor {
  position: fixed;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.5);
  /* Semi-transparent black */
  pointer-events: none;
  /* Prevents interference with other elements */
  transition: transform 0.1s ease;
  /* Smooth movement */
}

.animated-image {
  transition: transform 0.3s ease, filter 0.3s ease;
  animation: waddle 1s infinite alternate;

  &:hover {
    transform: scale(1.1) rotate(5deg);
    filter: brightness(1.1);
  }
}

@keyframes waddle {
  0% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-10px);
  }

  100% {
    transform: translateY(0);
  }
}
</style>
