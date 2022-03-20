<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <div class="d-flex align-items-center">
          <feather-icon icon="CalendarIcon" size="16" />
          <flat-pickr
            v-model="rangePicker"
            @on-change="onChange($event)"
            :config="config"
            class="form-control flat-picker bg-transparent border-0 shadow-none"
            placeholder="YYYY-MM-DD"
          />
        </div>
      </div>
      <div class="col-md-9 ">
          <button class="btn btn-sm btn-primary" @click.prevent="onDefault()" style="float: right; width: 18%; margin-bottom: 10px;"><feather-icon icon="RefreshCwIcon" size="16" />  Reset</button>
      </div>
    </div>
    <div class="example">
      <apexcharts
        height="350"
        type="line"
        :options="chartOptions"
        :series="series"
      ></apexcharts>
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import flatPickr from "vue-flatpickr-component";
import moment from "moment";
import { Spanish } from "flatpickr/dist/l10n/es.js";

export default {
  name: "Chart",
  components: {
    flatPickr,
    apexcharts: VueApexCharts,
  },
  mounted() {
    this.listarDataReport(this.rangePicker);
  },
  data: function () {
    return {
      config: {
        mode: "range",
        locale: Spanish,
      },
      chartOptions: {
        chart: {
          id: "basic-bar",
          zoom: {
            enabled: true,
          },
          toolbar: {
            show: true,
          },
        },
        markers: {
          strokeWidth: 7,
          strokeOpacity: 1,
          strokeColors: ["#826af9"],
          colors: ["#826af9"],
        },
        colors: ["#e36f1e"],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "straight",
        },
        grid: {
          xaxis: {
            lines: {
              show: true,
            },
          },
        },
        tooltip: {
          custom(data) {
            return `${'<div class="px-1 py-50"><span>S/.'}${
              data.series[data.seriesIndex][data.dataPointIndex]
            }</span></div>`;
          },
        },
        xaxis: {
          categories: [],
        },
      },
      series: [
        {
          data: [],
        },
      ],
      rangePicker: ["2022-01-01", moment().format("YYYY-MM-DD")],
    };
  },
  methods: {
    onChange: function (event) {
      this.listarDataReport(this.rangePicker);
    },
    onDefault() {

      this.rangePicker = ["2022-01-01", moment().format("YYYY-MM-DD")];
      this.listarDataReport(this.rangePicker);
    },
    async listarDataReport(rangePicker) {
      await this.axios
        .get("/reportes/allReport/" + rangePicker, {
          headers: {
            Authorization: "Bearer " + this.$store.state.token,
          },
        })
        .then((response) => {
          var vm = this;

          vm.chartOptions = {
            ...vm.chartOptions,
            ...{
              xaxis: {
                categories: response.data["fechas_generales"],
              },
            },
          };

          vm.series = [
            {
              name: "series-1",
              type: "line",
              data: response.data["montos_generales"],
            },
          ];
        })
        .catch((error) => {
          //   this.initDate = moment().format("YYYY-MM-DD");
        });
    },
  },
};
</script>
