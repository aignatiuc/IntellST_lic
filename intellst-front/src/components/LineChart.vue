<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
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
            data: [40, 39, 13, 40, 39, 80, 40],
          },
          {
            label: this.$t("home.graph3"),
            backgroundColor: "#fff",
            data: [10, 40, 39, 80, 40, 23, 14],
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
