<template>
  <div :class="classObj" class="layout-wrapper">
    <!--left side-->
    <div v-if="device =='mobile'&& sidebar.opened" class="drawer-bg" />
    <Sidebar v-if="settings.showLeftMenu" class="sidebar-container" />
    <!--right container-->
    <div class="main-container">
      <Navbar v-if="settings.showTopNavbar" />
      <TagsView v-if="settings.showTagsView" />
      <AppMain />
    </div>
  </div>
</template>
<script setup lang="ts">
import { computed, onMounted } from 'vue'
import Sidebar from './sidebar/index.vue'
import AppMain from './app-main/index.vue'
import Navbar from './app-main/Navbar.vue'
import TagsView from './app-main/TagsView.vue'
import { useBasicStore } from '@/store/auth'
import { resizeHandler } from '@/hooks/use-layout'
const { device, sidebar, settings } = useBasicStore()


const mixins = [resizeHandler()];



const classObj = computed(() => {
  return {
    closeSidebar: !sidebar.opened,
    hideSidebar: !settings.showLeftMenu,
    withoutAnimation: sidebar.withoutAnimation,
    mobile: device == 'mobile'
  }
}) 

</script>

<style lang="scss" scoped>
.layout-wrapper {
  position: relative;
  height: 100%;
  width: 100%;
  // &.mobile.openSidebar {
  //   position: fixed;
  //   top: 0;
  // }
}
// .mobile {
//   .main-container {
//     margin-left: 0;
//   }
//   .sidebar-container {
//     -webkit-transition: -webkit-transform .28s;
//     transition: -webkit-transform .28s;
//     transition: transform .28s;
//     transition: transform .28s,-webkit-transform .28s;
//     width: 210px!important;
//   }
// }
.closeSidebar {
    // position: fixed;
    top: 0;
}
// .drawer-bg {
//     background: #000;
//     opacity: .3;
//     width: 100%;
//     top: 0;
//     height: 100%;
//     position: absolute;
//     z-index: 999;
// }
.main-container {
  min-height: 100%;
  transition: margin-left var(--sideBar-switch-duration);
  margin-left: var(--side-bar-width);
  position: relative;
}
.sidebar-container {
  transition: width var(--sideBar-switch-duration);
  width: var(--side-bar-width) !important;
  background-color: var(--el-menu-bg-color);
  height: 100%;
  position: fixed;
  font-size: 0;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 1001;
  overflow: hidden;
  border-right: 0.5px solid var(--side-bar-border-right-color);
}
.closeSidebar {
  .sidebar-container {
    width: 0px !important;
  }
  .main-container {
    margin-left: 0px !important;
  }
}
.hideSidebar .fixed-header {
  width: calc(100% - 0px)
}
.hideSidebar {
  .sidebar-container {
    width: 0 !important;
  }
  .main-container {
    margin-left: 0;
  }
}
</style>
