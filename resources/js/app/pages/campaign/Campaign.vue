<template>
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
      <div class="content-header row"></div>
      <div class="content-body">
        <div class="col-12">
          <h4 class="mb-3 mt-3">
            <feather-icon
              icon="AwardIcon"
              class="font-medium-4 me-25"
              size="35"
            />
            <span class="align-middle">Campañas</span>
          </h4>
        </div>
        <form class="form-validate">
          <div class="row mt-1">
            <div class="col-md-4">
              <div class="mb-3 mt-3">
                <label class="form-label" for="name">Campaña</label>
                <input
                  id="name"
                  v-model="campaign.name"
                  type="text"
                  class="form-control"
                  placeholder="Ingresa la campaña"
                  name="name"
                  autocomplete="off"
                />
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3 mt-3">
                <label class="form-label" for="meta">Meta</label>
                <input
                  id="meta"
                  type="number"
                  v-model="campaign.meta"
                  class="form-control"
                  placeholder="Ingresa tu meta"
                  name="meta"
                  autocomplete="off"
                />
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3 mt-3">
                <label class="form-label" for="name">Fecha inicio</label>
                <!--  -->
                <flat-pickr
                  v-model="campaign.fecha_init"
                  :config="config"
                  class="form-control flat-picker border-0 shadow-none"
                  placeholder="YYYY-MM-DD"
                />
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3 mt-3">
                <label class="form-label" for="name">Fecha Finalización</label>
                <flat-pickr
                  v-model="campaign.fecha_end"
                  :config="config"
                  class="form-control flat-picker border-0 shadow-none"
                  placeholder="YYYY-MM-DD"
                />
              </div>
            </div>
            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
              <button
                type="submit"
                v-if="editarBtn != true"
                @click.prevent="crear"
                class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1"
              >
                Guardar Cambios
              </button>
              <template v-else>
                <div>
                  <button
                    type="submit"
                    @click.prevent="actualizar"
                    class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1"
                  >
                    Actualizar Cambios
                  </button>
                  <button
                    type="button"
                    @click.prevent="clearData"
                    class="btn btn-danger mb-1 mb-sm-0 me-0 me-sm-1"
                  >
                    Cancelar
                  </button>
                </div>
              </template>
            </div>
          </div>
        </form>
        <div class="container mt-4 custom-search">
          <div class="row">
            <div class="col-md-7">
              <vue-good-table
                :columns="columns"
                :rows="rows"
                :search-options="{
                  enabled: true,
                  externalQuery: searchTerm,
                }"
                :pagination-options="{
                  enabled: true,
                  perPage: pageLength,
                }"
                theme="my-theme"
              >
                <template slot="table-row" slot-scope="props">
                  <span v-if="props.column.field === 'action'">
                    <div class="row">
                      <div class="col-md-4">
                        <button
                          class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1"
                          @click="verDetalles(props.row.id_campaign)"
                        >
                          <feather-icon
                            icon="AwardIcon"
                            class="mr-50"
                            size="18"
                          />
                        </button>
                      </div>
                      <div class="col-md-4">
                        <button
                          class="btn-sm btn-danger mb-1 mb-sm-0 me-0 me-sm-1"
                          @click="eliminar(props.row.id)"
                        >
                          <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                            size="18"
                          />
                        </button>
                      </div>
                    </div>
                  </span>
                </template>
                <!-- pagination -->
                <template slot="pagination-bottom" slot-scope="props">
                  <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mb-0 mt-4">
                      <span class="text-nowrap"> Mostrando 1 de </span>
                      <b-form-select
                        v-model="pageLength"
                        :options="['3', '5', '10']"
                        class="mx-1"
                        @input="
                          (value) =>
                            props.perPageChanged({ currentPerPage: value })
                        "
                      />
                      <span class="text-nowrap">
                        a {{ props.total }} entradas
                      </span>
                    </div>
                    <div>
                      <b-pagination
                        :value="1"
                        :total-rows="props.total"
                        :per-page="pageLength"
                        first-number
                        last-number
                        align="right"
                        prev-class="prev-item"
                        next-class="next-item"
                        class="mt-4 mb-0"
                        @input="
                          (value) => props.pageChanged({ currentPage: value })
                        "
                      >
                        <template #prev-text>
                          <feather-icon icon="ChevronLeftIcon" size="18" />
                        </template>
                        <template #next-text>
                          <feather-icon icon="ChevronRightIcon" size="18" />
                        </template>
                      </b-pagination>
                    </div>
                  </div>
                </template>
              </vue-good-table>
            </div>
            <div class="col-md-5">
              <b-card v-if="data" no-body>
                <b-card-header class="text-center centrado_fuerte">
                  <h4 class="mb-0" v-if="this.meta_resume == ''">
                    Resumen de la meta
                  </h4>
                  <h4 class="mb-0" v-else>{{ this.campaign.name }}</h4>
                </b-card-header>
                <apexcharts
                  type="radialBar"
                  height="245"
                  class="my-2"
                  :options="goalOverviewRadialBar"
                  :series="data"
                />
                <export-excel
                v-if="this.meta_resume != ''"
                class="btn btn-sm btn-primary"
                style="
                  margin-bottom: 10px;
                  border: none;
                  background: #1d6f42 !important;
                "
                :data="json_data"
                :fields="json_fields"
                worksheet="My Worksheet"
                :name="name_report"
              >
                <feather-icon icon="FileTextIcon" size="16" /> Exportar en Excel
              </export-excel>

                <template v-if="this.meta_resume != ''">
                  <b-row class="text-center mx-0">
                    <b-col
                      cols="12"
                      class="
                        border-top border-right
                        d-flex
                        align-items-between
                        flex-column
                        py-1
                      "
                    >
                      <h3
                        class="font-weight-bolder mb-0"
                        style="color: #faa420; padding: 8px"
                      >
                        {{ this.meta_resume }}
                      </h3>
                      <span class="mb-1"
                        >Meta S/. {{ this.campaign.meta }}</span
                      >
                    </b-col>
                  </b-row>
                  <b-row class="text-center mx-0">
                    <b-col
                      cols="6"
                      class="
                        border-top border-right
                        d-flex
                        align-items-between
                        flex-column
                        py-1
                      "
                    >
                      <b-card-text class="text-muted mb-0">
                        Donaciones completadas
                      </b-card-text>
                      <h3 class="font-weight-bolder mb-0">
                        S/ {{ this.total_donaciones }}
                      </h3>
                    </b-col>
                    <b-col
                      cols="6"
                      class="
                        border-top
                        d-flex
                        align-items-between
                        flex-column
                        py-1
                      "
                    >
                      <template v-if="this.meta_resume != 'Meta cumplida' ">
                        <div>
                          <b-card-text class="text-muted mb-0">
                            Donaciones faltantes
                          </b-card-text>
                          <h3 class="font-weight-bolder mb-0">
                            S/ {{ this.donacion_faltante }}
                          </h3>
                        </div>
                      </template>
                      <template v-else>
                        <div>
                          <b-card-text class="text-muted mb-0">
                            Donaciones adicionales
                          </b-card-text>
                          <h3 class="font-weight-bolder mb-0">
                            S/ {{ this.donacion_faltante }}
                          </h3>
                        </div>
                      </template>
                    </b-col>
                  </b-row>
                  <br />
                  <b-row class="text-center mx-0">
                    <b-col
                      cols="6"
                      class="
                        border-top border-right
                        d-flex
                        align-items-between
                        flex-column
                        py-1
                      "
                    >
                      <b-card-text class="text-muted mb-0">
                        Fecha de inicio
                      </b-card-text>
                      <h3 class="font-weight-bolder mb-0">
                        {{ this.campaign.fecha_init }}
                      </h3>
                    </b-col>
                    <b-col
                      cols="6"
                      class="
                        border-top
                        d-flex
                        align-items-between
                        flex-column
                        py-1
                      "
                    >
                      <b-card-text class="text-muted mb-0">
                        Fecha de finalización
                      </b-card-text>
                      <h3
                        class="font-weight-bolder mb-0"
                        :class="confirm_date_class"
                      >
                        {{ this.campaign.fecha_end }}
                      </h3>
                    </b-col>
                  </b-row>
                  <br />
                  <b-row class="text-center mx-0">
                    <b-col
                      cols="12"
                      class="
                        border-top border-right
                        d-flex
                        align-items-between
                        flex-column
                        py-1
                      "
                    >
                      <b-card-text class="mb-0">
                        Codigo de la campaña
                      </b-card-text>
                      <h3
                        class="font-weight-bolder mb-0"
                        style="color: #faa420"
                      >
                        {{ this.codigo }}
                      </h3>
                    </b-col>
                  </b-row>
                  <br />
                </template>
              </b-card>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import {
  BCard,
  BCardHeader,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BRow,
  BCol,
  BPagination,
  BCardText,
} from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
const $strokeColor = "#ebe9f1";
const $textHeadingColor = "#5e5873";
const $goalStrokeColor2 = "#51e5a8";
import flatPickr from "vue-flatpickr-component";
import { Spanish } from "flatpickr/dist/l10n/es.js";
import ToastificationContent from "../../components/ToastificationContent.vue";

export default {
  name: "Campaign",
  components: {
    apexcharts: VueApexCharts,
    VueGoodTable,
    flatPickr,
    BCard,
    BCardHeader,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BRow,
    BCardText,
    BCol,
  },
  data() {
    return {
      editarBtn: false,
      data: ["0"],
      total_donaciones: 0,
      donacion_faltante: 0,
      meta_resume: "",
      campaign: {
        id: 0,
        name: "",
        meta: "",
        fecha_init: "",
        fecha_end: "",
      },
      codigo: "",
      confirm_date_class: "",
      pageLength: 5,
      dir: false,
      rows: [],
      searchTerm: "",
      columns: [
        {
          label: "ID",
          field: "n",
          filterable: false,
        },
        {
          label: "Campaña",
          field: "name",
          filterable: true,
        },
        {
          label: "Action",
          field: "action",
        },
      ],
      goalOverviewRadialBar: {
        chart: {
          height: 245,
          type: "radialBar",
          sparkline: {
            enabled: true,
          },
          dropShadow: {
            enabled: true,
            blur: 3,
            left: 1,
            top: 1,
            opacity: 0.1,
          },
        },
        colors: [$goalStrokeColor2],
        plotOptions: {
          radialBar: {
            offsetY: -10,
            startAngle: -150,
            endAngle: 150,
            hollow: {
              size: "77%",
            },
            track: {
              background: $strokeColor,
              strokeWidth: "50%",
            },
            dataLabels: {
              name: {
                show: false,
              },
              value: {
                color: $textHeadingColor,
                fontSize: "2.86rem",
                fontWeight: "600",
              },
            },
          },
        },
        fill: {
          type: "gradient",
          gradient: {
            shade: "dark",
            type: "horizontal",
            shadeIntensity: 0.5,
            gradientToColors: ["#51e5a8"],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100],
          },
        },
        stroke: {
          lineCap: "round",
        },
        grid: {
          padding: {
            bottom: 30,
          },
        },
      },
      config: {
        mode: "single",
        locale: Spanish,
      },
      json_fields: {
        ID: "n",
        Transaccion: {
          field: "transaccion_id",
          callback: (value) => {
            return `${value}´`;
          },
        },
        Donador: {
          field: "user_id",
          callback: (value) => {
            return `${value}´`;
          },
        },
        Monto: {
          field: "monto",
          callback: (value) => {
            return `${value}´`;
          },
        },
        Tipo: "tipo_donacion",
        Fecha: {
          field: "created_at",
          callback: (value) => {
            return `${value}´`;
          },
        },
      },
      json_data: [],
      json_meta: [
        [
          {
            key: "charset",
            value: "utf-8",
          },
        ],
      ],
      rangePicker: ["2022-01-01"],
    };
  },
  mounted() {
    this.campaings();
  },
  methods: {
    async campaings() {
      await this.axios
        .get("/campaign/listar", {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.rows = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async crear() {
      await this.axios
        .post("/campaign/create", this.campaign, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.clearData();
          this.campaings();
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Notificacion",
              icon: "BellIcon",
              text: "Se ha creado una campaña nueva",
              variant: "info",
            },
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async actualizar() {
      await this.axios
        .post("/campaign/actualizar", this.campaign, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.clearData();
          this.campaings();
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Notificacion",
              icon: "BellIcon",
              text: "Se ha actualizado el usuario",
              variant: "info",
            },
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async verDetalles(id) {
      await this.axios
        .get("/campaign/detalles/" + id, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.editarBtn = true;
          this.data = [response.data["porcentaje"]];

          this.campaign.id = response.data["id"];
          this.campaign.name = response.data["name"];
          this.campaign.meta = response.data["meta"];
          this.campaign.fecha_init = response.data["fecha_init"];
          this.campaign.fecha_end = response.data["fecha_end"];

          this.total_donaciones = response.data["donacion_total"];
          this.donacion_faltante = response.data["donacion_faltante"];
          this.meta_resume = response.data["meta_resume"];

          this.codigo = response.data["codigo"];
          let confirm_date = this.$moment().isSameOrBefore(
            response.data["fecha_end"]
          );
          confirm_date
            ? (this.confirm_date_class = "text-success")
            : (this.confirm_date_class = "text-danger");

          this.json_data = response.data['rows'];
          this.name_report = response.data['name_report'];
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async eliminar(id) {
      await Vue.swal({
        title: "¿Quieres eliminar la campaña? ",
        icon: "question",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si Eliminar",
        denyButtonText: `No Eliminar`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.axios
            .get("/campaign/eliminar/" + id, {
              headers: {
                Authorization: "Bearer " + this.$store.state.token,
              },
            })
            .then((response) => {
              this.clearData();
              this.campaings();
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: "Notificacion",
                  icon: "BellIcon",
                  text: "Se ha eliminado la campaña",
                  variant: "info",
                },
              });
            })
            .catch((error) => {});
        } else if (result.isDenied) {
        }
      });
    },

    clearData() {
      this.editarBtn = false;
      this.data = ["0"];
      this.total_donaciones = 0;
      this.donacion_faltante = 0;
      this.meta_resume = "";

      this.campaign.id = 0;
      this.campaign.meta = "";
      this.campaign.name = "";
      this.campaign.fecha_init = "";
      this.campaign.fecha_end = "";

      this.codigo = "";
      this.confirm_date_class = "";
    },
  },
};
</script>


<style scoped>
.centrado_fuerte {
  justify-content: center !important;
}
</style>
