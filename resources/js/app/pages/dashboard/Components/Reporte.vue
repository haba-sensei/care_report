<template>
  <div class="row match-height">
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header">
          <div>
            <h2 class="fw-bolder mb-0">{{ totalTransacciones }}</h2>
            <p class="card-text">Total Donaciones</p>
          </div>
          <router-link class="d-flex align-items-center" to="/general">
            <div class="avatar bg-light-primary p-50 m-0">
              <div class="avatar-content" style="width: 46px; height: 46px">
                <feather-icon icon="TrendingUpIcon" />
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header">
          <div>
            <h2 class="fw-bolder mb-0">{{ totalTransPuntuales }}</h2>
            <p class="card-text">Donaciones Unicas</p>
          </div>
          <router-link class="d-flex align-items-center" to="/unico">
            <div class="avatar bg-light-success p-50 m-0">
              <div class="avatar-content" style="width: 46px; height: 46px">
                <feather-icon icon="ZapIcon" />
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header">
          <div>
            <h2 class="fw-bolder mb-0">{{ totalTransMensuales }}</h2>
            <p class="card-text">Donaciones Mensuales</p>
          </div>
          <router-link class="d-flex align-items-center" to="/mensual">
            <div class="avatar bg-light-danger p-50 m-0">
              <div class="avatar-content" style="width: 46px; height: 46px">
                <feather-icon icon="CalendarIcon" />
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header">
          <div>
            <h2 class="fw-bolder mb-0">{{ totalDonadores }}</h2>
            <p class="card-text">Total Donadores</p>
          </div>
          <router-link class="d-flex align-items-center" to="/donadores">
            <div class="avatar bg-light-warning p-50 m-0">
              <div class="avatar-content" style="width: 46px; height: 46px">
                <feather-icon icon="UsersIcon" />
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Reporte",
  data() {
    return {
      totalTransacciones: "0",
      totalTransPuntuales: "0",
      totalTransMensuales: "0",
      totalDonadores: "0",
    };
  },
  mounted() {
    this.listarReporte();
  },
  methods: {
    async listarReporte() {
      await this.axios
        .get("/reportes/basico", {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.totalTransacciones = response.data.totalTransacciones;
          this.totalTransPuntuales = response.data.totalTransPuntuales;
          this.totalTransMensuales = response.data.totalTransMensuales;
          this.totalDonadores = response.data.totalDonadores;
        })
        .catch((error) => {
          this.totalTransacciones = "0";
          this.totalTransPuntuales = "0";
          this.totalTransMensuales = "0";
          this.totalDonadores = "0";
        });
    },
  },
};
</script>
