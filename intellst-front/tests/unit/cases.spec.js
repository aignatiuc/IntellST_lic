import { mount } from "@vue/test-utils";
import ConsultCases from "@/views/ConsultCases.vue";
import Vue from "vue";
import Vuetify from "vuetify";
import VueMoment from "vue-moment";

Vue.use(VueMoment);
Vue.use(Vuetify);

describe("ConsultCases", () => {
  it("render container", () => {
    const wrapper = mount(ConsultCases, {
      mocks: {
        $t: () => {},
      },
    });
    const container = wrapper.find("v-container");
    expect(container.exists()).toBe(false);
  });

  it("render toolbar", () => {
    const wrapper = mount(ConsultCases, {
      mocks: {
        $t: () => {},
      },
    });
    const toolbar = wrapper.find("v-toolbar");
    expect(toolbar.exists()).toBe(false);
  });

  it("render expansion panel", () => {
    const wrapper = mount(ConsultCases, {
      mocks: {
        $t: () => {},
      },
    });
    const panel = wrapper.find("v-expansion-panel");
    expect(panel.exists()).toBe(false);
  });
});
