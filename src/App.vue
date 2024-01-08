<template>
  <nav>
    <!-- <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link> -->
  </nav>
  <router-view/>
</template>

<style lang="scss">
body {
  background-color: #fff
}
// @import url("https://fonts.googleapis.com/css2?family=VT323&display=swap");
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  // font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;

    &.router-link-exact-active {
    }
  }
}
</style>
