<template>
  <!-- Use symbols as they would be used in literature -->
  <div class="letters-container">
    <!-- Opens to hold word like {projects} -->
    <div :style="{ opacity: hoverS ? 0 : 1 }" id="pr" @mouseover="startRotation" @mouseout="stopRotation">
      Pr
    </div>
    <span id="s" class="visible-letter" @mouseover="hoverS = true" @mouseout="hoverS = false">
      S
    </span>
    <div id="studio-fanelli-hidden--container">
      <div id="tudio" class="studio-fanelli-hidden--letters">
        tudio
      </div>
      <div id="fanelli" class="studio-fanelli-hidden--letters">
        Fanelli
      </div>
    </div>
    <div id="design-develop-innovate">design. develop. innovate.</div>
    <div id="projects-hidden--container">
      <div id="ojects" @mouseover="startRotation" @mouseout="stopRotation" class="projects-hidden--letters">
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
    <span id="b" class="visible-letter">
      B
    </span>
  </div>
</template>

<script>
export default {
  name: 'Logo',
  data() {
    return {
      hoverS: false,
    };
  },
  methods: {
    startRotation() {
      document.getElementById('pr').classList.add('rotate-on-hover');
    },
    stopRotation() {
      document.getElementById('pr').classList.remove('rotate-on-hover');
    },
  },
};
</script>

<style scoped lang="scss">
// Film Noir Palette
$color1: #413E3D; // Raven
$color2: #A7A1A7; // Gull Grey
$color3: #c71f2d; // High Risk Red
$color4: #A19E9D; // Ash
$color5: #DCD7D4; // White Sand

.letters-container {
  display: flex;
  text-align: justify;

  #pr {
    font-size: 11rem;
    font-weight: bold;
    transform: rotate(90deg);
    position: relative;
    left: 23.5rem;
    bottom: -3rem;
    opacity: 1;
    transition: opacity 1s ease, transform 2s ease;
    z-index: 1;
    height: fit-content;
    color: $color1;
  }

  #pr::after {
    content: "";
    position: absolute;
    bottom: -25px;
    /* Adjust this value to control the distance between text and line */
    left: 0;
    width: 100%;
    height: 5px;
    /* Adjust this value to control the line thickness */
    background-color: $color1;
    transform-origin: 75%;
    transform: scaleX(0);
    /* Initial scale to make the line invisible */
    transition: transform 1s ease;
  }

  #pr.rotate-on-hover {
    cursor: pointer;
    transform: rotate(0deg);
    transition: transform 1s ease;
  }

  #pr.rotate-on-hover::after {
    transform: scaleX(-50);
    transition: transform 2s ease;
    /* Scale to make the line visible */
  }

  #s {
    font-weight: bold;
    font-size: 18rem;
    color: $color2;
    cursor: pointer;
    position: relative;
    transition: opacity 1s ease;
    height: fit-content;
  }

  #b {
    transform: rotate(180deg);
    font-weight: 500;
    font-size: 15rem;
    color: $color3;
    cursor: pointer;
    position: relative;
    right: 35rem;
    top: 15.5rem;
    transition: opacity 1s ease;
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

  #pr:hover~#b {
    opacity: 0;
  }

  #projects-hidden--container::v-deep #ojects:hover~#b {
  opacity: 0;
  transition: opacity 1s ease;
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
    position: relative;
    top: 1px;
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
      position: relative;
      top: 40px;
      color: $color2;
    }

    #fanelli {
      position: relative;
      bottom: 48px;
      color: $color1;
    }
  }

  #design-develop-innovate {
    position: absolute;
    font-size: 1.75rem;
    top: calc(25rem + -8px);
    right: 44.75rem;
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
    position: relative;
    z-index: 2;
    @extend .hidden-container;

    .projects-hidden--letters {
      @extend .hidden--letters;
      font-size: 11rem;
      font-weight: bold;
    }

    #ojects {
      position: relative;
      left: -23.5rem;
      top: calc(3rem + -1px);
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

  #b:hover {
    transform: rotate(0deg);
    transition: 1s ease;
  }
}
</style>
