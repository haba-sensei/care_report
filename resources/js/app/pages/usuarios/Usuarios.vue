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
              icon="UserIcon"
              class="font-medium-4 me-25"
              size="35"
            />
            <span class="align-middle">Usuarios</span>
          </h4>
        </div>
        <div class="container mt-4 custom-search">
          <form class="form-validate">
            <div class="row mt-1">
              <div class="col-lg-4 col-md-6">
                <div class="mb-3 mt-3">
                  <label class="form-label" for="name">NICK</label>
                  <input
                    id="name"
                    v-model="usuario.name"
                    type="text"
                    class="form-control"
                    placeholder="Ingresa un nick"
                    name="name"
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="mb-3 mt-3">
                  <label class="form-label" for="email">Email</label>
                  <input
                    id="email"
                    v-model="usuario.email"
                    type="email"
                    class="form-control"
                    placeholder="Ingresa tu email"
                    name="email"
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="mb-3 mt-3">
                  <label class="form-label" for="name">Password</label>
                  <input
                    id="password"
                    v-model="usuario.password"
                    type="password"
                    class="form-control"
                    placeholder="Ingresa un password"
                    name="password"
                    autocomplete="off"
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
                      type="submit"
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
          <br />
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
                <button
                  class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1"
                  @click="editar(props.row.id)"
                >
                  <feather-icon icon="Edit2Icon" class="mr-50" size="18" />
                  <span>Editar</span>
                </button>
                <button class="btn-sm btn-danger mb-1 mb-sm-0 me-0 me-sm-1"
                 @click="eliminar(props.row.id)"
                >
                  <feather-icon icon="TrashIcon" class="mr-50" size="18" />
                  <span>Eliminar</span>
                </button>
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
                      (value) => props.perPageChanged({ currentPerPage: value })
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
      </div>
    </div>
  </div>
</template>

<script>
import { VueGoodTable } from "vue-good-table";
import ToastificationContent from "../../components/ToastificationContent.vue";
import {
  BAvatar,
  BPagination,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BRow,
  BCol,
} from "bootstrap-vue";
export default {
  name: "Usuarios",
  components: {
    VueGoodTable,
    ToastificationContent,
    BAvatar,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BRow,
    BCol,
  },
  mounted() {
    this.listar();
  },
  data() {
    return {
      editarBtn: false,
      usuario: {
        id: 0,
        name: "",
        email: "",
        password: "",
      },
      usuarios: [],
      pageLength: 5,
      dir: false,
      columns: [
        {
          label: "ID",
          field: "n",
          filterable: false,
        },
        {
          label: "Nick",
          field: "name",
          filterable: true,
        },
        {
          label: "Email",
          field: "email",
          filterable: true,
        },
        {
          label: "Action",
          field: "action",
        },
      ],
      rows: [],
      searchTerm: "",
    };
  },
  methods: {

    async crear() {
      await this.axios
        .post("/usuarios/create", this.usuario, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.clearData();
          this.listar();
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Notificacion",
              icon: "BellIcon",
              text: "Se ha creado un usuario nuevo",
              variant: "info",
            },
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async listar() {
      await this.axios
        .get("/usuarios/listar", {
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

    async editar(id) {
      await this.axios
        .get("/usuarios/editar/" + id, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.editarBtn = true;
          this.usuario.id = response.data[0]["id"];
          this.usuario.name = response.data[0]["name"];
          this.usuario.email = response.data[0]["email"];
          this.usuario.password = "";
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async actualizar() {
      await this.axios
        .post("/usuarios/actualizar", this.usuario, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.clearData();
          this.listar();
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

    async eliminar(id) {
      await Vue.swal({
        title: "¿Quieres eliminar el usuario? ",
        icon: "question",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si Eliminar",
        denyButtonText: `No Eliminar`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.axios
            .get("/usuarios/eliminar/" + id, {
              headers: {
                Authorization: "Bearer " + this.$store.state.token,
              },
            })
            .then((response) => {

              this.clearData();
              this.listar();
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: "Notificacion",
                  icon: "BellIcon",
                  text: "Se ha eliminado el usuario",
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
      this.usuario.id = "";
      this.usuario.name = "";
      this.usuario.email = "";
      this.usuario.password = "";
    },
  },
};
</script>
