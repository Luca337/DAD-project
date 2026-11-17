<template>
  <div>
    <!-- Menu de navegação simples para testares -->
    <nav>
      <router-link to="/">Início</router-link> | 
      <router-link to="/jogo">Jogar</router-link> | 
      <router-link to="/dashboard">Dashboard</router-link>
    </nav>
    
    <main>
      <!-- As páginas carregam aqui dentro -->
      <router-view></router-view> 
    </main>
  </div>
</template>