<template>
  <div @click="handleClick()" class="brackets-container" :class="{ 'open': clicked }" 
       @mouseover="hoverEnabled && !clicked ? expandBrackets() : undefined" 
       @mouseleave="hoverEnabled && !clicked ? contractBrackets() : hoverEnabled = true">
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
// const OPEN_WIDTH_MOBILE = '325px';
const CLOSED_LETTER_SPACING = '-25px';
const OPEN_LETTER_SPACING = '10px';
// const OPEN_LETTER_SPACING_MOBILE = '5px';
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
      this.containerWidth = OPEN_WIDTH;
      this.letterSpacing = OPEN_LETTER_SPACING;
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
$color1: #413E3D; // Raven
$color2: #A7A1A7; // Gull Grey
$color3: #c71f2d; // High Risk Red
$color4: #A19E9D; // Ash
$color5: #DCD7D4; // White Sand

.brackets-container {
  display: inline-block;
  overflow: hidden;
  cursor: pointer;
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
