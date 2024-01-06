<template>
  <!-- Use symbols as they would be used in literature -->
  <div class="letters-container">
    <!-- Opens to hold word like {projects} -->
    <div :style="{ opacity: hoverS ? 0 : 1 }" id="pr" @mouseover="startRotation" @mouseout="stopRotation">
      Pr
    </div>
    <!-- Maybe Make into a semicolon -->
    <!-- <span id="s" @mouseover="hoverS = true" @mouseout="hoverS = false">
      S
    </span>
    <div id="studio-fanelli-hidden--container">
      <div id="tudio" class="studio-fanelli-hidden--letters">
        tudio
      </div>
      <div id="fanelli" class="studio-fanelli-hidden--letters">
        Fanelli
      </div>
    </div> -->
    <div id="design-develop-innovate">design. develop. innovate.</div>
    <div id="projects-hidden--container">
      <div id="ojects" @mouseover="startRotation" @mouseout="stopRotation" @click="toggleProjects"
        class="projects-hidden--letters">
        <span class="letter" style="transform: rotate(-180deg);">o</span>
        <span class="letter" style="transform: rotate(180deg);">j</span>
        <span class="letter" style="transform: rotate(-270deg);">e</span>
        <span class="letter" style="transform: rotate(-180deg);">c</span>
        <span class="letter" style="transform: rotate(180deg);">t</span>
        <span class="letter" style="transform: rotate(180deg);">s</span>
      </div>
    </div>
    <!-- Lines become one or rotate to become underline or carot for text
    - io sono Ryan Fanelli...
    -->
    <div class="slash-container">
      <span id="slash-left" class="slash">
        /
      </span>
      <span id="slash-right" class="slash">
        /
      </span>
      <div id="about-me">Not only a dedicated software engineer with a passion for knowledge and creativity, but also an innovative problem solver with keen observation skills. An amicable person that will inspire confidence and curiosity amongst a team. I deliver performance driven by efficiency and adaptability.</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Logo',
  data() {
    return {
      hoverS: false,
      projectsHovered: false,
    };
  },
  methods: {
    startRotation() {
      document.getElementById('pr').classList.add('rotate-on-hover');
    },
    stopRotation() {
      document.getElementById('pr').classList.remove('rotate-on-hover');
    },
    toggleProjects() {
      this.projectsHovered = !this.projectsHovered;
    },
  },
};
</script>

<style scoped lang="scss">
// // Film Noir Palette
// $color1: #413E3D; // Raven
// $color2: #A7A1A7; // Gull Grey
// $color3: #c71f2d; // High Risk Red
// $color4: #A19E9D; // Ash
// $color5: #DCD7D4; // White Sand

// Henry Taylor Palette
// $color1: #452005; // Brown/Red
// $color2: #037c7c; // Gull Grey
// $color3: #c71f2d; // High Risk Red
// $color4: #A19E9D; // Ash
// $color5: #DCD7D4; // White Sand

// Henry Taylor Palette 2
$color2: #451805d6; // Brown/Red
$color3: #037c7c; // Gull Grey
$color1: #d4390d; // High Risk Red
$color4: #004f0b; // Ash
$color5: #DCD7D4; // White Sand

.letters-container {
  display: flex;
  text-align: justify;

  #pr {
    font-size: 11rem;
    font-weight: bold;
    transform: rotate(90deg);
    position: absolute;
    left: 23rem;
    opacity: 1;
    transition: opacity 1s ease;
    z-index: 1;
    height: fit-content;
    color: $color1;
  }

  #pr::after {
    content: "";
    position: absolute;
    bottom: 0;
    right: -31rem;
    width: 0;
    height: 2.5px;
    background-color: $color1;
    transform-origin: 0% 100%;
    /* Adjusted transform-origin */
    transition: width 2s ease;
  }

  #pr.rotate-on-hover::after {
    width: 225%;
    transition: width 2s ease;
  }

  #pr.rotate-on-hover {
    cursor: pointer;
    transform: rotate(0deg);
    transition: transform 1s ease;
  }


  #s {
    font-weight: bold;
    font-size: 18rem;
    color: $color2;
    cursor: pointer;
    position: absolute;
    transition: opacity 1s ease;
    height: fit-content;
  }

  .slash {
    // transform: rotate(180deg);
    font-weight: 500;
    font-size: 15rem;
    color: $color3;
    cursor: pointer;
    position: absolute;
    right: 35rem;
    top: 25rem;
    transition: opacity 1s ease, letter-spacing 2s ease;
    height: fit-content;
    z-index: 10;
  }

  #pr.rotate-on-hover~#s {
    opacity: 0;
  }

  #pr:hover~#projects-hidden--container {
    opacity: 1;

    .letter {
      display: inline;
      transform: rotate(0deg);
      transition: transform 1s ease;
    }
  }

  #pr:hover~#projects-hidden--container .projects-hidden--letters {
    opacity: 1;
  }

  #s:hover+#studio-fanelli-hidden--container .studio-fanelli-hidden--letters {
    opacity: 1;
  }

  #pr:hover~.slash-container {
    opacity: 0;
  }

  #s:hover~#ojects {
    opacity: 0;
    transition: opacity 1s ease;
  }

  #s:hover~#projects-hidden--container {
    opacity: 0;
    transition: 1s ease;
  }

  .hidden-container {
    display: flex;
    flex-direction: column;
    position: absolute;
  }

  .hidden--letters {
    font-weight: bold;
    font-size: 12rem;
    color: black;
    opacity: 0;
    transition: opacity 1s ease;
    width: max-content;
  }

  #studio-fanelli-hidden--container {
    @extend .hidden-container;

    .studio-fanelli-hidden--letters {
      @extend .hidden--letters;
    }

    #tudio {
      position: absolute;
      top: 40px;
      color: $color2;
    }

    #fanelli {
      position: absolute;
      bottom: 48px;
      color: $color1;
    }
  }

  #design-develop-innovate {
    position: absolute;
    font-size: 1.75rem;
    top: 21.85rem;
    right: 25.2rem;
    width: -moz-max-content;
    width: max-content;
    transition: 0.5s ease;
    color: $color3;
    z-index: 10;
  }

  #design-develop-innovate:hover {
    cursor: pointer;
    transition: 0.5s ease;
    color: $color4;
  }

  #projects-hidden--container {
    position: absolute;
    z-index: 2;
    @extend .hidden-container;

    .projects-hidden--letters {
      @extend .hidden--letters;
      font-size: 11rem;
      font-weight: bold;
    }

    #ojects {
      position: absolute;
      left: -11rem;
      color: $color1;
      opacity: 0.25;
    }

    .letter {
      display: inline-block;
      transition: transform 1s ease;
    }

    #ojects:hover .letter {
      display: inline;
      transform: rotate(0deg);
      transition: transform 1s ease;
    }

    #ojects:hover {
      opacity: 1;
      cursor: pointer;
    }
  }

  .slash-container {
    position: absolute;
    width: 100%;
    left: 0rem;
    top: 0rem;
  }

  #slash-left {
    left: 23rem;
    transition: left 2s ease, transform 2s ease, top 2s ease;
  }

  #slash-right {
    right: 55rem;
    transition: right 2s ease, transform 2s ease, top 2s ease;
  }

  .slash-container:hover {
    #slash-left {
      top: 20rem;
      left: 20rem;
      transform: rotate(-22deg);
    }

    #slash-right {
      right: 20rem;
      transform: rotate(-22deg);
    }

    #about-me {
      opacity: 1;
      transition: opacity 5s ease;
    }
  }

  #about-me {
    width: 40%;
    position: absolute;
    bottom: -36rem;
    opacity: 0;
    left: 27rem;
    top: 31rem;
    font-size: 1.25rem;
    color: $color2
  }
}
</style>
