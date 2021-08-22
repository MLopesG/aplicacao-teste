<template>
  <div id="app">
    <nav class="navbar header">
      <div class="container">
        <a class="navbar-brand text-white" href="#">
          <b>Cotações produtos</b>
        </a>
      </div>
    </nav>

    <div class="container mt-4 mb-4">
      <router-view />
    </div>
  </div>
</template>

<style scoped>
  .header{
    background: #1979c3;
  }
</style>
