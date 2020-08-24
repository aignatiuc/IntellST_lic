<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  data() {
    return {
      chartdata: {
        labels: [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday ",
          "Sunday",
        ],
        datasets: [
          {
            label: this.$t("home.graph1"),
            backgroundColor: "#d01919",
            data: [40, 25, 12, 39, 13, 20, 31],
          },
          {
            label: this.$t("home.graph2"),
            backgroundColor: "#515052",
            data: [11, 40, 39, 80, 40, 23, 14],
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    };
  },
  mounted() {
    const app = this;
    this.$nextTick().then(function () {
      app.renderChart(app.chartdata, app.options);
    });
  },
};
</script>
