<template>
    <div @click="handleClick()" class="brackets-container" :class="{ 'open': clicked }" 
         @mouseover="hoverEnabled && !clicked ? expandBrackets() : undefined">
      <div class="brackets"
        :style="{ width: containerWidth, letterSpacing: letterSpacing, transition: containerTransition }">
        <span>{{ '{' }}</span>
        <span v-if="showText" :class="{ faded: fadeText }">{{ text }}</span>
        <span class="ellipses" v-if="!showText">...</span>
        <span>{{ '}' }}</span>
      </div>
    </div>
  </template>
  
  <script>
  const CLOSED_WIDTH = '125px';
  const OPEN_WIDTH = '475px';
  const OPEN_WIDTH_MOBILE = '375px';
  const CLOSED_LETTER_SPACING = '-25px';
  const OPEN_LETTER_SPACING = '10px';
  const OPEN_LETTER_SPACING_MOBILE = '5px';
  const TRANSITION = '0.75s ease';
  
  export default {
    props: {
      text: {
        type: String,
        default: 'Studio Fanelli'
      },
    },
    data() {
      return {
        expanded: false,
        showText: false,
        fadeText: false,
        clicked: false,
        containerWidth: CLOSED_WIDTH,
        hoverEnabled: true,
        letterSpacing: CLOSED_LETTER_SPACING,
        containerTransition: `width ${TRANSITION}, letter-spacing ${TRANSITION}`,
      };
    },
    watch: {
      text(text) {
        this.expandBrackets();
        this.hoverEnabled = true;
      },
    },
    methods: {
      handleClick() {
        if (this.clicked) {
          this.contractBrackets();
        } else {
          this.expandBrackets();
        }
  
        this.clicked = !this.clicked;
        this.hoverEnabled = false;
      },
      expandBrackets() {
        this.showText = true;
        this.fadeText = false;
        
        if (window.innerWidth <= 768) {
          this.containerWidth = OPEN_WIDTH_MOBILE;
          this.letterSpacing = OPEN_LETTER_SPACING_MOBILE;
        } else {
          this.containerWidth = OPEN_WIDTH;
          this.letterSpacing = OPEN_LETTER_SPACING;
        }
      },
      contractBrackets() {
        this.fadeText = true;
        setTimeout(() => {
          this.showText = false;
        }, 850);
        this.containerWidth = CLOSED_WIDTH;
        this.letterSpacing = CLOSED_LETTER_SPACING;
      },
    },
  };
  </script>
  
  <style scoped lang="scss">  
  .brackets-container {
    display: inline-block;
    overflow: hidden;
    // cursor: pointer;
    padding-bottom: 5rem;
  }
  
  .ellipses {
    letter-spacing: normal;
    position: relative;
    letter-spacing: 0px;
    left: 2.5px;
  }
  
  .brackets {
    display: flex;
    justify-content: space-between;
    padding: 0 10px;
  
    font-size: 2rem;
    font-weight: bold;
  }
  
  .faded {
    opacity: 0;
    transition: opacity 0.75s ease;
  }
  </style>
  