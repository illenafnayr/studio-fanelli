<template>
  <div id="home" @mousemove="updateCursor" style="cursor: none;">
    <div @mouseenter="showText">
      <Vignelli @text-updated="handleTextUpdate" :expression="palette" class="hover-target"
        @mouseenter="hoveredOverVignelli = true;" />
      <div>
        <button v-if="hoveredOverVignelli && !facialRecognitionActive" @click="toggleFacialRecognition"
          class="emotion-button reveal-element"><img src="../assets/emotion-icon.png" alt="">
          <div>Mood Detector</div>
        </button>
        <button v-if="hoveredOverVignelli && facialRecognitionActive" @click="toggleFacialRecognition"
          class="emotion-button">Turn off emotion
          detection</button>
      </div>
    </div>
    <div @mouseenter="showText">
      <CurlyBrackets id="curly-brackets" :text="updatedText" @click="showPage = !showPage"
        class="hover-target reveal-element" />
    </div>

    <FacialRecognition :active="facialRecognitionActive" @current-expression="updatePalette($event)" />
    <div class="emotion-tools--container" v-if="facialRecognitionActive">
      <span class="small-text">{{ palette }}</span>
      <span class="small-text">Try to smile!</span>
    </div>

    <div class="payoff">
      <h1 class="reveal-element text margin-top-l">Digital Solutions That Speak Your Story</h1>
      <h2 class="reveal-element text medium-text">Creative I.T solutions that unlock innovative approaches to propel
        your business into new realms of digital possibility</h2>
    </div>


    <div class="duck-to-action margin-top-l">
      <img @click="showText(); handleTextUpdate('Studio Fanelli')" id="duck" src="../assets/anna-duck.svg" alt="Animated duck representing technological journey" class="animated-image">
      <div class="small-text">start your technological journey here</div>
    </div>

    <!-- <div class="text medium-text">Throughout your technological journey, we provide inspiration, unlock innovative and
      creative approaches to propel your business into new realms of digital possibility.</div> -->
    <div class="cursor" v-if="showCursor" :style="{ top: cursorY + 'px', left: cursorX + 'px' }"></div>

    <!-- Add new parallax section -->
    <section class="reveal-element process-section">
      <div class="parallax-background">
        <div class="shape circle" :style="{ backgroundColor: getShapeColor('circle') }"></div>
        <div class="shape square" :style="{ backgroundColor: getShapeColor('square') }"></div>
        <div class="shape triangle" :style="{ borderBottomColor: getShapeColor('triangle') }"></div>
      </div>

      <div class="process-content">
        <h2 class="reveal-element text process-title visible">Our Process</h2>

        <div class="process-steps">
          <svg class="connection-line" ref="connectionLine">
            <path :d="pathData" fill="none" stroke="red" stroke-width="2" :stroke-dasharray="pathLength"
              :stroke-dashoffset="dashOffset" />
          </svg>
          <div v-for="(step, index) in processSteps" :key="step.title" class="process-step"
            :class="{ 'visible': isStepVisible(index) }">
            <div class="step-number">{{ index + 1 }}</div>
            <h3>{{ step.title }}</h3>
            <p>{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>
    POSTS:
    <Post v-if="data && data.length" :post="data" />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Vignelli from '@/components/Vignelli.vue';
import CurlyBrackets from '@/components/CurlyBrackets.vue';
import FacialRecognition from '@/components/FacialRecognition.vue';
import Post from '~/components/Post.vue';

export default {
  name: 'HomeView',
  components: {
    CurlyBrackets,
    Vignelli,
    FacialRecognition,
    Post
  },
  async setup() {
    const route = useRoute();
    const config = useRuntimeConfig();
    const data = ref([]);
    const loading = ref(true);

    const fetchPosts = async () => {
      console.log('Starting WordPress fetch with URL:', config.public.wordpressUrl);
      
      try {
        const response = await fetch(config.public.wordpressUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            query: `
             query AllPosts {
               posts(first: 100) {
                 nodes {
                   title
                   date
                   excerpt
                   uri
                   id
                 }
               }
             }`
          }),
        });

        const result = await response.json();
        console.log('Raw WordPress response:', result);

        if (!result || !result.data || !result.data.posts || !result.data.posts.nodes) {
          console.error('Invalid WordPress response structure:', result);
          return [];
        }

        const transformedData = result.data.posts.nodes.map(node => ({
          title: node.title,
          date: node.date,
          excerpt: node.excerpt,
          uri: node.uri,
          id: node.id
        }));

        console.log('Transformed WordPress data:', transformedData);
        data.value = transformedData; // Assign the transformed data
      } catch (error) {
        console.error('Error fetching WordPress data:', error);
      } finally {
        loading.value = false; // Set loading to false after fetch
      }
    };

    onMounted(() => {
      fetchPosts();
    });

    return {
      data,
      loading,
    };
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
      isTouchDevice: false,
      processSteps: [
        {
          title: 'Ideation',
          description: 'Planting the Seed of Innovation: Every great solution begins with an idea. During this phase, we partner with you to transform your vision into tangible concepts through collaborative brainstorming. Together, we explore possibilities, define challenges, and identify opportunities, setting the foundation for a digital solution that meets your needs and exceeds your expectations.'
        },
        {
          title: 'Wireframing & Architecture Design',
          description: 'Building the Blueprint of Your Vision: With a clear concept in mind, we sketch the framework of your digital solution. Through detailed wireframes and thoughtful architecture design, we focus on crafting a seamless user experience while ensuring a robust foundation for scalability and efficiency. This is where your vision takes its first shape, pixel by pixel, block by block.'
        },
        {
          title: 'Coding & Development',
          description: 'Breathing Life into Your Idea: The blueprint comes to life in this stage. Our skilled developers bring your project to reality with clean, efficient, and maintainable code. By combining cutting-edge technologies with best practices, we ensure the digital solution is not only functional but also future-ready, embodying both form and function.'
        },
        {
          title: 'Testing',
          description: 'Ensuring Perfection Through Precision: Every detail matters, and no stone is left unturned. Through rigorous testing and quality assurance, we identify and resolve potential issues to deliver a flawless user experience. From functionality to performance and security, we simulate real-world scenarios to guarantee your solution is ready for launch.'
        },
        {
          title: 'Deployment',
          description: 'Launching Your Dream into the World: Your solution is ready to meet the world. We handle the deployment process seamlessly, ensuring every detail is in place. But we don’t stop there—our commitment to you includes ongoing support to fine-tune performance and adapt to evolving needs, making sure your digital solution thrives.'
        },
        {
          title: 'Monitoring & Support',
          description: 'Cultivating Long-Term Success: The journey doesn’t end at deployment—it evolves. We continuously monitor your solution to maintain optimal performance, address any issues, and implement improvements. Our proactive support ensures that your solution grows and adapts alongside your business, ensuring its relevance and reliability for the long term.'
        }
      ],

      visibleSteps: new Set(),
      pathData: '',
      pathLength: 0,
      dashOffset: 0,
      hoveredOverVignelli: false,
    }
  },
  mounted() {
    // Detect touch device on mount
    this.isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

    // If it's a touch device, show text immediately
    if (this.isTouchDevice) {
      this.showText();
    }

    window.addEventListener('scroll', this.handleScroll);
    window.addEventListener('scroll', this.handleParallax);
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
        this.$el.querySelectorAll('.reveal-element').forEach(element => {
          element.classList.add('revealed');
        });
      });
    },
    getShapeColor(shape) {
      const colors = {
        neutral: '#A8A8A8',
        happy: '#FFD700',
        sad: '#4682B4',
        angry: '#DC143C',
        surprised: '#9370DB'
      };
      return colors[this.palette] || colors.neutral;
    },
    isStepVisible(index) {
      return this.visibleSteps.has(index);
    },
    handleScroll() {
      const steps = document.querySelectorAll('.process-step');
      steps.forEach((step, index) => {
        const rect = step.getBoundingClientRect();
        if (rect.top <= window.innerHeight * 0.75) {
          this.visibleSteps.add(index);
        }
      });
      this.updateDashOffset();

      // Call showText after scrolling a certain amount
      if (window.scrollY > 200) { // Change 300 to your desired scroll amount
        this.showText();
      }
    },
    handleParallax() {
      const scrolled = window.pageYOffset;
      const shapes = document.querySelectorAll('.shape');

      shapes.forEach((shape) => {
        const speed = shape.classList.contains('circle') ? 0.5 :
          shape.classList.contains('square') ? -0.3 : 0.2;
        const yOffset = scrolled * speed;
        const rotation = scrolled * 0.1; // Add rotation effect

        if (shape.classList.contains('square')) {
          shape.style.transform = `rotate(${45 + rotation}deg) translateY(${yOffset}px)`;
        } else if (shape.classList.contains('triangle')) {
          shape.style.transform = `rotate(${rotation}deg) translateY(${yOffset}px)`;
        } else {
          shape.style.transform = `translateY(${yOffset}px)`;
        }
      });
    },
    updatePath() {
      const steps = this.processSteps.map((_, index) =>
        this.$refs['step' + index]?.[0]?.querySelector('.step-number')
      ).filter(Boolean);

      if (steps.length < 2) return;

      let path = 'M ';
      steps.forEach((step, index) => {
        const rect = step.getBoundingClientRect();
        const x = rect.left + (rect.width / 2);
        const y = rect.top + (rect.height / 2);

        if (index === 0) {
          path += `${x} ${y}`;
        } else {
          const prevRect = steps[index - 1].getBoundingClientRect();
          const prevX = prevRect.left + (prevRect.width / 2);
          const prevY = prevRect.top + (prevRect.height / 2);

          // Create an S-curve between points
          const distance = y - prevY;
          path += ` C ${prevX} ${prevY + distance / 3}, ${x} ${y - distance / 3}, ${x} ${y}`;
        }
      });

      this.pathData = path;

      // Calculate the total length of the path
      const pathElement = this.$refs.connectionLine?.querySelector('path');
      if (pathElement) {
        this.pathLength = pathElement.getTotalLength();
        this.updateDashOffset();
      }
    },
    updateDashOffset() {
      const processSection = document.querySelector('.process-section');
      const rect = processSection.getBoundingClientRect();
      const scrollPercentage = Math.max(0, Math.min(1,
        (window.innerHeight - rect.top) / (rect.height + window.innerHeight)
      ));

      this.dashOffset = this.pathLength - (scrollPercentage * this.pathLength);
    },
    handleVignelliHover() {
      this.hoveredOverVignelli = true;
    },
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('scroll', this.handleParallax);
  }
}
</script>

<style scoped lang="scss">
// Variables
$mobile-breakpoint: 480px;
$tablet-breakpoint: 768px;
$accent-color: #000;
$text-transition: opacity 0.7s ease;

// Mixins
@mixin responsive($breakpoint) {
  @media (max-width: #{$breakpoint}) {
    @content;
  }
}

#curly-brackets {
  margin-top: 4rem;

  @include responsive($tablet-breakpoint) {
    margin-top: 2rem;
  }

  @include responsive($mobile-breakpoint) {
    margin-top: 1.5rem;
  }
}

.margin-top-l {
  margin-top: 7.5rem;

  @include responsive($tablet-breakpoint) {
    margin-top: 6rem;
  }

  @include responsive($mobile-breakpoint) {
    margin-top: 4rem;
  }
}

#home {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding-top: 5rem;

  .duck-to-action {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;

    #duck {
      width: 5rem;
    }
  }

  .payoff {
    width: 66.666%;
  }

  .emotion-tools--container {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .text {
    // width: 66.666%;
    font-size: 2rem;
    font-weight: bold;
    letter-spacing: 8px;
    margin: 0.5rem;
    @extend .reveal-element;

    @include responsive($tablet-breakpoint) {
      width: 90%;
    }

    @include responsive($mobile-breakpoint) {
      width: 95%;
    }
  }

  .hover-target:hover~.reveal-element {
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
    margin-top: 0.5rem;
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

// On touch devices, always show text
@media (hover: none) {
  .reveal-element {
    opacity: 1 !important;
  }

  .cursor {
    display: none;
  }
}

.process-section {
  position: relative;
  min-height: 100vh;
  width: 66.666%;
  overflow: visible;
  margin-top: 10rem;

  @media (min-width: $tablet-breakpoint) {
    &::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
  }
}

.parallax-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
}

.shape {
  position: absolute;
  opacity: 0.3;
  transition: transform 0.1s ease-out;
  will-change: transform;
}

.circle {
  width: 300px;
  height: 300px;
  border-radius: 50%;
  left: 10%;
  top: 20%;
}

.square {
  width: 200px;
  height: 200px;
  right: 15%;
  top: 40%;
}

.triangle {
  width: 0;
  height: 0;
  border-left: 150px solid transparent;
  border-right: 150px solid transparent;
  border-bottom: 260px solid currentColor;
  position: fixed;
  left: 5%;
  top: 70%;
  // transform: translateX(-50%);
  z-index: 999;
}

.process-content {
  position: relative;
  z-index: 1;
  padding: 2rem;
}

.process-title {
  text-align: center;
  margin-bottom: 4rem;
  width: 100%;
}

.process-steps {
  position: relative;
  width: 100%;
}

.process-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  // justify-content: center;
  min-height: 80vh;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease, transform 0.6s ease;
  text-align: center;
  margin: 2rem 0;

  &.visible {
    opacity: 1;
    transform: translateY(0);
  }
}

.step-number {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: var(--accent-color, #000);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  font-weight: bold;
}

@media (max-width: 768px) {
  .process-steps {
    padding: 0 1rem;
  }

  .shape {
    transform: scale(0.7);
  }
}

.reveal-element {
  opacity: 0;
  transition: opacity 0.7s ease;

  &.revealed {
    opacity: 1;
  }
}
</style>
