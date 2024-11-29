<template>
  <div>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
<style lang="scss">
body {
  background-color: #fff;
}
// @import url("https://fonts.googleapis.com/css2?family=VT323&display=swap");
#__nuxt {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  // font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  width: 100%;
  max-width: 100%;
  overflow-x: hidden;
}

html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
}

* {
  box-sizing: border-box;
}

html {
  font-size: 16px;
  @media screen and (max-width: 768px) {
    font-size: 14px;
  }
  @media screen and (max-width: 480px) {
    font-size: 12px;
  }
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  
  @media screen and (max-width: 1200px) {
    max-width: 960px;
  }
  
  @media screen and (max-width: 992px) {
    max-width: 720px;
  }
  
  @media screen and (max-width: 768px) {
    max-width: 540px;
  }
  
  @media screen and (max-width: 576px) {
    max-width: 100%;
  }
}
</style>