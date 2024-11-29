<template>
  <div class="video-container">
    <video ref="video" width="1" height="1" autoplay></video>
  </div>
</template>

<script>
import * as faceapi from 'face-api.js';

export default {
  name: "FacialRecognition",
  props: {
    active: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      video: null,
      canvas: null,
      modelsLoaded: false,
    };
  },
  watch: {
    active(isActive) {
      if (isActive) {
        this.initCamera();
      } else {
        this.stopCamera();
      }
    },
  },
  mounted() {
    this.initModels();
  },
  methods: {
    async initModels() {
        console.log(faceapi.nets)
      await Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
        faceapi.nets.faceExpressionNet.loadFromUri('/models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
      ]);

      this.modelsLoaded = true;
    },
    async initCamera() {
      while (!this.modelsLoaded) {
        await new Promise(resolve => setTimeout(resolve, 1000));
      }

      this.video = this.$refs.video;
      // this.canvas = this.$refs.canvas;

      const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
      this.video.srcObject = stream;

      this.video.addEventListener('play', () => {
        // const displaySize = { width: this.video.width, height: this.video.height };
        // faceapi.matchDimensions(this.canvas, displaySize);

        setInterval(async () => {
          try {
            const detections = await faceapi.detectAllFaces(this.video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors().withFaceExpressions();
            // console.log("Detections: ", detections[0].expressions)
            let currentExpression = this.findMaxExpression(detections[0].expressions)
            this.$emit('current-expression', currentExpression)
          } catch (error) {
            // swallow
          }


        }, 1000);
      });
    },

    stopCamera() {
      if (this.video && this.video.srcObject) {
        const tracks = this.video.srcObject.getTracks();
        tracks.forEach(track => track.stop());
        this.video.srcObject = null;
        this.video.pause();
      }
    },

    findMaxExpression(expressions) {
      let maxExpression = "";
      let maxValue = -Infinity;

      for (let expression in expressions) {
        if (expressions[expression] > maxValue) {
          maxExpression = expression;
          maxValue = expressions[expression];
        }
      }

      return maxExpression;
    }
  },
};
</script>

<style scoped lang="scss">
.video-container {
  height: 0;
}
</style>
