<template>
  <div
    class="main-menu menu-fixed menu-dark menu-accordion menu-shadow"
    data-scroll-to-active="true"
  >
    <div class="navbar-header">
      <ul class="flex-row nav navbar-nav">
        <li class="nav-item me-auto">
          <a class="navbar-brand" href="#"
            ><span class="brand-logo">
              <img
                src="images/favicon.png"
                alt="logo"
                width="32"
                height="32"
              />
            </span>
            <h2 class="brand-text">CARE | APP</h2>
          </a>
        </li>
      </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
      <ul
        class="navigation navigation-main"
        id="main-menu-navigation"
        data-menu="menu-navigation"
      >
        <li class="navigation-header">
          <span>Modulos</span>
        </li>
        <li class="nav-item">
          <router-link class="d-flex align-items-center" to="/">
            <feather-icon icon="HomeIcon" size="14" />
            <span class="menu-title text-truncate">Home</span>
          </router-link>
        </li>
         <li class="nav-item" >
          <router-link class="d-flex align-items-center" to="/campaign">
            <feather-icon icon="AwardIcon" size="14" />
            <span class="menu-title text-truncate">Campañas</span>
          </router-link>
        </li>
        <li class="navigation-header">
          <span>Donaciones</span>
        </li>
        <li class="nav-item" >
          <router-link class="d-flex align-items-center" to="/general">
            <feather-icon icon="TrendingUpIcon" size="14" />
            <span class="menu-title text-truncate">Reporte General</span>
          </router-link>
        </li>
        <li class="nav-item" >
          <router-link class="d-flex align-items-center" to="/unico">
            <feather-icon icon="ZapIcon" size="14" />
            <span class="menu-title text-truncate">Reporte Unico</span>
          </router-link>
        </li>
        <li class="nav-item" >
          <router-link class="d-flex align-items-center" to="/mensual">
            <feather-icon icon="CalendarIcon" size="14" />
            <span class="menu-title text-truncate">Reporte Mensual</span>
          </router-link>
        </li>
        <li class="nav-item" >
          <router-link class="d-flex align-items-center" to="/donadores">
            <feather-icon icon="UsersIcon" size="14" />
            <span class="menu-title text-truncate">Reporte Donadores</span>
          </router-link>
        </li>

        <li class="navigation-header" v-if="user.role == 'admin'">
          <span>Gestion de usuarios</span>
        </li>

        <li class="nav-item" v-if="user.role == 'admin'">
          <router-link class="d-flex align-items-center" to="/usuarios">
            <feather-icon icon="UserIcon" />
            <span class="menu-title text-truncate">Usuarios</span>
          </router-link>
        </li>




      </ul>
    </div>
  </div>
</template>

<script>

import { mapGetters } from "vuex";
export default {
  name: "Sidebar",
  computed: {
    ...mapGetters({ user: "getUser" }),
  },
};
</script>
