import FAQ from "@/views/FAQ.vue";
import { mount, shallowMount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";

Vue.use(Vuetify);
describe("FAQ.vue", () => {
  let wrapper;
  beforeEach(() => {
    wrapper = shallowMount(FAQ, {
      mocks: {
        $t: () => {},
      },
    });
  });

  it("renders", () => {
    expect(wrapper.exists("text-field")).toBe(true);
  });
});

describe("FAQ.vue", () => {
  it("render a text field", () => {
    const wrapper = mount(FAQ, {
      mocks: {
        $t: () => {},
      },
    });
    const text = wrapper.find("v-text-field");
    expect(text.exists()).toBe(false);
  });

  it("render a toolbar", () => {
    const wrapper = mount(FAQ, {
      mocks: {
        $t: () => {},
      },
    });
    const text = wrapper.find("v-toolbar");
    expect(text.exists()).toBe(false);
  });
});
