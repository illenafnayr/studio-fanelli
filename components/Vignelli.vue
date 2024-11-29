<template>
    <div @mouseleave="updateText('Studio Fanelli')" class="vignelli-container">
      <div @mouseover="updateText($event, 'design')" id="circle1" class="circle">S</div>
      <div @mouseover="updateText($event, 'develop')" id="circle2" class="circle">T</div>
      <div @mouseover="updateText($event, 'innovate')" id="circle3" class="circle">U</div>
      <div @mouseover="updateText($event, 'create')" id="circle4" class="circle">D</div>
      <div @mouseover="updateText($event, 'evolve')" id="circle5" class="circle">I</div>
      <div @mouseover="updateText($event, 'engineer')" id="circle6" class="circle">O</div>
      <div @mouseover="updateText($event, 'construct')" id="circle7" class="circle"></div>
      <div @mouseover="updateText($event, 'cultivate')" id="circle8" class="circle">F</div>
      <div @mouseover="updateText($event, 'inspire')" id="circle9" class="circle">A</div>
      <div @mouseover="updateText($event, 'originate')" id="circle10" class="circle">N</div>
      <div @mouseover="updateText($event, 'revolutionize')" id="circle11" class="circle">E</div>
      <div @mouseover="updateText($event, 'conceptulize')" id="circle12" class="circle">L</div>
      <div @mouseover="updateText($event, 'formulate')" id="circle13" class="circle">L</div>
      <div @mouseover="updateText($event, 'devise')" id="circle14" class="circle">I</div>
    </div>
  </template>
  
  <script>
  
  const palettes = [
    {
      "label": "neutral",
      "colors": {
        "color1": "#808080",
        "color2": "#F5F5DC",
        "color3": "#D2B48C",
        "color4": "#D2B48C",
        "color5": "#FFFFF0",
        "color6": "#F0E68C",
        "color7": "#C2C3A3",
        "color8": "#E3C9A6"
      }
    },
    {
      "label": "happy",
      "colors": {
        "color1": "#FFFF00",
        "color2": "#FFA500",
        "color3": "#FFE5B4",
        "color4": "#FF7F50",
        "color5": "#FFB90F",
        "color6": "#FFDA77",
        "color7": "#FFF700",
        "color8": "#DAA520"
      }
    },
    {
      "label": "sad",
      "colors": {
        "color1": "#0000FF",
        "color2": "#000080",
        "color3": "#4B0082",
        "color4": "#708090",
        "color5": "#1C1C1C",
        "color6": "#0000CD",
        "color7": "#CCCCFF",
        "color8": "#191970"
      }
    },
    {
      "label": "angry",
      "colors": {
        "color1": "#FF0000",
        "color2": "#DC143C",
        "color3": "#FF2400",
        "color4": "#800000",
        "color5": "#B03060",
        "color6": "#E0115F",
        "color7": "#C70039",
        "color8": "#E34234"
      }
    },
    {
      "label": "fearful",
      "colors": {
        "color1": "#800080",
        "color2": "#E6E6FA",
        "color3": "#DDA0DD",
        "color4": "#9370DB",
        "color5": "#C8A2C8",
        "color6": "#E0B0FF",
        "color7": "#DA70D6",
        "color8": "#EED5D2"
      }
    },
    {
      "label": "disgusted",
      "colors": {
        "color1": "#008000",
        "color2": "#808000",
        "color3": "#90EE90",
        "color4": "#00FF00",
        "color5": "#8A9A5B",
        "color6": "#00A86B",
        "color7": "#50C878",
        "color8": "#98FB98"
      }
    },
    {
      "label": "surprised",
      "colors": {
        "color1": "#FFC0CB",
        "color2": "#FF00FF",
        "color3": "#FF00FF",
        "color4": "#DE3163",
        "color5": "#D7263D",
        "color6": "#FF69B4",
        "color7": "#E30B5D",
        "color8": "#FF69B4"
      }
    }
  ];
  export default {
    name: 'Vignelli',
    props: {
      expression: String,
    },
    data() {
      return {
        text: '',
        currentPalette: [
          {
            color1: '#B13624',
            color2: '#195767',
            color3: '#8A272B',
            color4: '#816E58',
            color5: '#AB3909',
            color6: '#00462C',
            color7: '#1A3656',
            color8: '#d99734'
          }
        ]
      };
    },
    mounted() {
      // this.setRandomPalette();
      this.setInitialPalette();
    },
    watch: {
      expression(newExpression) {
        this.setPaletteFromExpression(newExpression);
      },
    },
    methods: {
      updateText(event, newText) {
        if (event.target) {
          const keysArray = Object.keys(this.currentPalette);
          const randomIndex = Math.floor(Math.random() * keysArray.length);
          const randomKey = keysArray[randomIndex];
          const randomValue = this.currentPalette[randomKey];
          event.target.style.backgroundColor = randomValue;
        }
  
        this.text = newText;
        this.$emit('text-updated', this.text);
      },
      setRandomPalette() {
        const palettes = [
  
          {
            color1: '#B13624',
            color2: '#195767',
            color3: '#8A272B',
            color4: '#816E58',
            color5: '#AB3909',
            color6: '#00462C',
            color7: '#1A3656',
            color8: '#d99734'
          },
          {
            color1: '#cd412c', // Brighter Red
            color2: '#1f6d81', // Brigher Blue
            color3: '#a73337', // Brighter Red 2
            color4: '#9a8369', // Brighter Beige
            color5: '#c0440d', // Brighter Orange
            color6: '#005c3a', // Brighter Green
            color7: '#275181', // Brighter blue
            color8: '#d99734', // Brighter yellow
          },
          {
            color1: '#ff5a47', // Brighter Red
            color2: '#3ab9d2', // Brighter Blue
            color3: '#ec564f', // Brighter Red 2
            color4: '#bca987', // Brighter Beige
            color5: '#ff6e3f', // Brighter Orange
            color6: '#00a952', // Brighter Green
            color7: '#4b74b3', // Brighter Blue
            color8: '#ffd247', // Brighter Yellow
          }, {
            color1: '#ff3855',  // Vivid Red
            color2: '#00bfff',  // Sky Blue
            color3: '#ffaa00',  // Golden Yellow
            color4: '#6a0572',  // Deep Purple
            color5: '#33cc33',  // Electric Green
            color6: '#ff66b2',  // Pink Rose
            color7: '#ffa500',  // Orange
            color8: '#3c1361',  // Dark Indigo
          },
  
          // Happy
          {
            color1: '#ff4a57',  // Coral Red
            color2: '#00a8e8',  // Cerulean Blue
            color3: '#ffd700',  // Sunflower Yellow
            color4: '#8a3ab9',  // Royal Purple
            color5: '#5cb85c',  // Shamrock Green
            color6: '#ff80b3',  // Cotton Candy Pink
            color7: '#ffa64d',  // Mango Orange
            color8: '#5e2750',  // Velvet Indigo
          },
          {
            color1: '#ff5252',  // Radical Red
            color2: '#2ecc71',  // Neon Green
            color3: '#3498db',  // Electric Blue
            color4: '#e74c3c',  // Lava Orange
            color5: '#9b59b6',  // Vibrant Purple
            color6: '#f39c12',  // Sunflower Yellow
            color7: '#1abc9c',  // Aqua Green
            color8: '#e67e22',  // Tangy Orange
          },
  
          // Happy
          {
            color1: '#ff3d00',  // Blaze Orange
            color2: '#1eae98',  // Teal Blue
            color3: '#ffd700',  // Canary Yellow
            color4: '#7f00ff',  // Electric Purple
            color5: '#ff007f',  // Hot Pink
            color6: '#00bfff',  // Sky Blue
            color7: '#ff8c00',  // Dark Tangerine
            color8: '#8b4513',  // Saddle Brown
          },
  
          // Sad
          {
            color1: '#333333',  // Charcoal Gray
            color2: '#666666',  // Steel Gray
            color3: '#999999',  // Silver Gray
            color4: '#CCCCCC',  // Platinum
            color5: '#E5E5E5',  // Light Silver
            color6: '#F2F2F2',  // Pale Silver
            color7: '#FFFFFF',  // White
            color8: '#1A1A1A',  // Dark Charcoal
          },
          // Sad
          {
            color1: '#00203FFF',  // Dark Navy
            color2: '#004080FF',  // Navy
            color3: '#005EA0FF',  // Deep Sky Blue
            color4: '#0077B6FF',  // Cerulean Blue
            color5: '#0088C3FF',  // Teal Blue
            color6: '#0096C7FF',  // Azure Blue
            color7: '#00A5DFFF',  // Dodger Blue
            color8: '#00B4F2FF',  // Sky Blue
          },
          {
            color1: '#ff5252',  // Red
            color2: '#ff793f',  // Orange
            color3: '#ffac1a',  // Amber
            color4: '#ffb142',  // Apricot
            color5: '#f4d03f',  // Yellow
            color6: '#a2b9bc',  // Steel Blue
            color7: '#3498db',  // Dodger Blue
            color8: '#5dade2',  // Sky Blue
            color9: '#2ecc71',  // Emerald Green
            color10: '#27ae60', // Forest Green
            color11: '#9b59b6', // Amethyst Purple
            color12: '#8e44ad', // Purple
            color13: '#e74c3c', // Tomato Red
            color14: '#c0392b', // Cherry Red
          },
          {
            color1: '#ff4a57', // Watermelon Red
            color2: '#ffa07a', // Light Salmon
            color3: '#ffd700', // Sunflower Yellow
            color4: '#7ec8e3', // Powder Blue
            color5: '#48a9a6', // Teal Green
            color6: '#ff6b81', // Coral Pink
            color7: '#fdd2bf', // Peach Cream
            color8: '#b8e994', // Light Moss Green
            color9: '#ffcc5c', // Pastel Orange
            color10: '#95afc0', // Dusty Blue
            color11: '#cf6a87', // Rosy Pink
            color12: '#576574', // Dark Slate Gray
            color13: '#f78fb3', // Rose Quartz
            color14: '#6a0572', // Dark Purple
          }]
  
        const randomIndex = Math.floor(Math.random() * palettes.length);
        this.currentPalette = palettes[randomIndex];
  
        for (let i = 1; i <= 14; i++) {
          const circleId = `circle${i}`;
          const circleElement = document.getElementById(circleId);
          if (circleElement) {
            const colorKey = `color${i <= 8 ? i : i - 8}`;
            const color = this.currentPalette[colorKey] || '#000000';
            circleElement.style.backgroundColor = color;
          }
        }
      },
      setInitialPalette() {
        // const palette = {
        //   color1: '#333333',  // Charcoal Gray
        //   color2: '#666666',  // Steel Gray
        //   color3: '#999999',  // Silver Gray
        //   color4: '#CCCCCC',  // Platinum
        //   color5: '#E5E5E5',  // Light Silver
        //   color6: '#F2F2F2',  // Pale Silver
        //   color7: '#FFFFFF',  // White
        //   color8: '#1A1A1A',  // Dark Charcoal
        // }
        // const palette = {
        //   color1: '#ff3855',  // Vivid Red
        //   color2: '#00bfff',  // Sky Blue
        //   color3: '#ffaa00',  // Golden Yellow
        //   color4: '#6a0572',  // Deep Purple
        //   color5: '#33cc33',  // Electric Green
        //   color6: '#ff66b2',  // Pink Rose
        //   color7: '#ffa500',  // Orange
        //   color8: '#3c1361',  // Dark Indigo
        // }
        const palette = {
          color1: '#B13624',
          color2: '#195767',
          color3: '#8A272B',
          color4: '#816E58',
          color5: '#AB3909',
          color6: '#00462C',
          color7: '#1A3656',
          color8: '#d99734'
        }
        this.currentPalette = palette;
  
        for (let i = 1; i <= 14; i++) {
          const circleId = `circle${i}`;
          const circleElement = document.getElementById(circleId);
          if (circleElement) {
            const colorKey = `color${i <= 8 ? i : i - 8}`;
            const color = this.currentPalette[colorKey] || '#000000';
            circleElement.style.backgroundColor = color;
          }
        }
      },
      setPaletteFromExpression(expression) {
        const palette = palettes.find(p => p.label === expression);
  
        if (palette) {
          this.currentPalette = palette.colors;
  
          // Update the circle colors based on the new palette with a fade transition
          const delay = 50; // Delay between each circle update in milliseconds
          let timeoutId = 0;
  
          for (let i = 1; i <= 14; i++) {
            timeoutId += delay;
            setTimeout(() => {
              const circleId = `circle${i}`;
              const circleElement = document.getElementById(circleId);
              if (circleElement) {
                const colorKey = `color${i <= 8 ? i : i - 8}`;
                const color = this.currentPalette[colorKey] || '#000000';
                circleElement.style.transition = 'background-color 0.5s ease'; // Add transition property
                circleElement.style.backgroundColor = color;
              }
            }, timeoutId);
          }
        }
      }
    },
  };
  </script>
  
  <style scoped lang="scss">
  .vignelli-container {
    display: grid;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    grid-template-columns: repeat(7, 1fr);
  
    .circle {
      width: 4.5rem;
      height: 4.5rem;
      border-radius: 50%;
      font-size: 1.5rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      // cursor: pointer;
      transition: width 0.6s ease, height 0.6s ease;
    }
  }
  </style>
  