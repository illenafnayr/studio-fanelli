<template>
  <div>
    <video ref="video" width="640" height="480" autoplay></video>
    <canvas ref="canvas" width="640" height="480"></canvas>
  </div>
</template>

<script>
import * as faceapi from 'face-api.js';

export default {
  name: "FacialRecognition",
  data() {
    return {
      video: null,
      canvas: null,
      modelsLoaded: false,
    };
  },
  mounted() {
    this.initModels();
    this.initCamera();
  },
  methods: {
    async initModels() {
      await Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
        faceapi.nets.faceExpressionNet.loadFromUri('/models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
      ]);

      this.modelsLoaded = true;
    },
    async initCamera() {
      while (!this.modelsLoaded) {
        await new Promise(resolve => setTimeout(resolve, 100));
      }

      this.video = this.$refs.video;
      this.canvas = this.$refs.canvas;

      const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
      this.video.srcObject = stream;

      this.video.addEventListener('play', () => {
        const displaySize = { width: this.video.width, height: this.video.height };
        faceapi.matchDimensions(this.canvas, displaySize);

        setInterval(async () => {
          const detections = await faceapi.detectAllFaces(this.video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors().withFaceExpressions();
          const resizedDetections = faceapi.resizeResults(detections, displaySize);

          this.canvas.getContext('2d').clearRect(0, 0, this.canvas.width, this.canvas.height);
          this.canvas.getContext('2d').drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

          faceapi.draw.drawDetections(this.canvas, resizedDetections);
          faceapi.draw.drawFaceLandmarks(this.canvas, resizedDetections);
          faceapi.draw.drawFaceExpressions(this.canvas, resizedDetections);
        }, 100);
      });
    },
  },
};
</script>

<style scoped lang="scss">
/* Add your component styles here */
</style>
