<template>
  <div class="menu-bar">
    <el-menu theme="dark" class="menu-list scrollbar" :router="true">
      <el-menu-item v-for="menu in $store.state.menus" :index="menu.url" :key="menu.id" v-if="!menu.children.length">
        <i :class="menu.icon"></i>
        {{menu.name}}
      </el-menu-item>
      <el-submenu v-for="menu in $store.state.menus" :index="menu.id.toString()" :key="menu.id"
                  v-if="menu.children.length">
        <template slot="title"><i :class="menu.icon"></i>{{menu.name}}</template>
        <el-menu-item v-for="subMenu in menu.children" :index="subMenu.url" :key="subMenu.id">
          {{subMenu.name}}
        </el-menu-item>
      </el-submenu>
    </el-menu>
  </div>
</template>

<script>
  export default {
    name: 'menuBar',
    mounted () {
      if (!this.$store.state.menu) this.$store.dispatch('getMenu')
    }
  }
</script>

<style lang="scss">
  .menu-bar{
    .menu-list {
      height: 90vh;
    }
    .scrollbar{

    }
  }
</style>
