import { mount } from "@vue/test-utils";
import HomePage from "@/views/HomePage.vue";
import Vue from "vue";
import Vuetify from "vuetify";
import VueMoment from "vue-moment";
import { Line, Bar } from "vue-chartjs";

Vue.use(VueMoment);
Vue.use(Vuetify);
Vue.use(Line, Bar);

describe("HomePage", () => {
  it("render container", () => {
    const wrapper = mount(HomePage, {
      mocks: {
        $t: () => {},
      },
    });
    const container = wrapper.find("v-container");
    expect(container.exists()).toBe(false);
  });

  it("render row", () => {
    const wrapper = mount(HomePage, {
      mocks: {
        $t: () => {},
      },
    });
    const row = wrapper.find("v-row");
    expect(row.exists()).toBe(false);
  });

  it("render container", () => {
    const wrapper = mount(HomePage, {
      mocks: {
        $t: () => {},
      },
    });
    const col = wrapper.find("v-col");
    expect(col.exists()).toBe(false);
  });
});
