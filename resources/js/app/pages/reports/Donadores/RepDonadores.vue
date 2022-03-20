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
              icon="UsersIcon"
              class="font-medium-4 me-25"
              size="35"
            />
            <span class="align-middle">Reporte Donadores</span>
          </h4>
        </div>
        <div class="container mt-4 custom-search">
          <div class="custom-search mb-4">
            <b-row>
              <b-col md="4">
                <b-form-group>
                  <label class="mb-2" style="margin-bottom: 20px !important"
                    >Buscador:</label
                  >
                  <b-form-input
                    placeholder="Search"
                    type="text"
                    class="d-inline-block"
                    @input="advanceSearch"
                  />
                </b-form-group>
              </b-col>
            </b-row>
          </div>
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
            <div slot="table-actions">
              <export-excel
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
            </div>
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
  name: "RepDonadores",
  components: {
    VueGoodTable,
    BAvatar,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BRow,
    BCol,
  },
  data() {
    return {
      name_report: "",
      json_fields: {
        ID: "n",
        Email: {
          field: "email",
          callback: (value) => {
            return `${value}`;
          },
        },
        Nombres: {
          field: "nombres",
          callback: (value) => {
            return `${value}`;
          },
        },
        Apellidos: {
          field: "apellidos",
          callback: (value) => {
            return `${value}`;
          },
        },
        TipoDoc: {
          field: "tipoDocumento",
          callback: (value) => {
            return `${value}`;
          },
        },
        Documento: {
          field: "documentoIdentidad",
          callback: (value) => {
            return `${value}´`;
          },
        },
        Pais: {
          field: "pais",
          callback: (value) => {
            return `${value}`;
          },
        },
        Region: {
          field: "region",
          callback: (value) => {
            return `${value}`;
          },
        },
        Telefono: {
          field: "telefono",
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
      pageLength: 5,
      dir: false,
      columns: [
        {
          label: "ID",
          field: "n",
          filterable: false,
        },
        {
          label: "Email",
          field: "email",
          filterable: true,
        },
        {
          label: "Nombres",
          field: "nombres",
          filterable: true,
        },
        {
          label: "Apellidos",
          field: "apellidos",
          filterable: true,
        },
        {
          label: "TipoDoc",
          field: "tipoDocumento",
          filterable: true,
        },
        {
          label: "documento",
          field: "documentoIdentidad",
          filterable: true,
        },
        {
          label: "Pais",
          field: "pais",
          filterable: true,
        },
        {
          label: "Region",
          field: "region",
          filterable: true,
        },
        {
          label: "Telefono",
          field: "telefono",
          filterable: true,
        },
      ],
      rows: [],
      searchTerm: "",
    };
  },
  mounted() {
    this.listarDataDonadores();
  },
  methods: {
    async listarDataDonadores() {
      await this.axios
        .get("/reportes/donadores", {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          this.rows = response.data["rows"];
          this.json_data = response.data["rows"];
          this.name_report = response.data["name_report"];
        })
        .catch((error) => {
          this.rows = [];
        });
    },

    advanceSearch(val) {
      this.searchTerm = val;
    },
  },
};
</script>

<style >
.vgt-table thead th {
  color: #9da0aa !important;
  border-bottom: none !important;
  border: none !important;
  background: #283046 !important;
}
table.vgt-table {
  background-color: #283046 !important;
  border: 1px solid #283046 !important;
}
.vgt-table.bordered td,
.vgt-table.bordered th {
  border: 1px solid #5e6370 !important;
}
table.vgt-table td {
  color: #9da0aa !important;
}
.dark-layout .custom-select,
.dark-layout select.form-control {
  background-color: #283046;
  border-color: #3b4253;
}
.dark-layout .custom-select,
.dark-layout select.form-control {
  color: #b4b7bd;
}
.custom-select {
  padding: 0.438rem 2rem 0.438rem 1rem;
  background: #fff
    url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5'%3E%3Cpath fill='%23d8d6de' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E")
    no-repeat right 1rem center/10px 10px;
}
.custom-select {
  border: 1px solid #d8d6de;
  border-radius: 0.357rem;
}
button,
input,
optgroup,
select,
textarea {
  margin: 0;
}
.custom-select {
  -moz-appearance: none;
  -webkit-appearance: none;
}
.custom-control-label:before,
.custom-file-label,
.custom-select {
  -webkit-transition: background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, background 0s, border-color 0s,
    -webkit-box-shadow 0.15s ease-in-out;
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    background 0s, border-color 0s, -webkit-box-shadow 0.15s ease-in-out;
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out, background 0s, border-color 0s;
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out, background 0s, border-color 0s,
    -webkit-box-shadow 0.15s ease-in-out;
}
.custom-select {
  display: inline-block;
  width: 100%;
  height: 2.714rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.45;
  color: #6e6b7b;
  vertical-align: middle;
  appearance: none;
}
select {
  word-wrap: normal;
}
button,
select {
  text-transform: none;
}
.vgt-global-search {
  border: 1px solid #161d31 !important;
  background: #161d31 !important;
}
</style>
