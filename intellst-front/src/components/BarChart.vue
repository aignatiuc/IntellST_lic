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
            label: "Data",
            backgroundColor: "#d01919",
            data: [40, 25, 12, 39, 10, 20, 31],
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
